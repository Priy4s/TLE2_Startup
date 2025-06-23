<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\CloudFile;

// Importeer de benodigde classes voor BEIDE services
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use League\OAuth2\Client\Provider\GenericProvider as MicrosoftClient;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\DriveItem;

class DocumentController extends Controller
{

    /**
     * Toont een gecombineerd overzicht van alle cloud- en lokale bestanden.
     */
    public function overview(Request $request)
    {
        $user = Auth::user();

        if ($request->has('sync_all')) {
            $this->syncGoogleFiles($user);
            $this->syncMicrosoftFiles($user);
            return redirect()->route('documents.overview')->with('status', 'All accounts are being synced.');
        }

        $query = CloudFile::where('user_id', $user->id)
                ->where('mime_type', '!=', 'folder/microsoft')
                ->where('mime_type', '!=', 'application/vnd.google-apps.folder');


        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $activeFilters = $request->input('filters', []);

        if (!empty($activeFilters)) {

            $query->where(function ($q) use ($activeFilters) {
                foreach ($activeFilters as $filter) {
                    switch ($filter) {
                        case 'google':
                        case 'microsoft':
                        case 'local':
                            $q->orWhere('provider', $filter);
                            break;
                        case 'document':
                            $q->orWhereIn('mime_type', ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.google-apps.document']);
                            break;
                        case 'powerpoint':
                            $q->orWhereIn('mime_type', ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.google-apps.presentation']);
                            break;
                        case 'pdf':
                            $q->orWhere('mime_type', 'application/pdf');
                            break;
                        case 'excel':
                            $q->orWhere('mime_type', ['application/vnd.google-apps.spreadsheet']);
                            break;
                        case 'form':
                            $q->orWhere('mime_type', ['application/vnd.google-apps.form']);
                            break;
                    }
                }
            });
        }

        $files = $query->orderBy('name', 'asc')->get();
        $lastSyncedAt = CloudFile::where('user_id', $user->id)->whereNotNull('synced_at')->max('synced_at');

        return view('alldocuments.documents-overview', [
            'files' => $files,
            'lastSyncedAt' => $lastSyncedAt,
            'activeFilters' => $activeFilters,
            'currentSearch' => $request->search
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate(['file' => 'required|file|max:10240']);

        $user = Auth::user();
        $file = $request->file('file');
        $path = $file->store("uploads/{$user->id}", 'public');

        CloudFile::create([
            'user_id'       => $user->id,
            'file_id'       => 'local-' . uniqid(),
            'name'          => $file->getClientOriginalName(),
            'mime_type'     => $file->getClientMimeType(),
            'web_view_link' => Storage::url($path),
            'provider'      => 'local',
            'synced_at'     => now(),
        ]);

        return redirect()->route('documents.overview')->with('status', 'File uploaded successfully!');
    }

    /**
     * Synchroniseert bestanden van Google Drive.
     */
    private function syncGoogleFiles($user)
    {
        if (!$user->google_refresh_token) {
            return;
        }

        try {
            $client = new GoogleClient();
            $client->setClientId(config('services.google.client_id'));
            $client->setClientSecret(config('services.google.client_secret'));
            $client->setRedirectUri(config('services.google.redirect'));
            $client->setAccessToken($user->google_access_token);

            if ($client->isAccessTokenExpired()) {
                $tokenData = $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
                $user->update(['google_access_token' => $tokenData['access_token']]);
            }

            $service = new GoogleDrive($client);
            $response = $service->files->listFiles(['fields' => 'files(id, name, mimeType, webViewLink)', 'q' => "'me' in owners"]);

            foreach ($response->getFiles() as $file) {
                CloudFile::updateOrCreate(
                    ['user_id' => $user->id, 'file_id' => $file->id, 'provider' => 'google'],
                    ['name' => $file->name, 'mime_type' => $file->mimeType, 'web_view_link' => $file->webViewLink, 'synced_at' => now()]
                );
            }
        } catch (\Exception $e) {
            Log::error('Google Sync Failed', ['message' => $e->getMessage()]);
        }
    }

    /**
     * NIEUW TOEGEVOEGD: Synchroniseert bestanden van Microsoft OneDrive.
     */
    private function syncMicrosoftFiles($user)
    {
        if (!$user->microsoft_refresh_token) {
            return;
        }

        try {
            $accessToken = $user->microsoft_access_token;

            // Controleer of de token is verlopen en vernieuw indien nodig
            if (time() >= ($user->microsoft_token_expiry ?? 0) - 60) {
                $oauthClient = $this->getMicrosoftClient();
                $newToken = $oauthClient->getAccessToken('refresh_token', ['refresh_token' => $user->microsoft_refresh_token]);

                $user->update([
                    'microsoft_access_token' => $newToken->getToken(),
                    'microsoft_token_expiry' => $newToken->getExpires(),
                    'microsoft_refresh_token' => $newToken->getRefreshToken() ?? $user->microsoft_refresh_token,
                ]);
                $user->refresh(); // Herlaad het user model met de nieuwe data
                $accessToken = $newToken->getToken();
            }

            $graph = new Graph();
            $graph->setAccessToken($accessToken);
            $driveItems = $graph->createRequest('GET', '/me/drive/root/children?$top=200')->setReturnType(DriveItem::class)->execute();

            foreach ($driveItems as $item) {
                CloudFile::updateOrCreate(
                    ['user_id' => $user->id, 'file_id' => $item->getId(), 'provider' => 'microsoft'],
                    ['name' => $item->getName(), 'mime_type' => $item->getFile() ? $item->getFile()->getMimeType() : 'folder/microsoft', 'web_view_link' => $item->getWebUrl(), 'synced_at' => now()]
                );
            }
        } catch (\Exception $e) {
            Log::error('Microsoft Sync Failed', ['message' => $e->getMessage()]);
            // Optioneel: Stuur een foutmelding terug naar de gebruiker
            return redirect()->route('documents.overview')->with('error', 'Microsoft sync is mislukt: ' . $e->getMessage());
        }
    }

    /**
     * NIEUW TOEGEVOEGD: Helper-methode om de Microsoft client aan te maken.
     */
    private function getMicrosoftClient()
    {
        return new MicrosoftClient([
            'clientId'                => config('services.microsoft.client_id'),
            'clientSecret'            => config('services.microsoft.client_secret'),
            'redirectUri'             => config('services.microsoft.redirect'),
            'urlAuthorize'            => 'https://login.microsoftonline.com/' . config('services.microsoft.tenant', 'common') . '/oauth2/v2.0/authorize',
            'urlAccessToken'          => 'https://login.microsoftonline.com/' . config('services.microsoft.tenant', 'common') . '/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => '',
        ]);
    }
}