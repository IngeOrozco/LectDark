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
            self::level_cmd_0();
            return;
        }

        if (str_starts_with($base, ':') && strpos(substr($base, 1), ':') === false) {
            self::$base = substr($base, 1);
            self::level_cmd_1();
            return;
        } else {
            $cmd = explode(':', $base);

            if (!empty($cmd[count($cmd) - 1])) {
                self::$base = $base;
                $method = 'level_cmd_' . count($cmd);

                if (method_exists(self::class, $method)) {
                    echo "lectdark error level cmd";
                    self::$method();
                }

                return;
            }
        }

        echo "Comando no válido --> ($base)\n";
        self::level_cmd_0();
    }

    public static function level_cmd_0()
    {
        echo "use :list to watch commands";
    }

    public static function level_cmd_1()
    {
        switch (self::$base) {
            case 'list':
                /////// TITLE ///////
                echo bold(color("Lectdark Framework", "blue") . " versión " . color("0.0.0", "yellow") . "\n\n");

                /////// MAKE ///////
                echo bold(color("make\n", "cyan"));
                echo color("  make:base", "green") . "\t\t\tCreate base\n";
                /////// DELETE ///////
                echo bold(color("delete\n", "cyan"));
                echo color("  delete:base", "green") . "\t\t\tCreate base\n";
                /////// CHANGE ///////
                echo bold(color("change\n", "cyan"));
                echo color("  change:base:name", "green") . "\t\tChange name base\n";
                break;
            default:
                echo "Nada";
                break;
        }
    }

    public static function level_cmd_2()
    {
        switch (self::$base[0]) {
            case 'make':
                switch (self::$base[1]) {
                    case 'base':
                        if (count(self::$args) < 1) {
                            echo "Falta un argumento.\n";
                            exit(1);
                        }

                        Cmd_make::base(self::$args[0]);
                        break;
                    default:
                        echo "Comando no reconocido --> " . self::$base[1] . "\n";
                        break;
                }
                break;
            case 'delete':
                if (count(self::$args) < 1) {
                    echo "Falta el nombre base.\n";
                    exit(1);
                }

                Cmd_delete::base(self::$args[0]);
                break;
            case 'change':
                if (count(self::$args) < 3) {
                    echo "Faltan argumentos para " . implode(':', self::$base) . "\n";
                    exit(1);
                }

                Cmd_change::name(self::$args[0], self::$args[2]);
                break;
            default:
                echo "Comando no reconocido --> " . self::$base[0] . "\n";
                exit(1);
        }
    }
}
