<?php

namespace App\Http\Controllers;

use Google\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\CloudFile;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        $client = $this->getGoogleClient();
        return redirect($client->createAuthUrl());
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $client = $this->getGoogleClient();

            if (!$request->has('code')) {
                throw new \Exception('Authorization code missing');
            }

            $token = $client->fetchAccessTokenWithAuthCode($request->code);

            if (isset($token['error'])) {
                throw new \Exception($token['error_description'] ?? 'Google authentication failed');
            }

            $this->saveGoogleTokens(Auth::user(), $token);

            return redirect()->route('profile.edit')->with([
                'status' => 'google-connected',
                'message' => 'Google Drive connected successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Google connection failed: ' . $e->getMessage());
            return redirect()->route('profile.edit')->withErrors([
                'google_error' => 'Connection failed: ' . $e->getMessage()
            ]);
        }
    }

    public function disconnectGoogle()
    {
        $user = Auth::user();

        // Delete cached Google files
        CloudFile::where('user_id', $user->id)
            ->where('provider', 'google')
            ->delete();

        // Clear tokens
        $user->update([
            'google_access_token' => null,
            'google_refresh_token' => null,
            'google_id' => null,
        ]);

        return redirect()->route('profile.edit')->with([
            'status' => 'google-disconnected',
            'message' => 'Google Drive disconnected and cached files removed'
        ]);
    }

    private function getGoogleClient()
    {
        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->addScope(\Google\Service\Drive::DRIVE_METADATA_READONLY);
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        return $client;
    }

    private function saveGoogleTokens($user, $token)
    {
        $user->google_access_token = $token['access_token'];
        if (isset($token['refresh_token'])) {
            $user->google_refresh_token = $token['refresh_token'];
        }
        $user->save();
    }
}
