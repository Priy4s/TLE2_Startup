<?php

namespace App\Http\Controllers;

use App\Models\CloudFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use League\OAuth2\Client\Provider\GenericProvider;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\User as GraphUser;

class MicrosoftController extends Controller
{
    protected $oauthClient;
    protected $scopes = 'openid profile email offline_access User.Read Files.ReadWrite.All';

    public function __construct()
    {
        $this->oauthClient = new GenericProvider([
            'clientId'                => config('services.microsoft.client_id'),
            'clientSecret'            => config('services.microsoft.client_secret'),
            'redirectUri'             => config('services.microsoft.redirect'),
            'urlAuthorize'            => 'https://login.microsoftonline.com/' . config('services.microsoft.tenant', 'common') . '/oauth2/v2.0/authorize',
            'urlAccessToken'          => 'https://login.microsoftonline.com/' . config('services.microsoft.tenant', 'common') . '/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => '',
        ]);
    }

    public function redirectToProvider()
    {
        $authUrl = $this->oauthClient->getAuthorizationUrl(['scope' => $this->scopes]);
        session(['oauth2state' => $this->oauthClient->getState()]);
        return redirect()->away($authUrl);
    }

    public function handleProviderCallback(Request $request)
    {
        if (empty($request->input('state')) || ($request->input('state') !== session('oauth2state'))) {
            session()->forget('oauth2state');
            abort(400, 'Invalid state');
        }

        try {
            $accessToken = $this->oauthClient->getAccessToken('authorization_code', [
                'code' => $request->input('code'),
                'scope' => $this->scopes
            ]);

            $this->saveMicrosoftTokens(Auth::user(), $accessToken);

            return redirect()->route('profile.edit')->with('status', 'Microsoft account succesvol gekoppeld!');

        } catch (\Exception $e) {
            Log::error('Microsoft token exchange failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('profile.edit')->withErrors(['microsoft_error' => 'Kon Microsoft account niet koppelen: ' . $e->getMessage()]);
        }
    }

    public function checkConnection()
    {
        try {
            $user = Auth::user();
            if (!$user->microsoft_refresh_token) {
                return response()->json(['connected' => false]);
            }

            if (time() >= $user->microsoft_token_expiry) {
                $newAccessToken = $this->refreshMicrosoftToken($user);
                if (!$newAccessToken) {
                    return response()->json(['connected' => false, 'reason' => 'Token refresh failed']);
                }
                $accessToken = $newAccessToken;
            } else {
                $accessToken = $user->microsoft_access_token;
            }

            $graph = new Graph();
            $graph->setAccessToken($accessToken);
            // GECORRIGEERD: Een dollarteken '$' toegevoegd voor select
            $graphUser = $graph->createRequest('GET', '/me?$select=userPrincipalName')->setReturnType(GraphUser::class)->execute();

            return response()->json([
                'connected' => true,
                'email' => $graphUser->getUserPrincipalName()
            ]);

        } catch (\Exception $e) {
            Log::error('Microsoft connection check failed: ' . $e->getMessage());
            try {
                $refreshedToken = $this->refreshMicrosoftToken(Auth::user());
                return response()->json(['connected' => !!$refreshedToken, 'refreshed' => true]);
            } catch (\Exception $refreshError) {
                return response()->json(['connected' => false, 'reason' => 'Connection check and refresh failed']);
            }
        }
    }

    public function disconnect()
    {
        $user = Auth::user();
        $user->update([
            'microsoft_access_token' => null,
            'microsoft_refresh_token' => null,
            'microsoft_token_expiry' => null,
            'microsoft_user_id' => null,
        ]);
        return redirect()->route('profile.edit')->with('status', 'Microsoft account losgekoppeld.');
    }

    private function saveMicrosoftTokens($user, \League\OAuth2\Client\Token\AccessToken $token)
    {
        $graph = new Graph();
        $graph->setAccessToken($token->getToken());
        // GECORRIGEERD: Een dollarteken '$' toegevoegd voor select
        $graphUser = $graph->createRequest('GET', '/me?$select=id')->setReturnType(GraphUser::class)->execute();

        $user->update([
            'microsoft_access_token'  => $token->getToken(),
            'microsoft_refresh_token' => $token->getRefreshToken() ?? $user->microsoft_refresh_token,
            'microsoft_token_expiry'  => $token->getExpires(),
            'microsoft_user_id'       => $graphUser->getId(),
        ]);
    }

    private function refreshMicrosoftToken($user)
    {
        if (!$user->microsoft_refresh_token) return null;
        try {
            $newToken = $this->oauthClient->getAccessToken('refresh_token', [
                'refresh_token' => $user->microsoft_refresh_token,
            ]);
            $this->saveMicrosoftTokens($user, $newToken);
            return $newToken->getToken();
        } catch (\Exception $e) {
            Log::error('Microsoft token refresh failed: ' . $e->getMessage());
            $user->update(['microsoft_access_token' => null, 'microsoft_refresh_token' => null, 'microsoft_token_expiry' => null, 'microsoft_user_id' => null]);
            return null;
        }
    }
}