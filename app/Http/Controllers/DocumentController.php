<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\CloudFile;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;

class DocumentController extends Controller
{
    public function overview(Request $request)
    {
        $user = Auth::user();

        $query = CloudFile::where('user_id', $user->id);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        // Provider filter (optional)
        if ($request->filled('provider') && in_array($request->provider, ['local', 'google'])) {
            $query->where('provider', $request->provider);
        }

        // Sync Google files if requested
        if ($request->has('sync_google')) {
            $this->syncGoogleFiles($user);
            return redirect()->route('documents.overview');
        }


        $files = $query->orderBy('synced_at', 'desc')->get();

        $lastSyncedAt = CloudFile::where('user_id', $user->id)
            ->whereNotNull('synced_at')
            ->orderBy('synced_at', 'desc')
            ->value('synced_at');

        return view('alldocuments.documents-overview', compact('files', 'lastSyncedAt'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        $user = Auth::user();
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $mime = $file->getClientMimeType();

        $path = $file->store("uploads/{$user->id}", 'public');
        $url = Storage::url($path);

        CloudFile::create([
            'user_id' => $user->id,
            'file_id' => 'local-' . uniqid(),
            'name' => $filename,
            'mime_type' => $mime,
            'web_view_link' => $url,
            'provider' => 'local',
            'synced_at' => null,
        ]);

        return redirect()->route('documents.overview')->with('status', 'File uploaded successfully!');
    }

    private function syncGoogleFiles($user)
    {
        if (!$user->google_access_token) {
            return;
        }

        $client = new GoogleClient();
        $client->setAccessToken($user->google_access_token);

        if ($client->isAccessTokenExpired() && $user->google_refresh_token) {
            $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
            $user->google_access_token = $client->getAccessToken()['access_token'] ?? $user->google_access_token;
            $user->save();
        }

        $service = new GoogleDrive($client);

        $response = $service->files->listFiles([
            'fields' => 'files(id, name, mimeType, webViewLink)',
            'q' => "'me' in owners",
            'supportsAllDrives' => true,
        ]);

        foreach ($response->getFiles() as $file) {
            CloudFile::updateOrCreate(
                ['user_id' => $user->id, 'file_id' => $file->id, 'provider' => 'google'],
                [
                    'name' => $file->name,
                    'mime_type' => $file->mimeType,
                    'web_view_link' => $file->webViewLink,
                    'synced_at' => now(),
                ]
            );
        }
    }
}
