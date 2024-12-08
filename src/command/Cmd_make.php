<?php

namespace Lectdark\command;

class Cmd_make
{
    public static function base(string $baseName)
    {
        $files = [
            "controller/" => "Ctrll_",
            "model/" => "Md_",
            "context/" => "Ajax_",
        ];

        // Define the base directory where the files will be created
        $baseDir = __DIR__ . "/../../app"; // Ruta hacia la carpeta "app"

        foreach ($files as $dir => $prx) {
            $file = "$dir$prx$baseName.php";

            $fullPath = $baseDir . "/$file";

            // Crea los directorios si no existen
            if (!is_dir(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0777, true);
            }

            // Prepara el contenido del archivo con una clase
            $className = basename($file, ".php"); // El nombre de la clase será el nombre del archivo sin la extensión
            $content = "<?php\nnamespace App\\" . $className . ";\n" .
                "namespace src\\$prx"."lectdark;\n\n" .
                "class $className extends $prx"."lectdark\n" .
                "{\n" .
                "    public function __construct()\n" .
                "    {\n" .
                "        // Construct\n" .
                "    }\n\n" .
                "}\n";

            file_put_contents($fullPath, $content);
        }

        echo "Archivos creados para: $baseName\n";
    }
}