<?php

namespace App\Utils;

use Barryvdh\Debugbar\Facades\Debugbar as Logg;

trait Instagram
{
    use Fetch;

    private string $fileMatch = '/\/([^\/?]+)\.([a-zA-Z0-9]+)\?/';

    public function instagram(string $url): array
    {
        $API_URL = "https://www.instagram.com/api/graphql";

        $headers = [
            'Accept' => '*/*',
            'Accept-Language' => 'en-US,en;q=0.5',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'X-FB-Friendly-Name' => 'PolarisPostActionLoadPostQueryQuery',
            'X-CSRFToken' => 'RVDUooU5MYsBbS1CNN3CzVAuEP8oHB52',
            'X-IG-App-ID' => '1217981644879628',
            'X-FB-LSD' => 'AVqbxe3J_YA',
            'X-ASBD-ID' => '129477',
            'Sec-Fetch-Dest' => 'empty',
            'Sec-Fetch-Mode' => 'cors',
            'Sec-Fetch-Site' => 'same-origin',
            'User-Agent' => 'Mozilla/5.0 (Linux; Android 11; SAMSUNG SM-G973U) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/14.2 Chrome/87.0.4280.141 Mobile Safari/537.36'
        ];

        $postID = $this->getPostId($url);

        $encodedData = $this->encodePostRequestData($postID);

        try {
            $client = $this->getClient();

            $res = $client->post($API_URL, [
                'headers' => $headers,
                'body' => $encodedData,
                // 'timeout' => 0,
            ]);

            if ($res->getStatusCode() == 500) {
                return [
                    'code' => -1
                ];
            }

            if ($res->getHeaderLine('content-type') !== 'text/javascript; charset=utf-8') {
                return [
                    'code' => -1
                ];
            }

            $resJson = json_decode($res->getBody(), true);

            //\Debugbar::info($resJson);

            $data = $resJson['data'];

            if (!isset($data)) {
                return [
                    'code' => -1
                ];
            }

            $dataJSON = $data['xdt_shortcode_media'];

            //\Debugbar::info($dataJSON);

            if (!$dataJSON['is_video']) {
                if (isset($dataJSON['edge_sidecar_to_children']['edges'])) {
                    $types = [];
                    $urls = [];

                    $resources = $dataJSON['edge_sidecar_to_children']['edges'];


                    foreach ($resources as $key1 => $fileData) {
                        $node = $fileData['node'];

                        $type = explode('XDTGraph', $node['__typename'])[1];

                        if ($node['is_video']) {
                            $videoUrl = $node['video_url'];
                            $types[] = 'video:mp4';
                            $urls[] = $videoUrl;
                        } else {
                            $fileUrl = $node['display_url'];
                            $matches = [];
                            preg_match($this->fileMatch, $fileUrl, $matches);
                            // \Debugbar::info($matches);
                            $types[] = strtolower($type) . ':' . $matches[2];
                            $urls[] = $fileUrl;
                        }
                    }

                    $id = $dataJSON['id'];

                    $cover = $dataJSON['display_url'];

                    $result = [
                        'code' => 0,
                        'platform' => 'instagram',
                        'file' => [
                            'type' => $types,
                            'url' => $urls,
                        ],
                        'title' => 'Instagram',
                        'cover' => route('temporary.file', [
                            'url' => $cover,
                        ]),
                        'id' => $id,
                    ];

                    return $result;
                } else {
                    //Logg::info($dataJSON);
                    $id = $dataJSON['id'];
                    $title = 'Instagram';
                    $cover = $dataJSON['display_url'];

                    $files = [];
                    $types = [];

                    if (isset($dataJSON['display_resources'])) {
                        $resources = $dataJSON['display_resources'];
                        foreach ($resources as $key => $fileData) {
                            $file = $fileData['src'];
                            $files[] = $file;
                            $matches = [];
                            preg_match($this->fileMatch, $file, $matches);
                            $type = explode('XDTGraph', $dataJSON['__typename'])[1];
                            $width = $fileData['config_width'];
                            $height = $fileData['config_height'];
                            $types[] = strtolower($type) . "({$width}px X {$height}px)" . ':' . $matches[2];

                        }
                    }

                    $file = $dataJSON['display_url'];
                    $matches = [];                                        preg_match($this->fileMatch, $file, $matches);
                    $type = explode('XDTGraph', $dataJSON['__typename'])[1];
                    $type = strtolower($type) . ':' . $matches[2];
                    return [
                        'code' => 0,
                        'platform' => 'instagram',
                        'file' => [
                            'type' => count($files) === 0 ? [$type] : $types,
                            'url' => count($files) === 0 ? [$file] : $files,
                        ],
                        'title' => $title && $title !== '' ? $title : 'Instagram',
                        'cover' => route('temporary.file', [
                            'url' => $cover
                        ]),
                        'id' => $id
                    ];
                }
            }

            $id = $dataJSON['id'];
            $title = 'Instagram';

            $video = $dataJSON['video_url'];
            $cover = $dataJSON['display_url'];

            $result = [
                'code' => 0,
                'platform' => 'instagram',
                'file' => [
                    'type' => ['video:mp4'],
                    'url' => [$video],
                ],
                'title' => $title,
                'cover' => route('temporary.file', [
                    'url' => $cover,
                ]),
                'id' => $id,
            ];

            // Logg::info($result);

            return $result;
        } catch (\Throwable $th) {
            Logg::info($th);
            return [
                'code' => -1
            ];
        }
    }

