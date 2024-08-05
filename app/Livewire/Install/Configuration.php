<?php

namespace App\Livewire\Install;

use App\Utils\CreateFile;
use Livewire\Component;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use App\Utils\Database;

class Configuration extends Component
{
    use CreateFile;

    public array $dataEnv = [];

    public array $data = [];

    public function render()
    {
        return view('livewire.install.configuration');
    }

    public function save(array $data = [])
    {
        return $this->saveConfiguration($data);
    }

    public function nextStep()
    {
        $isUpdateEnv = $this->updateEnv();

        $data = $this->data;

        $user = $data['username'];
        $pass = $data['password'];
        $email = $data['email'];

        $this->createJsonFile(['user' => $user, 'pass' => $pass, 'email' => $email, 'env' => $isUpdateEnv], 'dataTemp.json');

        $this->redirectRoute('preinstall');
    }

    public function saveConfiguration(array $data)
    {
        $this->data = $data;

        $this->validate([
            'data' => ['array'],
            'data.*' => ['string', 'required'],
            'data.email' => ['required', 'email'],
        ]);

        $this->dataEnv = $this->newConfig($data);

        $sqlConnect = $this->testSQL();

        if (!$sqlConnect) {
            $this->addError('sql', 'Error connecting to database');
            return;
        }

        return [
            'error' => !($sqlConnect),
            'actions' => [
                'sql' => $sqlConnect,
            ]
        ];
    }

    public function updateEnv(): bool
    {
        $dataEnv = $this->dataEnv;
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

    public function newConfig(array $data)
    {
        $appName = $data['appName'];

        $hostDB = $data['hostDB'];
        $portDB = $data['portDB'];
        $database = $data['database'];
        $usernameDB = $data['usernameDB'];
        $passwordDB = $data['passwordDB'];

        $config = [];

        $config['APP_NAME'] = '"' . $appName . '"';
        // $config['APP_DEBUG'] = 'false';
        $config['APP_URL'] = url('/');
        $config['DB_HOST'] = $hostDB;
        $config['DB_PORT'] = $portDB;
        $config['DB_DATABASE'] = $database;
        $config['DB_USERNAME'] = $usernameDB;
        $config['DB_PASSWORD'] = $passwordDB;
        $config['APP_DEBUG'] = 'false';

        return $config;
    }

    public function testSQL(): bool
    {
        $data = $this->data;

        $host = $data['hostDB'];
        $port = $data['portDB'];
        $username = $data['usernameDB'];
        $password = $data['passwordDB'];
        $database = $data['database'];

        try {
            $db = Database::testv1($host, $username, $password, $database, $port);

            if (!$db['connection']) {
                return false;
            }

            return true;

        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function resetValidations()
    {
        $this->resetValidation();
    }
}
