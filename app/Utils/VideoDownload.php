<?php

namespace App\Utils;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;
use App\Utils\Domain;

use Barryvdh\Debugbar\Facades\Debugbar as Logg;

class VideoDownload
{
    use Tiktok, Facebook, Instagram, Twitter;
    private string $url;
    private Client $client;

    public function __construct(string $url)
    {

        $this->url = $url;
        $this->client = new Client();
    }

    public function getData(): array
    {
        $url = $this->url;
        $domain = $this->getDomain($url);

        //\Debugbar::info($this->instagram($url));

        $videoData = match ($domain) {
            'instagram.com', 'ig.me' => $this->instagram($url),
            'tiktok.com' => $this->tiktok($url),
            'facebook.com', 'fb.me', 'fb.com', 'fb.watch' => $this->facebook($url),
            'twitter.com', 'x.com' => $this->twitter($url),
            default => [
                'code' => -1
            ],
        };

        // Logg::info($videoData);

        // $driver = new DownloadDriver($videoData['platform'], $videoData['file']['url'][0]);

        // Logg::info($driver->getUrl());

        return $videoData;
    }

    protected function getClient(): Client
    {
        return $this->client;
    }

    private function getDomain(string $url): string | null
    {
        return Domain::getOnlyDomain($url);
    }
}