    private function encodePostRequestData(string $shortcode): string
    {
        $requestData = [
            'av' => '0',
            '__d' => 'www',
            '__user' => '0',
            '__a' => '1',
            '__req' => '3',
            '__hs' => '19624.HYP:instagram_web_pkg.2.1..0.0',
            'dpr' => '3',
            '__ccg' => 'UNKNOWN',
            '__rev' => '1008824440',
            '__s' => 'xf44ne:zhh75g:xr51e7',
            '__hsi' => '7282217488877343271',
            '__dyn' => '7xeUmwlEnwn8K2WnFw9-2i5U4e0yoW3q32360CEbo1nEhw2nVE4W0om78b87C0yE5ufz81s8hwGwQwoEcE7O2l0Fwqo31w9a9x-0z8-U2zxe2GewGwso88cobEaU2eUlwhEe87q7-0iK2S3qazo7u1xwIw8O321LwTwKG1pg661pwr86C1mwraCg',
            '__csr' => 'gZ3yFmJkillQvV6ybimnG8AmhqujGbLADgjyEOWz49z9XDlAXBJpC7Wy-vQTSvUGWGh5u8KibG44dBiigrgjDxGjU0150Q0848azk48N09C02IR0go4SaR70r8owyg9pU0V23hwiA0LQczA48S0f-x-27o05NG0fkw',
            '__comet_req' => '7',
            'lsd' => 'AVqbxe3J_YA',
            'jazoest' => '2957',
            '__spin_r' => '1008824440',
            '__spin_b' => 'trunk',
            '__spin_t' => '1695523385',
            'fb_api_caller_class' => 'RelayModern',
            'fb_api_req_friendly_name' => 'PolarisPostActionLoadPostQueryQuery',
            'variables' => json_encode([
                'shortcode' => $shortcode,
                'fetch_comment_count' => 'null',
                'fetch_related_profile_media_count' => 'null',
                'parent_comment_count' => 'null',
                'child_comment_count' => 'null',
                'fetch_like_count' => 'null',
                'fetch_tagged_user_count' => 'null',
                'fetch_preview_comment_count' => 'null',
                'has_threaded_comments' => 'false',
                'hoisted_comment_id' => 'null',
                'hoisted_reply_id' => 'null',
            ]),
            'server_timestamps' => 'true',
            'doc_id' => '10015901848480474',
        ];

        $encoded = http_build_query($requestData);
        return $encoded;
    }

    private function getPostId(string $postUrl)
    {
        $postRegex = '/^https:\/\/(?:www\.)?instagram\.com\/p\/([a-zA-Z0-9_-]+)\/?/';
        $reelRegex = '/^https:\/\/(?:www\.)?instagram\.com\/reels?\/([a-zA-Z0-9_-]+)\/?/';
        $postId = null;

        if (!$postUrl) {
            return $postId;
        }

        if (preg_match($postRegex, $postUrl, $postCheck)) {
            $postId = end($postCheck);
        }

        if (preg_match($reelRegex, $postUrl, $reelCheck)) {
            $postId = end($reelCheck);
        }

        if (!$postId) {
            return $postId;
        }

        return $postId;
    }
}
