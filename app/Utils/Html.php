<?php

namespace App\Utils;

class Html
{
    public static function htmlEntityDecodeUTF8(string $text)
    {
        return html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    }
}
