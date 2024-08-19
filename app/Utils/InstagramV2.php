<?php

namespace App\Utils;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Barryvdh\Debugbar\Facades\Debugbar as Logg;

trait InstagramV2
{
    use Fetch;

    // private string $platform = 'instagram';

    public function instagram(string $url): array
    {
        $newUrl = $this->buildUrl($url);
        $jsonResponse = $this->fetchData($newUrl);

        if ($jsonResponse && isset($jsonResponse['graphql']['shortcode_media'])) {
            return $this->processMedia($jsonResponse['graphql']['shortcode_media']);
        } else {
            Log::error('Instagram data not found or invalid structure.', ['url' => $url]);
            return [
                'code' => -1,
            ];
        }
    }

    private function buildUrl(string $url): string
    {
        // Verifica si la URL ya tiene un query string
        if (strpos($url, '?') !== false) {
            // Si tiene query string, lo reemplaza
            return preg_replace('/\?.*/', '?__a=1&__d=dis', $url);
        } else {
            // Si no tiene query string, lo agrega
            return rtrim($url, '/') . '/?__a=1&__d=dis';
        }
    }

    private function fetchData(string $url): ?array
    {
        try {
            $client = $this->getClient();
            $response = $client->get($url);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            Log::error('Error fetching Instagram data.', ['url' => $url, 'error' => $e->getMessage()]);
            return null;
        }
    }

    private function processMedia(array $media): array
    {
        $apiData = new APIData('instagram');

        if ($media['__typename'] === 'GraphSidecar') {
            foreach ($media['edge_sidecar_to_children']['edges'] as $index => $edge) {
                $this->processMediaNode($apiData, $edge['node'], $index + 1);
            }
        } else {
            $this->processMediaNode($apiData, $media, 1);
        }

        $apiData->success(0);
        $apiData->setTitle('Instagram');
        // $apiData->setCover($media['display_url']);
        $apiData->setCover(route('temporary.file', [
            'url' => $media['display_url'],
        ]));
        $apiData->setID($media['id']);

        return $apiData->build();
    }

    private function processMediaNode(APIData $apiData, array $node, int $n)
    {
        $fileInstance = $apiData->addFiles();
        $dimensions = $node['dimensions'];
        $type = explode('Graph', $node['__typename'])[1];        
        $fileInstance->pushType(strtolower($type) .':'. $dimensions['width']. 'x'. $dimensions['height'] . ':' . $n);            
        
        if ($node['is_video']) {
            $fileInstance->pushUrl($node['video_url']);
        } else {
            $fileInstance->pushUrl($node['display_url']);
        }
        
    }
}
