<?php

namespace Lectdark\command;

use Lectdark\command\Cmd_make;
use Lectdark\command\Cmd_delete;
use Lectdark\command\Cmd_change;

class Cmd
{
    public static $base = [];
    public static $args = [];

    public function __construct(string $base, array $args)
    {
        self::$args = $args;

        if (empty($base)) {
            echo "No se proporcionó un comando válido.\n";
            self::cmd_error();
            return;
        }

        if (str_starts_with($base, ':') && strpos(substr($base, 1), ':') === false) {
            self::$base = substr($base, 1);
            $method = 'cmd_' . substr($base, 1);

            if (method_exists(self::class, $method)) self::$method();
            return;
        } else {
            $cmd = explode(':', $base);

            if (!empty($cmd[count($cmd) - 1])) {
                $method = 'cmd_' . $cmd[0];
                array_shift($cmd);
                self::$base = $cmd;

                if (method_exists(self::class, $method)) self::$method();
                return;
            }
        }

        echo "Comando no válido --> ($base)\n";
        self::cmd_error();
    }

    public static function cmd_error()
    {
        echo "use :list to watch commands";
    }

    public static function cmd_list()
    {
        /////// TITLE ///////
        echo bold(color("Lectdark Framework", "blue") . " version " . color("0.0.0", "yellow") . "\n\n");

        $commands = [
            'make' => function () {
                $view = bold(color("make\n", "cyan"));
                $view .= color("  make:base", "green") . "\t\t\tCreate base\n";
                return $view;
            },
            'delete' => function () {
                $view = bold(color("delete\n", "cyan"));
                $view .= color("  delete:base", "green") . "\t\t\tCreate base\n";
                return $view;
            },
            'change' => function () {
                $view = bold(color("change\n", "cyan"));
                $view .= color("  change:base:name", "green") . "\t\tChange name base\n";
                return $view;
            },
        ];

        if (is_array(self::$base)) {
            echo self::process(self::$base, $commands);
        } else {
            echo $commands['make'](); /////// MAKE ///////
            echo $commands['delete'](); /////// DELETE ///////
            echo $commands['change'](); /////// CHANGE ///////
        }
    }

    public static function cmd_make()
    {
        $commands = [
            'base' => function ($args) {
                if (count($args) < 1) {
                    echo "Falta un argumento.\n";
                    exit(1);
                }
                Cmd_make::base($args[0]);
            },
        ];

        self::process(self::$base, $commands);
    }

    public static function cmd_delete()
    {
        $commands = [
            'base' => function ($args) {
                if (count($args) < 1) {
                    echo "Falta un argumento.\n";
                    exit(1);
                }
                Cmd_delete::base($args[0]);
            },
        ];

        self::process(self::$base, $commands);
    }

    public static function cmd_change()
    {
        $commands = [
            'name' => [
                'base' => function ($args) {
                    if (count($args) < 3) {
                        echo "Faltan argumentos para change:name:base\n";
                        exit(1);
                    }
                    Cmd_change::name($args[0], $args[2]);
                }
            ]
        ];

        self::process(self::$base, $commands);
    }

    public static function process($base, $commands)
    {
        $command = array_shift($base);

        if (isset($commands[$command])) {
            if (count($base) > 0) {
                self::process($base, $commands[$command]);
                return;
            }
            else {
                return $commands[$command](self::$args);
            }
        }

        echo "Comando no reconocido --> ($command)\n";
        exit(1);
    }
}
