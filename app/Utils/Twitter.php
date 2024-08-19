<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

use Barryvdh\Debugbar\Facades\Debugbar as Logg;

trait Twitter {
    use Fetch;

    // protected string $platform = 'twitter';

    protected $headers = [
        "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:84.0) Gecko/20100101 Firefox/84.0",
        "Accept" => "*/*",
        "Accept-Language" => "en-US,en;q=0.5",
        "Accept-Encoding" => "gzip, deflate, br",
        "TE" => "trailers",
    ];

    protected $requestDetailsFile = 'RequestDetails.json';

    public function twitter(string $url): array {
        // Logg::info('holaaa');
        return $this->generateDownloadLinks($url);
    }

    protected function getRequestDetails(): array {
        // Leer el archivo JSON
        $content = Storage::get($this->requestDetailsFile);
        $request_details = json_decode($content, true);
        
        $features = $request_details['features'];
        $variables = $request_details['variables'];

        return [$features, $variables];
    }
    
    protected function getTokens(string $tweetUrl) {    
        $client = $this->getClient();
    
        try {
            $response = $client->get($tweetUrl, [
                'headers' => $this->headers
            ]);
    
            if ($response->getStatusCode() !== 200) {
                throw new \Exception(
                    "Failed to get tweet page. Status code: {$response->getStatusCode()}. Tweet url: {$tweetUrl}"
                );
            }
    
            $redirectUrlMatch = $response->getBody()->getContents();
            preg_match(
                '/content="0; url = (https:\/\/twitter\.com\/[^"]+)"/',
                $redirectUrlMatch,
                $matches
            );
    
            if (empty($matches)) {
                throw new \Exception(
                    "Failed to find redirect URL. Tweet url: {$tweetUrl}"
                );
            }
    
            $redirectUrl = $matches[1];
            preg_match('/tok=([^&"]+)/', $redirectUrl, $tokMatches);
    
            if (empty($tokMatches)) {
                throw new \Exception(
                    "Failed to find 'tok' parameter in redirect URL. Redirect URL: {$redirectUrl}"
                );
            }
    
            $tok = $tokMatches[1];
            $response = $client->get($redirectUrl, [
                'headers' => $this->headers
            ]);
    
            if ($response->getStatusCode() !== 200) {
                throw new \Exception(
                    "Failed to get redirect page. Status code: {$response->getStatusCode()}. Redirect URL: {$redirectUrl}"
                );
            }
    
            $dataMatch = $response->getBody()->getContents();
            preg_match(
                '/<input type="hidden" name="data" value="([^"]+)"/',
                $dataMatch,
                $dataMatches
            );
    
            if (empty($dataMatches)) {
                throw new \Exception(
                    "Failed to find 'data' parameter in redirect page. Redirect URL: {$redirectUrl}"
                );
            }
    
            $data = $dataMatches[1];
            $authUrl = "https://x.com/x/migrate";
            $authParams = ['form_params' => ['tok' => $tok, 'data' => $data], 'headers' => $this->headers];
    
            $response = $client->post($authUrl, $authParams);
    
            if ($response->getStatusCode() !== 200) {
                throw new \Exception(
                    "Failed to authenticate. Status code: {$response->getStatusCode()}. Auth URL: {$authUrl}"
                );
            }
    
            $mainjsUrlMatch = $response->getBody()->getContents();
            preg_match_all(
                '/https:\/\/abs\.twimg\.com\/responsive-web\/client-web-legacy\/main\.[^\.]+\.js/',
                $mainjsUrlMatch,
                $mainjsUrlMatches
            );
    
            if (empty($mainjsUrlMatches[0])) {
                throw new \Exception(
                    "Failed to find main.js file. If you are using the correct Twitter URL this suggests a bug in the script. Please open a GitHub issue and copy and paste this message. Tweet url: {$tweetUrl}"
                );
            }
    
            $mainjsUrl = $mainjsUrlMatches[0][0];
            $mainjs = $client->get($mainjsUrl, [
                'headers' => $this->headers
            ]);
    
            if ($mainjs->getStatusCode() !== 200) {
                throw new \Exception(
                    "Failed to get main.js file. If you are using the correct Twitter URL this suggests a bug in the script. Please open a GitHub issue and copy and paste this message. Status code: {$mainjs->getStatusCode()}. Tweet url: {$tweetUrl}"
                );
            }
    
            preg_match_all('/AAAAAAAAA[^"]+/', $mainjs->getBody()->getContents(), $bearerTokenMatches);
    
            if (empty($bearerTokenMatches)) {
                throw new \Exception(
                    "Failed to find bearer token. If you are using the correct Twitter URL this suggests a bug in the script. Please open a GitHub issue and copy and paste this message. Tweet url: {$tweetUrl}, main.js url: {$mainjsUrl}"
                );
            }
    
            $bearerToken = $bearerTokenMatches[0];
    
            $guestTokenResponse = $client->post("https://api.twitter.com/1.1/guest/activate.json", [
                'headers' => [...$this->headers, 'Authorization' => "Bearer {$bearerToken[0]}"],
            ]);
    
            if ($guestTokenResponse->getStatusCode() !== 200) {
                throw new \Exception(
                    "Failed to activate guest token. Status code: {$guestTokenResponse->getStatusCode()}. Tweet url: {$tweetUrl}"
                );
            }
    
            $guestToken = json_decode($guestTokenResponse->getBody()->getContents())->guest_token;
    
            if (!$guestToken) {
                throw new \Exception(
                    "Failed to find guest token. If you are using the correct Twitter URL this suggests a bug in the script. Please open a GitHub issue and copy and paste this message. Tweet url: {$tweetUrl}, main.js url: {$mainjsUrl}"
                );
            }
    
            return [$bearerToken, $guestToken];
        } catch (RequestException $e) {
            throw new \Exception(
                "An error occurred: " . $e->getMessage()
            );
        }
    }
    
