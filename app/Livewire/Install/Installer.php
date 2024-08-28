<?php

namespace App\Livewire\Install;

use App\Models\User;
use App\Utils\CreateFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Brotzka\DotenvEditor\DotenvEditor;

class Installer extends Component
{
    use CreateFile;

    public string $user;
    public string $pass;
    public string $email;

    public string $env;

    public bool $isSave = false;

    public function render()
    {
        if (!$this->isSave) {
            $this->saveData();
        }

        return view('livewire.install.installer');
    }

    public function saveData()
    {
        $dataJSON = $this->readJsonFile('dataTemp.json');
        // \Debugbar::info($dataJSON);

        if ($dataJSON) {
            $dataArr = $dataJSON;

            $this->user =  $dataArr['user'];
            $this->pass =  $dataArr['pass'];
            $this->email =  $dataArr['email'];

            $this->env =  $dataArr['env'];
        }

        $this->isSave = true;
    }

    public function runArtisanCommand()
    {
        try {
            //Artisan::call('config:clear');
            Artisan::call('storage:link', ['--relative' => true]);
            Artisan::call('migrate:fresh', ['--force' => true]);

            return ['error' => false];
        } catch (\Throwable $th) {
            //\Debugbar::info($th);
            $this->addError('artisan', 'Could not execute artisan commands');
            return ['error' => true];
        }
    }

    public function nextStep()
    {
        // session()->flash('success', true);
        $this->redirectRoute('home');
    }

    public function createUser()
    {
        $env =  $this->env;

        if ($env) {
            $user =  $this->user;
            $pass =  $this->pass;
            $email =  $this->email;

            try {
                User::create([
                    'name' => $user,
                    'email' => $email,
                    'password' => Hash::make($pass),
                ]);

                return ['error' => false];
            } catch (\Throwable $th) {
                // $this->addError('user', 'There was an error creating the user in the database');
                throw $th;
                return ['error' => true];
            }
        } else {
            $this->addError('env', 'There was an error creating the .env file');
            return ['error' => true];
        }
    }

    public function installLanguages()
    {
        try {
            Artisan::call('db:seed');
            return ['error' => false];
        } catch (\Throwable $th) {
            \Log::info($th);
            return ['error' => true];
        }
    }

    public function finish()
    {
        $isFinish = $this->updateEnv([
            'INSTALLATION_COMPLETE' => 'true',
        ]);

        if (!$isFinish) {
            return ['error' => true];
        }

        try {
            $this->deleteJsonFile('dataTemp.json');
        } catch (\Throwable $th) {
            \Log::info($th);
        }

        return ['error' => false];
    }

    public function updateEnv(array $dataEnv): bool
    {
        // \Debugbar::info($dataEnv);

        try {
            $env = new DotenvEditor();

            $env->changeEnv($dataEnv);

            return true;
        } catch (\Throwable $th) {
            // \Debugbar::info($th);
            throw $th;
            return false;
        }
    }
}
