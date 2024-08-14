<?php

namespace App\Livewire\Admin\Page;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use PHP_ICO;

class Info extends Component
{
    use WithFileUploads;

    #[Validate('required|string')]
    public $appName;

    #[Validate('image')]
    public $icon;

    public $iconUrl;

    #[Validate('image')]
    public $logo;

    public $logoUrl;

    public function render()
    {
        return view('livewire.admin.page.info');
    }

    public function save()
    {
        $logo = $this->saveLogo();
        $icon = $this->saveIcon();

        $appName = $this->appName;

        $page = Page::first();

        if ($page) {
            try {
                $page->update([
                    'icon' => $icon,
                    'logo' => $logo,
                    'appName' => $appName
                ]);

                flash()->addSuccess('The data were updated.');
                return;
            } catch (\Throwable $th) {
                //throw $th;
                \Log::info($th);
                flash()->addError('There was an error when updating the data.');
                return;
            }
        }

        try {
            Page::create([
                'icon' => $icon,
                'logo' => $logo,
                'appName' => $appName
            ]);
            flash()->addSuccess('The data were successfully saved.');
        } catch (\Throwable $th) {
            \Log::info($th);
            flash()->addError('There was an error when saving the data.');
        }
    }

    public function mount()
    {
        $this->initData();
    }

    public function initData()
    {
        $page = Page::first();

        if ($page) {
            $this->appName = $page->appName;
            $this->iconUrl = $page->icon ?? null;
            $this->logoUrl = $page->logo ?? null;
            // \Debugbar::info(asset("storage/$page->icon"));
        } else {
            $this->appName = env('APP_NAME');
        }
    }

    public function saveLogo(): string | null
    {
        $logo = $this->logo;

        if ($logo) {
            // Guardar el archivo
            $path = $logo->storePublicly('logos', 'public');

            // Ajustar los permisos del archivo recién subido
            $fullPath = storage_path("app/public/{$path}");
            chmod($fullPath, 0644); // Permisos de lectura/escritura para el propietario, solo lectura para otros

            // Cambiar el propietario y grupo
            exec("sudo chown www-data:www-data $fullPath");

            return $path;
        }

        return $this->logoUrl;
    }

    public function saveIcon(): string | null
    {
        $icon = $this->icon;

        if ($icon) {
            $iconPath = $icon->storePublicly('icons', 'public');
            $newIconPath = $this->renderICO($iconPath);

            return $newIconPath;
        }

        return $this->iconUrl;
    }

    public function renderICO(string $filePath)
    {
        try {
            $fileName = pathinfo($filePath, PATHINFO_FILENAME);
            $icoPath = "ico/$fileName.ico";
            $ico_lib = new PHP_ICO(storage_path("app/public/$filePath"), array(array(32, 32)));
            @$ico_lib->save_ico(public_path($icoPath));

            return $icoPath;
        } catch (\Throwable $th) {
            \Log::info("ICO ERROR: $th");
            return null;
        }
    }
}
