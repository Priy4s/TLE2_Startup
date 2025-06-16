<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\GenericProvider;
use Microsoft\Graph\Model;

class MicrosoftController extends Controller
{
    protected $oauthClient;

    public function __construct()
    {


        $tenantId = 'common';
        $clientId = env('AZURE_CLIENT_ID');
        $clientSecret = env('AZURE_CLIENT_SECRET');
        $redirectUri = env('AZURE_REDIRECT_URI');

        if (!$tenantId || !$clientId || !$clientSecret || !$redirectUri) {
            throw new \Exception("Azure AD configuratie ontbreekt in .env");
        }

        $this->oauthClient = new GenericProvider([
            'clientId'                => $clientId,
            'clientSecret'            => $clientSecret,
            'redirectUri'             => $redirectUri,
            'urlAuthorize'            => "https://login.microsoftonline.com/$tenantId/oauth2/v2.0/authorize",
            'urlAccessToken'          => "https://login.microsoftonline.com/$tenantId/oauth2/v2.0/token",
            'urlResourceOwnerDetails' => '',
        ]);
    }

    // Stap 1: stuur gebruiker naar Microsoft login
    public function redirectToProvider(Request $request)
    {
        // AANGEPAST: We vragen nu ook schrijfrechten voor bestanden.
        $authUrl = $this->oauthClient->getAuthorizationUrl([
            'scope' => 'User.Read Files.ReadWrite.All',
            'response_mode' => 'query',
        ]);

        session(['oauth2state' => $this->oauthClient->getState()]);

        return redirect()->away($authUrl);
    }

    // Stap 2: callback verwerken, token ophalen en opslaan
    public function handleProviderCallback(Request $request)
    {
        if (!$request->has('code')) {
            // TIJDELIJKE DEBUG STAP: Toon alle parameters die we van Microsoft terugkrijgen.
            // Als je een fout krijgt, haal dan de '//' voor de volgende regel weg.
            // dd($request->all());
            abort(400, 'Authorization code ontbreekt. Mogelijk een configuratiefout in Azure of .env');
        }

        $sessionState = session('oauth2state');
        $requestState = $request->input('state');

        if (empty($requestState) || ($requestState !== $sessionState)) {
            session()->forget('oauth2state');
            abort(400, 'Ongeldige state parameter');
        }

        try {
            $accessToken = $this->oauthClient->getAccessToken('authorization_code', [
                'code' => $request->input('code'),
            ]);

            session([
                'ms_token' => $accessToken->getToken(),
                'ms_refresh_token' => $accessToken->getRefreshToken(),
                'ms_token_expiry' => $accessToken->getExpires(),
            ]);

            \Log::info('Access token scopes:', ['scopes' => $accessToken->getValues()['scope'] ?? '']);
            session()->forget('oauth2state');

            return redirect()->route('microsoft.dashboard');

        } catch (\Exception $e) {
            \Log::error('Token exchange failed', ['error_message' => $e->getMessage()]);
            return redirect('/')->withErrors('Login fout: ' . $e->getMessage());
        }
    }

    // Dashboard tonen met gebruikersinfo en OneDrive-bestanden
    public function showDashboard(Request $request)
    {
        if (!$accessToken = session('ms_token')) {
            return redirect()->route('microsoft.login');
        }

        try {
            $graphService = new \App\Services\MicrosoftGraphService($accessToken);
            $graph = $graphService->getGraph();

            // 1. Haal de gebruikersinformatie op voor de naam
            $user = $graph->createRequest('GET', '/me')
                ->setReturnType(Model\User::class)
                ->execute();

            // 2. (NIEUW) Haal de bestanden en mappen op uit de root van OneDrive
            $files = $graph->createRequest('GET', '/me/drive/root/children')
                ->setReturnType(Model\DriveItem::class)
                ->execute();

            // 3. (NIEUW) Geef gebruiker én bestanden door aan de view
            return view('microsoft.dashboard', [
                'user' => $user,
                'files' => $files,
            ]);

        } catch (\Exception $e) {
            \Log::error('Graph Error', [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);

            if ($e->getCode() == 401) {
                session()->forget('ms_token');
                return redirect()->route('microsoft.login')->with('error', 'Sessie verlopen, log opnieuw in.');
            }

            abort(500, "Fout bij ophalen van data uit Microsoft Graph: " . $e->getMessage());
        }
    }



}