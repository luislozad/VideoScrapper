<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RapiAPI as RapiAPIModel;

class RapidAPI extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RapiAPIModel::truncate();

        RapiAPIModel::create([
            'api' => 'Auto Download All In One',
            'enabled' => false,
            'platforms' => [
                'tiktok' => [
                    'enabled' => false,
                    'platform' => 'Tiktok'
                ],
                'douyin' => [
                    'enabled' => false,
                    'platform' => 'Douyin'
                ],
                'capcut' => [
                    'enabled' => false,
                    'platform' => 'Capcut'
                ],
                'threads' => [
                    'enabled' => false,
                    'platform' => 'Threads'
                ],
                'instagram' => [
                    'enabled' => false,
                    'platform' => 'Instagram'
                ],
                'facebook' => [
                    'enabled' => false,
                    'platform' => 'Facebook'
                ],
                'espn' => [
                    'enabled' => false,
                    'platform' => 'Espn'
                ],
                'pinterest' => [
                    'enabled' => false,
                    'platform' => 'Pinterest'
                ],
                'imdb' => [
                    'enabled' => false,
                    'platform' => 'Imdb'
                ],
                'imgur' => [
                    'enabled' => false,
                    'platform' => 'Imgur'
                ],
                'ifunny' => [
                    'enabled' => false,
                    'platform' => 'Ifunny'
                ],
                'izlesene' => [
                    'enabled' => false,
                    'platform' => 'Izlesene'
                ],
                'reddit' => [
                    'enabled' => false,
                    'platform' => 'Reddit'
                ],
                'youtube' => [
                    'enabled' => false,
                    'platform' => 'Youtube'
                ],
                'twitter' => [
                    'enabled' => false,
                    'platform' => 'Twitter'
                ],
                'vimeo' => [
                    'enabled' => false,
                    'platform' => 'Vimeo'
                ],
                'snapchat' => [
                    'enabled' => false,
                    'platform' => 'Snapchat'
                ],
                'bilibili' => [
                    'enabled' => false,
                    'platform' => 'Bilibili'
                ],
                'dailymotion' => [
                    'enabled' => false,
                    'platform' => 'Dailymotion'
                ],
                'sharechat' => [
                    'enabled' => false,
                    'platform' => 'Sharechat'
                ],
                'likee' => [
                    'enabled' => false,
                    'platform' => 'Likee'
                ],
                'linkedin' => [
                    'enabled' => false,
                    'platform' => 'Linkedin'
                ],
                'tumblr' => [
                    'enabled' => false,
                    'platform' => 'Tumblr'
                ],
                'hipi' => [
                    'enabled' => false,
                    'platform' => 'Hipi'
                ],
                'telegram' => [
                    'enabled' => false,
                    'platform' => 'Telegram'
                ],
                'getstickerpack' => [
                    'enabled' => false,
                    'platform' => 'Getstickerpack'
                ],
                'bitchute' => [
                    'enabled' => false,
                    'platform' => 'Bitchute'
                ],
                'febspot' => [
                    'enabled' => false,
                    'platform' => 'Febspot'
                ],
                '9gag' => [
                    'enabled' => false,
                    'platform' => '9GAG'
                ],
                'oke.ru' => [
                    'enabled' => false,
                    'platform' => 'Oke.ru'
                ],
                'rumble' => [
                    'enabled' => false,
                    'platform' => 'Rumble'
                ],
                'streamable' => [
                    'enabled' => false,
                    'platform' => 'Streamable'
                ],
                'ted' => [
                    'enabled' => false,
                    'platform' => 'Ted'
                ],
                'sohutv' => [
                    'enabled' => false,
                    'platform' => 'SohuTv'
                ],
                'xvideos' => [
                    'enabled' => false,
                    'platform' => 'Xvideos'
                ],
                'xnxx' => [
                    'enabled' => false,
                    'platform' => 'Xnxx'
                ],
                'xiaohongshu' => [
                    'enabled' => false,
                    'platform' => 'Xiaohongshu'
                ],
                'ixigua' => [
                    'enabled' => false,
                    'platform' => 'Ixigua'
                ],
                'weibo' => [
                    'enabled' => false,
                    'platform' => 'Weibo'
                ],
                'soundcloud' => [
                    'enabled' => false,
                    'platform' => 'Soundcloud'
                ],
                'mixcloud' => [
                    'enabled' => false,
                    'platform' => 'Mixcloud'
                ],
                'spotify' => [
                    'enabled' => false,
                    'platform' => 'Spotify'
                ],
                'zingmp3' => [
                    'enabled' => false,
                    'platform' => 'Zingmp3'
                ],
                'bandcamp' => [
                    'enabled' => false,
                    'platform' => 'Bandcamp'
                ]
            ]
        ]);
        
        /* RapiAPIModel::create([
            
        ]); */
    }
}
