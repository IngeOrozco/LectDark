<?php
function color($tx, $clr)
{
    $colors = [
        "gray" => 30,
        "red" => 31,
        "green" => 32,
        "yellow" => 33,
        "blue" => 34,
        "magenta" => 35,
        "cyan" => 36,
        "white" => 37,
    ];

    $clr = key_exists($clr, $colors) ? $clr : 0;

    return "\033[" . $colors[$clr] . "m$tx\033[0m";
}

function back($tx, $clr)
{
    $colors = [
        "black" => 40,
        "red" => 41,
        "green" => 42,
        "yellow" => 43,
        "blue" => 44,
        "magenta" => 45,
        "cyan" => 46,
        "white" => 47,
    ];

    $clr = key_exists($clr, $colors) ? $clr : 0;

    return "\033[" . $colors[$clr] . "m$tx\033[0m";
}

function bold($tx)
{
    return "\033[1m$tx\033[0m";
}
