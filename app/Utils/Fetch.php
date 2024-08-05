<?php

namespace App\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
// use Barryvdh\Debugbar\Facades\Debugbar as Logg;

trait Fetch
{
    abstract protected function getClient(): Client;

    public function buildHandlerLastUrl(string &$url): array
    {
        return [
            'on_stats' => function (TransferStats $stats) use (&$url) {
                $url = (string)$stats->getEffectiveUri();
            }
        ];
    }
}
