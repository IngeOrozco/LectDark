<?php

namespace Lectdark\Command;

class Cmd_change
{
    public static function name(string $from, string $to)
    {
        // Define las rutas de los directorios
        $directories = [
            'controller' => 'Ctrll_',
            'model' => 'Md_',
            'context' => 'Ajax_'
        ];

        // Procesa cada tipo de directorio (controller, model, context)
        foreach ($directories as $dir => $prefix) {
            // Ruta completa hacia el directorio
            $oldPath = __DIR__ . "/../../app/$dir/$prefix$from.php"; // Ruta del archivo original
            $newPath = __DIR__ . "/../../app/$dir/$prefix$to.php";   // Ruta del nuevo archivo

            if (is_file($oldPath)) {
                // Renombrar el archivo
                rename($oldPath, $newPath);

                // Abrir el archivo y modificar el nombre de la clase
                $fileContents = file_get_contents($newPath);

                // Reemplazar la clase antigua con la nueva
                $fileContents = preg_replace('/class ' . $prefix . $from . '/', 'class ' . $prefix . $to, $fileContents);

                // Guardar los cambios en el archivo
                file_put_contents($newPath, $fileContents);

                echo color("El archivo y la clase '" . bold($prefix . $from, false) . "' fueron renombrados a '" . bold($prefix . $to, false) . "'.\n", "green");

                // Buscar otros archivos que puedan estar utilizando esta clase
                self::updateClassReferences($from, $to, $prefix);
            } else {
                echo color("El archivo '" . bold($prefix . $from . ".php") . "' no existe en '" . bold($dir) . "'.\n", "red");
            }
        }
    }

    private static function updateClassReferences(string $from, string $to, string $prefix)
    {
        // Buscar todos los archivos PHP en el directorio
        $files = glob(__DIR__ . "/../../app/**/*.{php}", GLOB_BRACE);
    
        foreach ($files as $file) {
            // Leer el contenido del archivo
            $fileContents = file_get_contents($file);
    
            // Verificar si contiene al menos una referencia específica al prefijo y clase antigua
            if (strpos($fileContents, $prefix . $from) !== false) {
                // Reemplazar todas las referencias a la clase antigua con la nueva
                $updatedContents = preg_replace('/\b' . preg_quote($prefix . $from, '/') . '\b/', $prefix . $to, $fileContents);
    
                // Verificar si hubo cambios
                if ($updatedContents !== $fileContents) {
                    // Guardar los cambios
                    file_put_contents($file, $updatedContents);
                    echo color("Se actualizó una referencia a '" . bold($prefix . $from, false) . "' en '" . bold($file, false) . "'.\n", "green");
                }
            }
        }
    }
    


    // private static function updateClassReferences(string $from, string $to, string $prefix)
    // {
    //     // Buscar todos los archivos PHP en el directorio
    //     $files = glob(__DIR__ . "/../../app/**/*.{php}", GLOB_BRACE);

    //     foreach ($files as $file) {
    //         // Leer el contenido del archivo
    //         $fileContents = file_get_contents($file);

    //         // Reemplazar todas las referencias a la clase antigua con la nueva
    //         $fileContents = preg_replace('/' . $prefix . $from . '\b/', $prefix . $to, $fileContents);

    //         // Guardar los cambios
    //         file_put_contents($file, $fileContents);

    //         echo color("Se actualizó una referencia a '" . bold($prefix . $from, false) . "' en '" . bold($file, false) . "'.\n", "green");
    //     }
    // }
}
