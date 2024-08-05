<?php

namespace App\Utils;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use GuzzleHttp\Client;

class DownloadDriver
{
    private string $platform;
    private string $url;

    // private string $fileMatch = '/\/([^\/?]+)\.([^\/?]+)\?/';
    private string $fileMatch = '/\/([^\/?]+)\.([a-zA-Z0-9]+)\?/';

    private string $localPath = '';

    private Client $client;

    public function __construct(string $platform, string $url)
    {
        $this->platform = $platform;
        $this->url = $url;
        $this->client = new Client();
    }

    public function getUrl()
    {
        $drive = $this->getDriver();

        $url = match ($drive) {
            'local' => $this->localSave(),
            default => $this->url,
        };

        return $url;
    }

    private function getDriver()
    {
        $drive = match ($this->platform) {
            'facebook', 'instagram', 'tiktok' => 'local',
            default => null,
        };

        return $drive;
    }

    private function localSave(): string
    {
        $url = $this->url;
        $fileData = $this->getFileName($url);

        if (isset($fileData)) {
            $localPath = storage_path('app/temp/');

            $fileName = $this->generateName($fileData);

            $this->downloadFileStream($url, $fileName);
        }

        return $url;
    }

    private function getFileName(string $url): array | null
    {
        $matches = null;
        preg_match($this->fileMatch, $url, $matches);

        if (isset($matches)) {
            return [
                'name' => $matches[1],
                'ext' => $matches[2]
            ];
        }

        return null;
    }

    private function getClient()
    {
        return $this->client;
    }

    private function generateName(array $fileData)
    {
        $fileName = $fileData['name'];
        $fileExt = $fileData['ext'];

        $name = date('YmdHi') . $fileName . '.' . $fileExt;

        return $name;
    }

    private function downloadFileStream(string $url, string $fileName)
    {
        $client = $this->getClient();

        $response = $client->request('GET', $url, ['stream' => true]);

        // Obtiene el stream del contenido
        $stream = $response->getBody()->detach();

        // Guarda el archivo en el disco utilizando el sistema de archivos de Laravel
        Storage::disk('public')->put($fileName, $stream);
    }
}
