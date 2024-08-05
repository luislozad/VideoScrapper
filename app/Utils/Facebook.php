<?php

namespace App\Utils;

use App\Utils\Fetch;
use Barryvdh\Debugbar\Facades\Debugbar as Logg;
use Illuminate\Support\Facades\File;

trait Facebook
{
    use Fetch;
    public function facebook(string $url): array
    {
        try {
            $headers = [
                'sec-fetch-user' => '?1',
                'sec-ch-ua-mobile' => '?0',
                'sec-fetch-site' => 'none',
                'sec-fetch-dest' => 'document',
                'sec-fetch-mode' => 'navigate',
                'cache-control' => 'max-age=0',
                'authority' => 'www.facebook.com',
                'upgrade-insecure-requests' => 1,
                'accept-language' => 'en-GB,en;q=0.9,tr-TR;q=0.8,tr;q=0.7,en-US;q=0.6',
                'sec-ch-ua' => '"Google Chrome";v="89", "Chromium";v="89", ";Not A Brand";v="99"',
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36',
                'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                // 'cookie' => '"sb=Rn8BYQvCEb2fpMQZjsd6L382; datr=Rn8BYbyhXgw9RlOvmsosmVNT; c_user=100003164630629; _fbp=fb.1.1629876126997.444699739; wd=1920x939; spin=r.1004812505_b.trunk_t.1638730393_s.1_v.2_; xs=28%3A8ROnP0aeVF8XcQ%3A2%3A1627488145%3A-1%3A4916%3A%3AAcWIuSjPy2mlTPuZAeA2wWzHzEDuumXI89jH8a_QIV8; fr=0jQw7hcrFdas2ZeyT.AWVpRNl_4noCEs_hb8kaZahs-jA.BhrQqa.3E.AAA.0.0.BhrQqa.AWUu879ZtCw'
            ];

            $client = $this->getClient();

            $lastUrl = $url;

            $res = $client->get($url, [
                'headers' => $headers,
                'timeout' => 10,
                'allow_redirects' => true,
                // 'verify' => false, // Deshabilitar la verificación del certificado SSL (no recomendado en entornos de producción)
                ...$this->buildHandlerLastUrl($lastUrl)
            ]);

            $data = $res->getBody()->getContents();

            $id = $this->generateId($lastUrl);
            $title = $this->getTitle($data);
            $cover = $this->getCover($data);

            //Logg::info($data);

            $sdLink = $this->getSDLink($data);
            $hdLink = $this->getHDLink($data);

            $result = [
                'code' => 0,
                'platform' => 'facebook',
                'file' => [
                    'type' => ['video:mp4:HD', 'video:mp4:HQ'],
                    'url' => [$hdLink, $sdLink],
                ],
                'title' => $title,
                'cover' => route('temporary.file', [
                    'url' => $cover,
                ]),
                'id' => $id,
            ];

            $filter = $this->filter($result['file']);

            // Logg::info($filter);
            // Logg::info($result);

            if (!count($filter['url'])) {
                return [
                    'code' => -1
                ];
            }

            $result['file'] = $filter;

            return $result;
        } catch (\Exception $e) {
            return [
                'code' => -1
            ];
        }
    }

    private function generateId(string $url): string
    {
        $id = '';
        if (is_int($url)) {
            $id = $url;
        } elseif (preg_match('#(\d+)/?$#', $url, $matches)) {
            $id = $matches[1];
        }

        return $id;
    }

    private function getTitle(string $content): string
    {
        $regexRateLimit = '/<title>(.*?)<\/title>/';
        // $regexRateLimit = '/<meta\sname="description"\scontent="(.*?)"/';
        $title = 'Facebook';
        if (preg_match($regexRateLimit, $content, $matches)) {
            $title = $matches[1];
        }

        return $title;
    }

    private function cleanStr(string $str): string
    {
        $tmpStr = "{\"text\": \"{$str}\"}";

        return json_decode($tmpStr)->text;
    }

    private function getSDLink(string $content)
    {
        $regexRateLimit = '/browser_native_sd_url":"([^"]+)"/';
        // $regexRateLimit = '/"playable_url":"(.*?)"/';
        //Logg::info($content);
        //$filePath = base_path('fb.txt');
        //File::put($filePath, $content);
        if (preg_match($regexRateLimit, $content, $match)) {
            //Logg::info($match);
            return $this->cleanStr($match[1]);
        } else {
            return false;
        }
    }

    private function getHDLink(string $content)
    {
        $regexRateLimit = '/browser_native_hd_url":"([^"]+)"/';
        // $regexRateLimit = '/"playable_url_quality_hd":"(.*?)"/';

        if (preg_match($regexRateLimit, $content, $match)) {
            return $this->cleanStr($match[1]);
        } else {
            return false;
        }
    }

    private function getCover(string $content): string
    {
        $regexRateLimit = '/"preferred_thumbnail":{"image":{"uri":"(.*?)"/';

        if (preg_match($regexRateLimit, $content, $cover)) {
            return str_replace('\\', '', $cover[1]);
        }

        return 'none';
    }

    private function filter(array $files): array
    {
        $result = [
            'url' => [],
            'type' => [],
        ];

        $types = $files['type'];
        $urls = $files['url'];

        for ($i = 0; $i < count($urls); $i++) {
            $url = $urls[$i];

            if ($url) {
                $result['url'][] = $url;
                $result['type'][] = $types[$i];
            }
        }

        return $result;
    }
}
