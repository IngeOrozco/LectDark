<?php

namespace Lectdark\command;

class Cmd_make
{
    public static function base(string $baseName)
    {
        // Archivos y prefijos de cada tipo
        $files = [
            "controller/" => "Ctrll_",
            "model/" => "Md_",
            "context/" => "Ajax_",
        ];

        // Define el directorio base donde se crearán los archivos
        $baseDir = __DIR__ . "/../../app"; // Ruta hacia la carpeta "app"

        // Dividir el nombre base para detectar subcarpetas
        $baseNameParts = explode('/', $baseName);
        $fileName = array_pop($baseNameParts);  // Extraer el nombre del archivo
        $subDir = implode('/', $baseNameParts);  // Las carpetas que deben ser creadas

        foreach ($files as $dir => $prx) {
            // Determinar la ruta completa con subcarpeta
            $fileDir = "$dir$subDir";  // Incluir las subcarpetas
            $fullPath = $baseDir . "/$fileDir/$prx$fileName.php";  // Ruta final del archivo

            // Crear el directorio si no existe
            if (!is_dir(dirname($fullPath))) mkdir(dirname($fullPath), 0777, true);  // Crea los directorios necesarios

            $name = str_replace('/', '\\',$fileDir);

            // Nombre de la clase (sin extensión .php)
            $className = basename($fullPath, ".php");
            $content = "<?php\nnamespace App\\$name;\n" .
                "namespace src\\$prx" . "lectdark;\n\n" .
                "class $className extends $prx" . "lectdark\n" .
                "{\n" .
                "    public function __construct()\n" .
                "    {\n" .
                "        // Construct\n" .
                "    }\n" .
                "}\n";

            // Crear el archivo con el contenido
            file_put_contents($fullPath, $content);
        }

        echo color("Archivos creados para: " . bold($baseName, false) . "\n", "green");
    }
}


< AL CREAR UN ARCHIVO QUE EL NOMBRE NO ESTE REPETIDO
< QUE EL CHANGE FUNCIONE CON EL METODO DE SUB CARPETAS, Y QUE SE PUEDA CAMBIAR LA CAPETA
< CREAR UN SISTEMA "FOLDER" PARA CAMBIAR EL NOMBRE Y DEMÁS DE LAS CARPETAS AL IGUAL QUE SUS REFERENCIAS