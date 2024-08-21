<?php

namespace App\Services\Rapidapi;

use App\Utils\APIData;
use App\Utils\Fetch;
use Barryvdh\Debugbar\Facades\Debugbar as Log;

trait AutoDownloadAllInOne {
    use Fetch;
    public function autoDownloadAllInOne(string $url): array {
        return $this->createLinksForAutoDownloadAllInOne($url);
    }

    private function createLinksForAutoDownloadAllInOne(string $url): array {
        $client = $this->getClient();

        try {
            // $response = $client->post('https://auto-download-all-in-one.p.rapidapi.com/v1/social/autolink', [
            $response = $client->post('https://auto-download-all-in-one-big.p.rapidapi.com/v1/social/autolink', [
                'json' => [
                    'url' => $url
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    // 'x-rapidapi-host' => 'auto-download-all-in-one.p.rapidapi.com',
                    'x-rapidapi-host' => 'auto-download-all-in-one-big.p.rapidapi.com',
                    'x-rapidapi-key' => '7f63266777msh0e6d2673a634ab7p13d259jsneb8110ba688e',
                ],
                'timeout' => 30,
                'http_errors' => false,
            ]);
    
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            $jsonData = json_decode($body, true);
            Log::info($jsonData);
    
            if ($statusCode !== 200 || $jsonData['error']) {
                Log::error('Request failed with status code ' . $statusCode);
                Log::error($jsonData);
                return [
                    'code' => -1
                ];
            }

            $apiData = $this->createApiDataForAutoDownloadAllInOne($jsonData);
            
            return $apiData;
        } catch (\Exception $e) {
            Log::error('GuzzleHTTP error: ' . $e->getMessage());
            return [
                'code'=> -1
            ];
        }
    }

    private function getTypeForApiDataForAutoDownloadAllInOne(array $media, int $i): string {
        $quality = $media['quality'];
        $type = $media['type'];
        $extension = $media['extension'];

        $text = $type !== $quality ? "$type:$quality:$i" : "$type:$extension:$i";

        return $text;
    }

    private function createApiDataForAutoDownloadAllInOne(array $data): array {
        $apiData = new APIData('Auto');
        $cover = $data['thumbnail'];

        // $apiData->setCover($data['thumbnail']);
        $apiData->setCover($cover !== "" ? route('temporary.file', [
            'url' => $cover,
        ]) : url('assets/static/download.svg'));
        $apiData->setTitle($data['title']);

        $files = $apiData->addFiles();

        $medias = $data['medias'];

        foreach ($medias as $index => $media) {
            $files->pushUrl($media['url']);
            $type = $this->getTypeForApiDataForAutoDownloadAllInOne($media, $index + 1);
            $files->pushType($type);
        }

        return $apiData
        ->success(0)
        ->build();
    }
}