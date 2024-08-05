<?php

namespace App\Utils;

use Pdp\Domain as DomainExt;
use Pdp\TopLevelDomains;
//use Barryvdh\Debugbar\Facades\Debugbar as Logg;

class Domain {
    public static function getRegistrableDomain($url) {
        //Logg::info(storage_path('app/public_suffix_list.dat'));
        $topLevelDomains = TopLevelDomains::fromPath(storage_path('app/tlds-alpha-by-domain.txt'));
        $domain = DomainExt::fromIDNA2008($url);
        $result = $topLevelDomains->resolve($domain);
        return $result->registrableDomain()->toString();

    }

    public static function getOnlyDomain($url) {
        $domain = self::filterDomain($url);

        if (!$domain) {
            return null;
        }

        return self::getRegistrableDomain($domain);
    }

    public static function filterDomain($url) {
        $parsedUrl = parse_url($url);

        if (isset($parsedUrl['host'])) {
            $domain = $parsedUrl['host'];
            $domain = preg_replace('/^www\./', '', $domain);
            return $domain;                                   }

        return null;
    }
}
