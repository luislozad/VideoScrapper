<?php

if (isInstalled()) {
    header("Location: /");
    exit;
}

function every($array, $condicion)
{
    return array_reduce($array, function ($carry, $item) use ($condicion) {
        return $carry && $condicion($item);
    }, true);
}

$checks = [];
$checks['php'] = [
    'loaded' => (PHP_MAJOR_VERSION >= 8 && PHP_MINOR_VERSION >= 1) ? true : false,
    'description' => 'PHP >= 8.1'
];

// $checks['ZipArchive'] = [
//     'loaded' => class_exists('ZipArchive'),
//     'description' => 'ZipArchive'
// ];

$requiredExtensions = [
    'ctype' => 'Ctype Extension',
    'curl' => 'cURL Extension',
    'dom' => 'DOM Extension',
    'fileinfo' => 'Fileinfo Extension',
    'filter' => 'Filter Extension',
    'hash' => 'Hash Extension',
    'mbstring' => 'Mbstring Extension',
    'openssl' => 'OpenSSL Extension',
    'pcre' => 'PCRE Extension',
    'pdo' => 'PDO Extension',
    'session' => 'Session Extension',
    'tokenizer' => 'Tokenizer Extension',
    'xml' => 'XML Extension',
];

foreach ($requiredExtensions as $extension => $description) {
    $checks[$extension] = [
        'loaded' => extension_loaded($extension),
        'description' => $description,
    ];
}

function installedDatabase()
{
    $env = getDatabase();

    if (!$env['error']) {
        $user = $env['user'];
        $pass = $env['pass'];
        $host = $env['host'];
        $database = $env['database'];
        $port = $env['port'];

        try {
            $conn = @mysqli_connect($host, $user, $pass, $database, $port);
            if (mysqli_connect_errno()) {
                return false;
            }

            $sql = "SELECT COUNT(*) as total FROM users";

            $result = mysqli_query($conn, $sql);

            if (!$result) {
                return false;
            }

            $row = mysqli_fetch_assoc($result);

            mysqli_free_result($result);

            $total = $row['total'];

            if ($total > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
    } else {
        return false;
    }
}

function installatioComplete()
{
    $isInstall = getEnvValue('INSTALLATION_COMPLETE');

    return $isInstall;
}

function isInstalled()
{
    $step1 = installedDatabase();
    $step2 = installatioComplete();

    return $step1 && $step2;
}

function getEnvValue(string $clave)
{
    // Ruta al archivo .env
    $envPath = realpath(__DIR__ . '/../../') . '/.env';

    // Verifica si el archivo .env existe
    if (!file_exists($envPath)) {
        return false;
    }

    // Lee el contenido del archivo .env
    $envContent = file_get_contents($envPath);

    // Divide el contenido en líneas
    $lines = explode("\n", $envContent);

    // Busca la clave en las líneas
    foreach ($lines as $line) {
        $parts = explode('=', $line, 2);

        // Verifica si la línea tiene el formato clave=valor
        if (count($parts) === 2) {
            $fileKey = trim($parts[0]);
            $value = trim($parts[1]);

            // Si la clave coincide, devuelve el value
            if ($fileKey === $clave) {
                return $value;
            }
        }
    }

    // Si la clave no existe, devuelve false
    return false;
}

function getDatabase()
{
    $host = getEnvValue('DB_HOST');
    $port = getEnvValue('DB_PORT');
    $database = getEnvValue('DB_DATABASE');
    $user = getEnvValue('DB_USERNAME');
    $pass = getEnvValue('DB_PASSWORD');

    return [
        'error' => !($host && $host && $port && $database && $user && $pass),
        'host' => $host,
        'port' => $port,
        'database' => $database,
        'user' => $user,
        'pass' => $pass
    ];
}

function newEnv()
{
    $envPath = realpath(__DIR__ . '/../../') . '/.env';
    $envExamplePath = realpath(__DIR__ . '/../../') . '/.env.example';

    if (!file_exists($envExamplePath)) {
        return;
    }

    $contentEnvExample = file_get_contents($envExamplePath);

    if ($contentEnvExample === false && file_exists($envPath)) {
        return;
    }

    file_put_contents($envPath, $contentEnvExample);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation requirements</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-center mx-auto p-4">
                <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="/assets/static/logo.svg" class="h-8" alt="Flowbite Logo">
                </a>
            </div>
        </nav>
    </header>
    <main>
        <div class="mt-20">
            <div class="p-5 flex justify-center">
                <div class="max-w-max border border-blue-500 rounded p-4 divide-y">
                    <div class="flex justify-center">
                        <ol class="items-center max-w-max space-y-4 sm:flex sm:space-x-8 sm:space-y-0 rtl:space-x-reverse">
                            <li class="flex items-center text-blue-600 dark:text-blue-500 space-x-2.5 rtl:space-x-reverse">
                                <span class="flex items-center justify-center w-8 h-8 border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
                                    1
                                </span>
                                <span>
                                    <h3 class="font-medium leading-tight">Requirements</h3>
                                    <p class="text-sm">Previous requirements</p>
                                </span>
                            </li>
                            <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse">
                                <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                                    2
                                </span>
                                <span>
                                    <h3 class="font-medium leading-tight">Configuration</h3>
                                    <p class="text-sm">Installation parameters</p>
                                </span>
                            </li>
                            <li class="flex items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse">
                                <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                                    3
                                </span>
                                <span>
                                    <h3 class="font-medium leading-tight">Installer</h3>
                                    <p class="text-sm">Install script</p>
                                </span>
                            </li>
                        </ol>
                    </div>

                    <div class="flex mt-4 pt-7 px-3 divide-y flex-wrap max-w-3xl">
                        <?php
                        foreach ($checks as $ext => $info) {
                            if ($info['loaded']) {
                        ?>
                                <div class="flex justify-between items-center space-x-1 w-full pt-2">
                                    <p class="text-sm font-normal text-gray-900 dark:text-white"><?php echo $info['description'] ?></p>
                                    <svg class="w-[18px] h-[18px] text-green-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                    </svg>
                                </div>
                            <?php
                            } else {

                            ?>
                                <div class="flex justify-between items-center space-x-1 w-full pt-2">
                                    <p class="text-sm font-normal text-gray-900 dark:text-white"><?php echo $info['description'] ?></p>
                                    <svg class="w-[18px] h-[18px] text-red-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                                    </svg>
                                </div>

                        <?php
                            }
                        }
                        ?>
                    </div>

                    <div class="flex justify-end w-full pt-5">
                        <?php
                        $isNext = every($checks, function ($info) {
                            return $info['loaded'];
                        });

                        if ($isNext) {
                            newEnv();
                        ?>
                            <a href="/configuration" class="cursor-pointer flex-shrink-0 px-5 py-3 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Next</a>

                        <?php
                        } else {
                        ?>
                            <button type="button" class="text-white bg-blue-400 dark:bg-blue-500 cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 text-center" disabled>Next</button>
                        <?php
                        }
                        ?>
                    </div>

                </div>

            </div>

        </div>
    </main>
</body>

</html>