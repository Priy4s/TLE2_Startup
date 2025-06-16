<?php

namespace App\Http\Controllers;

use Google\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Google\Service\Drive;
use App\Models\CloudFile;
use Carbon\Carbon;


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

            $this->saveGoogleTokens(Auth::user(), $token, $client);

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

        // Clear Google tokens
        $user->update([
            'google_access_token' => null,
            'google_refresh_token' => null,
            'google_id' => null
        ]);

        return redirect()->route('profile.edit')->with([
            'status' => 'google-disconnected',
            'message' => 'Google Drive disconnected and cached files removed'
        ]);
    }


    // Helper: Create Google client instance
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

    private function saveGoogleTokens($user, $token, $client)
    {
        $user->google_access_token = $token['access_token'];
        $user->google_refresh_token = $token['refresh_token'] ?? $user->google_refresh_token;
        $user->google_id = $payload['sub'] ?? null;


        $user->save();
    }



    // Check connection status
    public function checkConnection()
    {
        try {
            $user = Auth::user();

            if (!$user->google_refresh_token) {
                return response()->json(['connected' => false]);
            }

            $client = $this->getGoogleClient();
            $client->setAccessToken($user->google_access_token);

            // Simple API call to verify token
            $service = new \Google\Service\Oauth2($client);
            $userInfo = $service->userinfo->get();

            return response()->json([
                'connected' => true,
                'email' => $userInfo->email
            ]);

        } catch (\Exception $e) {
            return response()->json(['connected' => false]);
        }
    }

    public function showDriveFiles(Request $request)
    {
        $user = Auth::user();
        $provider = 'google';

        $cached = CloudFile::where('user_id', $user->id)
            ->where('provider', $provider)
            ->get();

        // Only force sync if cache empty OR sync=1 param present
        $shouldSync = $cached->isEmpty() || $request->has('sync');

        if ($shouldSync) {
            // Fetch fresh files from Google Drive API
            $client = new \Google\Client();
            $client->setAccessToken($user->google_access_token);
            $service = new \Google\Service\Drive($client);

            $files = $service->files->listFiles([
                'fields' => 'files(id, name, mimeType, webViewLink)',
            ])->getFiles();

            foreach ($files as $file) {
                CloudFile::updateOrCreate(
                    ['user_id' => $user->id, 'file_id' => $file->id, 'provider' => $provider],
                    [
                        'name' => $file->name,
                        'mime_type' => $file->mimeType,
                        'web_view_link' => $file->webViewLink,
                        'synced_at' => now()
                    ]
                );
            }

            // Reload cache
            $cached = CloudFile::where('user_id', $user->id)
                ->where('provider', $provider)
                ->get();
        }

        // If sync was triggered by ?sync=1, redirect to clean URL to avoid re-sync on refresh
        if ($request->has('sync')) {
            return redirect()->route('documents.overview');
        }

        return view('alldocuments.documents-overview', ['files' => $cached]);
    }



}