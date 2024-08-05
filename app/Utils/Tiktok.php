<?php

namespace App\Utils;

use Barryvdh\Debugbar\Facades\Debugbar as Logg;

trait Tiktok
{
    use Fetch;
    public function tiktok(string $url): array
    {
        $domain = 'https://www.tikwm.com';

        $headers = [
            'accept' => 'application/json, text/javascript, */*; q=0.01',
            'content-type' => 'application/x-www-form-urlencoded; charset=UTF-8',
            // 'cookie' => 'current_language=en; _ga=GA1.1.115940210.1660795490; _gcl_au=1.1.669324151.1660795490; _ga_5370HT04Z3=GS1.1.1660795489.1.1.1660795513.0.0.0',
            'sec-ch-ua' => '"Chromium";v="104", " Not A;Brand";v="99", "Google Chrome";v="104"',
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36'
        ];

        $params = [
            'url' => $url,
            'count' => 12,
            'cursor' => 0,
            'web' => 1,
            'hd' => 1
        ];

        $client = $this->getClient();

        $res = $client->post($domain . '/' . 'api/', [
            'headers' => $headers,
            'form_params' => $params
        ]);

        $json = json_decode($res->getBody());

        if ($json->code != 0) {
            return [
                'code' => -1,
            ];
        }

        $data = $json->data;

        Logg::info($data);

        return [
            'code' => 0,
            'platform' => 'tiktok',
            'file' => [
                'type' => ['video:mp4,HD', 'video:mp4', 'audio:mp3'],
                'url' => [$domain . '/' . $data->hdplay, $domain . '/' . $data->play, $domain . '/' . $data->music],
            ],
            'title' => $data->title,
            'cover' => $domain . $data->cover,
            'id' => $data->id,
        ];
    }
}
