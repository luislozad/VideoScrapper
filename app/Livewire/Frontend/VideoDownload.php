<?php

namespace App\Livewire\Frontend;

// use App\Models\File;
use App\Utils\File;
use Livewire\Component;
use Stevebauman\Location\Facades\Location;
use Barryvdh\Debugbar\Facades\Debugbar as Logg;

use App\Utils\VideoDownload as Download;

class VideoDownload extends Component
{
    public array $json = [];
    public string $play;
    public bool $videoInfo = false;

    public function download(string $url)
    {
        if (!isset($url) && empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->newError();
        }

        //Logg::info($url);

        $control = new Download($url);
        $json = $control->getData();

        if ($json['code'] == 0) {

            // Logg::info($json);

            $this->videoInfo = true;

            $this->json = $json;

            return ['success' => true, 'message' => 'Data loading successfully'];
        } else {
            return $this->newError();
        }
    }

    public function render()
    {
        return view('livewire.frontend.video-download');
    }

    public function resetChild()
    {
        $this->videoInfo = false;
    }

    public function newError()
    {
        $this->resetChild();
        $this->json = [
            'code' => 'error',
        ];
        return ['success' => false, 'message' => 'Error in data loading'];
    }
}
