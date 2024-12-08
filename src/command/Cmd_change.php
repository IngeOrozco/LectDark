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

                echo "El archivo y la clase '$prefix$from' fueron renombrados a '$prefix$to'.\n";
            } else {
                echo "El archivo '$prefix$from.php' no existe en '$dir'.\n";
            }
        }
    }
}
