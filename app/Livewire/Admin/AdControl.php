<?php

namespace App\Livewire\Admin;

use App\Models\Ads;
use Livewire\Component;

class AdControl extends Component
{
    public array $homeAds;
    public array $downloadAds;
    public array $scritps;

    public function render()
    {
        // \Debugbar::info($this->homeAds);
        return view('livewire.admin.ad-control')->layout('layouts.admin');
    }

    public function updateData(string $type, array $data): array
    {
        try {
            $savedData = Ads::where('type', $type);

            if (!$savedData) {
                $this->addError("update:$type", 'There was an error updating the data');
                return [
                    'error' => true
                ];
            }

            $savedData->update(['data' => json_encode($data)]);

            flash()->addSuccess(__('Your changes have been successfully saved!'));

            return [
                'error' => false
            ];
        } catch (\Throwable $th) {
            //throw $th;
            flash()->addError(__('An error occurred while saving data'));
            $this->addError("update:$type", 'There was an error updating the data');
            return false;
        }
    }

    public function getData(string $type): array
    {
        try {
            $data = Ads::where('type', $type)->first();

            if ($data) {
                return [
                    'error' => false,
                    'data' => json_decode($data->data, true)
                ];
            } else {
                return [
                    'error' => true,
                    'data' => []
                ];
            }
        } catch (\Throwable $th) {
            //throw $th;
            return [
                'error' => true,
            ];
        }
    }

    public function saveData(string $type, array $data)
    {
        try {
            // \Debugbar::info($type);
            Ads::create(['type' => $type, 'data' => json_encode($data)]);
            flash()->addSuccess(__('Your changes have been successfully saved!'));
            return ['error' => false];
        } catch (\Throwable $th) {
            // throw $th;
            flash()->addError(__('An error occurred while saving data'));
            $this->addError("save:$type", 'There was an error saving data');
            return ['error' => true];
        }
    }

    public function saveHomeAds(array $data)
    {
        $savedData = $this->getHomeAds();

        // \Debugbar::info($savedData);

        if ($savedData['error']) {
            return $this->saveData('home-ads', $data);
        }

        return $this->updateData('home-ads', $data);
    }

    public function saveDownloadAds(array $data)
    {
        $savedData = $this->getDownloadAds();

        if ($savedData['error']) {
            return $this->saveData('download-ads', $data);
        }

        return $this->updateData('download-ads', $data);
    }

    public function saveScripts(array $data)
    {
        $savedData = $this->getScripts();

        if ($savedData['error']) {
            return $this->saveData('scripts', $data);
        }

        return $this->updateData('scripts', $data);
    }

    public function getHomeAds(): array
    {
        return $this->getData('home-ads');
    }

    public function getDownloadAds(): array
    {
        return $this->getData('download-ads');
    }

    public function getScripts(): array
    {
        return $this->getData('scripts');
    }

    public function mount()
    {
        $this->homeAds = $this->getHomeAds();
        $this->downloadAds = $this->getDownloadAds();
        $this->scritps = $this->getScripts();

        // \Debugbar::info($this->getHomeAds());
    }
}
