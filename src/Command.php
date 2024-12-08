<?php

namespace Lectdark;

class Command
{
    public static function makeBase(string $baseName)
    {
        $files = [
            "controller/Ctrll_$baseName.php",
            "model/Md_$baseName.php",
            "context/Ajax_$baseName.php",
        ];

        foreach ($files as $file) {
            $fullPath = __DIR__ . "/../$file";

            if (!is_dir(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0777, true);
            }

            file_put_contents($fullPath, "<?php\n\n// Archivo generado automáticamente: $file\n\n");
        }

        echo "Archivos creados para: $baseName\n";
    }
}
