<?php

namespace App\Utils;

class Str {
    static public function convertToCamelCase($input) {
        // Convierte el texto a minúsculas y luego lo divide en palabras
        $words = explode(' ', strtolower($input));
    
        // Convierte la primera letra de cada palabra (excepto la primera) a mayúscula
        $words = array_map('ucfirst', $words);
    
        // Asegura que la primera palabra esté en minúsculas
        $words[0] = strtolower($words[0]);
    
        // Une todas las palabras en una sola cadena
        return implode('', $words);
    } 
}