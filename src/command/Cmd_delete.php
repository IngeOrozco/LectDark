<?php

namespace Lectdark\command;

class Cmd_delete
{
    public static function base(string $baseName)
    {
        $files = [
            "controller/Ctrll_$baseName.php",
            "model/Md_$baseName.php",
            "context/Ajax_$baseName.php",
        ];

        // Define the base directory where the files will be deleted from
        $baseDir = __DIR__ . "/../../app"; // Ruta hacia la carpeta "app"

        foreach ($files as $file) {
            $fullPath = $baseDir . "/$file";

            // Verifica si el archivo existe antes de eliminarlo
            if (file_exists($fullPath)) {
                unlink($fullPath); // Elimina el archivo
                echo "Archivo eliminado: $fullPath\n";
            } else {
                echo "El archivo no existe: $fullPath\n";
            }
        }

        // Eliminar los directorios vacíos
        foreach (['controller', 'model', 'context'] as $dir) {
            $dirPath = $baseDir . "/$dir";
            // Elimina directorios vacíos
            if (is_dir($dirPath) && count(scandir($dirPath)) == 2) { // Verifica que el directorio esté vacío
                rmdir($dirPath);
                echo "Directorio vacío eliminado: $dirPath\n";
            }
        }

        echo "Archivos eliminados para: $baseName\n";
    }
}