    protected function getDetailsUrl($tweetId, $features, $variables) {
        // Crea una copia de las variables - no queremos modificar la original
        $variablesCopy = array_merge([], $variables);
        $variablesCopy['tweetId'] = $tweetId;
    
        // Codifica las variables y características en JSON y luego en URL
        $encodedVariables = urlencode(json_encode($variablesCopy));
        $encodedFeatures = urlencode(json_encode($features));
    
        // Construye la URL final
        return "https://twitter.com/i/api/graphql/0hWvDhmW8YQ-S_ib3azIrw/TweetResultByRestId?variables={$encodedVariables}&features={$encodedFeatures}";
    }
    
    protected function getTweetDetails($tweetUrl, $guestToken, $bearerToken) {
        $tweetIdMatches = [];
        preg_match('/(?<=status\/)\d+/', $tweetUrl, $tweetIdMatches);
    
        if (empty($tweetIdMatches) || count($tweetIdMatches) !== 1) {
            throw new \Exception(
                "Could not parse tweet id from your url. Make sure you are using the correct url. If you are, then file a GitHub issue and copy and paste this message. Tweet url: {$tweetUrl}"
            );
        }
        
        [$features, $variables] = $this->getRequestDetails();
        $tweetId = $tweetIdMatches[0];
        $url = $this->getDetailsUrl($tweetId, $features, $variables);
    
        $client = $this->getClient();
        $headers = [
            'Authorization' => "Bearer {$bearerToken}",
            'x-guest-token' => $guestToken,
        ];
    
        try {
            $response = $client->get($url, ['headers' => $headers]);
    
            $details = $response->getBody()->getContents();
            $statusCode = $response->getStatusCode();
    
            $maxRetries = 10;
            $curRetry = 0;
    
            while ($statusCode === 400 && $curRetry < $maxRetries) {
                $errorJson = json_decode($details, true);
    
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception(
                        "Failed to parse json from details error. details text: {$details}. If you are using the correct Twitter URL this suggests a bug in the script. Please open a GitHub issue and copy and paste this message. Status code: {$statusCode}. Tweet url: {$tweetUrl}"
                    );
                }
    
                if (!isset($errorJson['errors'])) {
                    throw new \Exception(
                        "Failed to find errors in details error json. If you are using the correct Twitter URL this suggests a bug in the script. Please open a GitHub issue and copy and paste this message. Status code: {$statusCode}. Tweet url: {$tweetUrl}"
                    );
                }
    
                $neededVariablePattern = "/Variable '([^']+)'/";
                $neededFeaturesPattern = "/The following features cannot be null: ([^\"]+)/";
    
                foreach ($errorJson['errors'] as $error) {
                    preg_match_all($neededVariablePattern, $error['message'], $neededVars);
                    foreach ($neededVars[1] as $neededVar) {
                        $variables[$neededVar] = true;
                    }
    
                    preg_match_all($neededFeaturesPattern, $error['message'], $neededFeatures);
                    foreach ($neededFeatures[1] as $nf) {
                        foreach (explode(",", $nf) as $feature) {
                            $features[trim($feature)] = true;
                        }
                    }
                }
    
                $url = $this->getDetailsUrl($tweetId, $features, $variables);
                $response = $client->get($url, ['headers' => $headers]);
    
                $details = $response->getBody()->getContents();
                $statusCode = $response->getStatusCode();
    
                $curRetry += 1;
    
                if ($statusCode === 200) {
                    // Save new variables
                    $requestDetails = [
                        'variables' => $variables,
                        'features' => $features,
                    ];

                    Storage::put($this->requestDetailsFile, json_encode($requestDetails, JSON_PRETTY_PRINT));                    
    
                    // file_put_contents(storage_path("app/{$this->requestDetailsFile}"), json_encode($requestDetails, JSON_PRETTY_PRINT));
                }
            }
    
            if ($statusCode !== 200) {
                throw new \Exception(
                    "Failed to get tweet details. If you are using the correct Twitter URL this suggests a bug in the script. Please open a GitHub issue and copy and paste this message. Status code: {$statusCode}. Tweet url: {$tweetUrl}"
                );
            }
    
            return $details;
    
        } catch (RequestException $e) {
            throw new \Exception(
                "An error occurred: " . $e->getMessage()
            );
        }
    }
    
    protected function getPostTitle(string $text, array $range) {
        // $start = $range[0];
        // $end = $range[1];

        // $chunk = $text;

        // if ($end > 0) {
        //     $chunk = substr($text, $start, $end - $start + 1);
        // }        
        
        // $title = mb_convert_encoding($chunk, 'UTF-8', 'UTF-8');

        // $cleanMessage = preg_replace('/https?:\/\/\S+/', '', $chunk);

        // // $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

        // Logg::info(trim($cleanMessage));

        // return $cleanMessage;

        return $text;
    }

    protected function getMediaResolution(string $url): string {
        preg_match('/\/(\d+x\d+)\//', $url, $matches);
        $resolution = is_array($matches) && count($matches) > 1 ? $matches[1] : '|';
        return $resolution;
    }

    protected function getMediaByType(array $result): array {
        $mediaList = [
            'type' => [],
            'url' => [],
            'cover' => [],
            'title' => '',
            'postText' => false,
            'quotedPermalink' => null,
        ];

        $legacy = $result['legacy'];

        if (array_key_exists('extended_entities', $legacy)) {
            $extendedEntities = $legacy['extended_entities'];
            $media = $extendedEntities['media'];

            $countPhotos = 0;
            $countGifs = 0;

            foreach($media as $value) {
                $type = $value['type'];
                if ($type === 'video') {
                    $videoInfo = $value['video_info'];
                    $variants = $videoInfo['variants'];

                    foreach($variants as $video) {
                        if (array_key_exists('bitrate', $video)) {
                            $url = $video['url'];
                            $splitContentType = explode('/', $video['content_type']);
                            $contentType = is_array($splitContentType) && count($splitContentType) > 1 ? $splitContentType[1] : 'mp4';
                            $resolution = $this->getMediaResolution($url);
                            array_push($mediaList['url'], $url);
                            array_push($mediaList['type'], "$type:$contentType:$resolution");
                            array_push($mediaList['cover'], $value['media_url_https']);
                        }
                    }
                } elseif ($type === 'animated_gif') {
                    $videoInfo = $value['video_info'];
                    $variants = $videoInfo['variants'];

                    foreach($variants as $video) {
                        if (array_key_exists('bitrate', $video)) {
                            $url = $video['url'];
                            $splitContentType = explode('/', $video['content_type']);
                            $contentType = is_array($splitContentType) && count($splitContentType) > 1 ? $splitContentType[1] : 'mp4';
                            array_push($mediaList['url'], $url);
                            array_push($mediaList['type'], "gif:$contentType:". (++$countGifs));
                            array_push($mediaList['cover'], $value['media_url_https']);
                        }
                    }                    
                } elseif ($type === 'photo') {
                    $url = $value['media_url_https'];
                    array_push($mediaList['url'], $url);
                    array_push($mediaList['type'], "$type:jpg:". (++$countPhotos));
                    array_push($mediaList['cover'], $url);
                }
            }
        }

        if ($legacy['is_quote_status']) {
            if (array_key_exists('quoted_status_result', $result)) {
                $quotedResult = $result['quoted_status_result'];
                if (is_array($quotedResult) && count($quotedResult) > 0) {
                    $quotedMediaList = $this->getMediaByType($quotedResult['result']);
                    $mediaList['url'] = array_merge($mediaList['url'], $quotedMediaList['url']);
                    $mediaList['type'] = array_merge($mediaList['type'], $quotedMediaList['type']);
                    $mediaList['cover'] = array_merge($mediaList['cover'], $quotedMediaList['cover']);
                } elseif (array_key_exists('quoted_status_permalink', $legacy) && count($legacy) > 0) {
                    $expanded = $legacy['quoted_status_permalink']['expanded'] ?? null;
                    $mediaList['quotedPermalink'] = $expanded;
                }
            }
        }

        $textRange = $legacy['display_text_range'];
        $fullText = $legacy['full_text'];

        $title = $this->getPostTitle($fullText, $textRange);

        $mediaList['title'] = $title;
        $mediaList['postText'] = !(count($mediaList['url']) > 0 && count($mediaList['type']) > 0);

        return $mediaList;
    }

    protected function getPostCover(array $mediaList): string {
        $cover = $mediaList['cover'][0];

        return $cover;
    }

    protected function createMediaLinks(array $jsonData): array {
        $result = $jsonData['data']['tweetResult']['result'];

        $mediaList = $this->getMediaByType($result);

        if ($mediaList['postText']) {
            return [
                'code' => -1,
                'result' => $mediaList
            ];
        }

        $cover = $this->getPostCover($mediaList);
        $id = $result['rest_id'];

        $api = new APIData('twitter');

        $api
        ->success(0)
        ->setTitle($mediaList['title'])
        ->setCover($cover)
        ->setID( $id )
        ->addFiles()
        ->setTypes($mediaList['type'])
        ->setUrls( $mediaList['url'] );

        return $api->build();
    }
    
    protected function generateDownloadLinks(string $tweetUrl, int $ctr = 0): array {
        try {
            [$bearerToken, $guestToken] = $this->getTokens($tweetUrl);
            // Logg::info($bearerToken);
            // Logg::info($guestToken);
    
            $response = $this->getTweetDetails($tweetUrl, $guestToken, $bearerToken[0]);
            Logg::info($response);
            $jsonData = json_decode($response, JSON_PRETTY_PRINT);
            Logg::info($jsonData);
    
            $videoUrls = $this->createMediaLinks($jsonData);

            if ($videoUrls['code'] === -1) {
                $quotedPermalink = $videoUrls['result']['quotedPermalink'];
                if ($quotedPermalink !== null && $ctr === 0) {
                    $videoUrls = $this->generateDownloadLinks($quotedPermalink, $ctr + 1);
                } else {
                    $videoUrls = [
                        'code' => -1
                    ];
                }
            }

            // Logg::info($videoUrls);

            return $videoUrls;
        } catch (\Exception $e) {
            Logg::error("Error: " . $e);
            return [
                'code' => -1,
            ];
        }
    }   
        
}
