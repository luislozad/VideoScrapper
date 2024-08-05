<?php

namespace App\Utils;

use App\Models\GoogleCloudTranslationApi;
use Google\Cloud\Translate\V2\TranslateClient;

trait TranslateClientKey
{
    protected function getTranslateClient(): ?TranslateClient
    {
        try {
            $cloudTranslate = GoogleCloudTranslationApi::first();

            if (!$cloudTranslate) {
                return null;
            }

            return new TranslateClient([
                'key' => $cloudTranslate->key,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            \Local::info($th);
            return null;
        }
    }
}
