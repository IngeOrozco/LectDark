<?php

namespace Lectdark\command;

class Cmd_delete
{
    public static function base(string $baseName)
    {
        $files = [
            "controller/" => "Ctrll_",
            "model/" => "Md_",
            "context/" => "Ajax_",
        ];

        // Define el directorio base donde se eliminarán los archivos
        $baseDir = __DIR__ . "/../../app"; // Ruta hacia la carpeta "app"

        // Dividir el nombre base para detectar subcarpetas
        $baseNameParts = explode('/', $baseName);
        $fileName = array_pop($baseNameParts); // Extraer el nombre del archivo
        $subDir = implode('/', $baseNameParts); // Las carpetas que deben ser eliminadas

        foreach ($files as $dir => $prx) {
            // Determinar la ruta completa con subcarpetas
            $fileDir = "$dir$subDir"; // Incluir las subcarpetas
            $fullPath = $baseDir . "/$fileDir/$prx$fileName.php"; // Ruta final del archivo

            // Verifica si el archivo existe antes de eliminarlo
            if (file_exists($fullPath)) {
                unlink($fullPath); // Elimina el archivo
                echo color("Archivo eliminado: " . bold($fullPath, false) . "\n", "green");
            } else {
                echo color("El archivo no existe: " . bold($fullPath, false) . "\n", "yellow");
            }

            // Eliminar directorios vacíos de forma recursiva hacia arriba
            $currentDir = $baseDir . "/$fileDir";
            while (is_dir($currentDir) && count(scandir($currentDir)) == 2) { // Si el directorio está vacío
                rmdir($currentDir);
                echo color("Directorio vacío eliminado: " . bold($currentDir, false) . "\n", "cyan");

                // Subir un nivel en la jerarquía
                $currentDir = dirname($currentDir);
            }
        }

        echo color("Archivos y carpetas eliminados para: " . bold($baseName, false) . "\n", "green");
    }
}
