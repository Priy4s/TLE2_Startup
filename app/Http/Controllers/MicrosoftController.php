<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use League\OAuth2\Client\Provider\GenericProvider;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\User as GraphUser;
use App\Models\CloudFile;

class MicrosoftController extends Controller
{
    protected $oauthClient;
    protected $scopes = 'offline_access User.Read Files.ReadWrite.All';

    public function __construct()
    {
        // De configuratie is nu compleet gemaakt
        $this->oauthClient = new GenericProvider([
            'clientId'                => config('services.microsoft.client_id'),
            'clientSecret'            => config('services.microsoft.client_secret'),
            'redirectUri'             => config('services.microsoft.redirect'),
            'urlAuthorize'            => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
            'urlAccessToken'          => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => '', // <-- DEZE REGEL IS TOEGEVOEGD
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
            ]);
            $this->saveMicrosoftTokens(Auth::user(), $accessToken);
            return redirect()->route('profile.edit')->with('status', 'Microsoft account succesvol gekoppeld!');
        } catch (\Exception $e) {
            Log::error('Microsoft token exchange failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('profile.edit')->withErrors(['microsoft_error' => 'Kon Microsoft account niet koppelen: ' . $e->getMessage()]);
        }
    }

    public function disconnect()
    {
        $user = Auth::user();
        CloudFile::where('user_id', $user->id)->where('provider', 'microsoft')->delete();
        $user->update([
            'microsoft_access_token' => null, 'microsoft_refresh_token' => null,
            'microsoft_token_expiry' => null, 'microsoft_user_id' => null,
        ]);
        return redirect()->route('profile.edit')->with('status', 'Microsoft account losgekoppeld en cache geleegd.');
    }

    private function saveMicrosoftTokens($user, \League\OAuth2\Client\Token\AccessToken $token)
    {
        $graph = new Graph();
        $graph->setAccessToken($token->getToken());
        $graphUser = $graph->createRequest('GET', '/me?$select=id')->setReturnType(GraphUser::class)->execute();

        $user->update([
            'microsoft_access_token'  => $token->getToken(),
            'microsoft_refresh_token' => $token->getRefreshToken() ?? $user->microsoft_refresh_token,
            'microsoft_token_expiry'  => $token->getExpires(),
            'microsoft_user_id'       => $graphUser->getId(),
        ]);
    }
}