<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileTempController extends Controller
{
    public function Control(Request $request)
    {
        $cover = $request->input('url');

        $rutaTemporal = 'temp/';
        $nombreArchivo = uniqid() . '.jpg';

        $image = $this->getImage($cover);

        // Almacenar el archivo temporalmente
        Storage::put($rutaTemporal . $nombreArchivo, $image);

        // Crear una respuesta de transmisión para enviar el archivo al navegador
        $response = new StreamedResponse(function () use ($rutaTemporal, $nombreArchivo) {
            $stream = Storage::readStream($rutaTemporal . $nombreArchivo);
            fpassthru($stream);
            fclose($stream);

            // Eliminar el archivo después de enviarlo
            Storage::delete($rutaTemporal . $nombreArchivo);
        });

        // Configurar la respuesta para descargar el archivo
        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $nombreArchivo . '"');

        return $response;
    }

    private function getImage(string $url)
    {
        $client = new Client();
        $response = $client->get($url);

        return $response->getBody()->getContents();
    }
}
