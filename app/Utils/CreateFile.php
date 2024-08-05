<?php

namespace App\Utils;

trait CreateFile
{
    public function createJsonFile($data, $filename = 'file.json')
    {
        $path = base_path($filename);

        $jsonContent = json_encode($data, JSON_PRETTY_PRINT);

        file_put_contents($path, $jsonContent);

        return $path;
    }

    public function readJsonFile($filename = 'file.json')
    {
        $path = base_path($filename);

        if (file_exists($path)) {
            $jsonContent = file_get_contents($path);

            $data = json_decode($jsonContent, true);

            return $data;
        } else {
            return null;
        }
    }

    public function deleteJsonFile($filename = 'file.json')
    {
        $path = base_path($filename);

        if (file_exists($path)) {
            unlink($path);
            return true;
        } else {
            return false;
        }
    }
}
