<?php

function showInput()
{
    $input = '';
    while ($x = fgets(STDIN)) {
        $input .= $x;
    }
    file_put_contents('php://stderr', $input, FILE_APPEND);
}
showInput();
die();


function e($var)
{
   error_log((is_scalar($var) ? $var : var_export($var, true)) . PHP_EOL);
}


$code = <<< EOC

    /* Challenge c :P */

    #include <stdlib.h>
    #include <stdio.h>
    #include <string.h>
    #include <math.h>

    int main() {
        printf("Hello, world!");
    }

EOC;

file_put_contents("/htdocs/exerciseprocessing/code.c", $code);

exec("gcc /htdocs/exerciseprocessing/code.c -o /htdocs/exerciseprocessing/a.out");

$output = [];
exec("/htdocs/exerciseprocessing/a.out", $output);
echo join("\n", $output);





function inc(&$array, $key, $value = 1)
{
   $array[$key] = isset($array[$key]) ? $array[$key] + $value : $value;
}

function between($n, $a, $b)
{
   return (($a < $b) ? (($n >= $a) && ($n <= $b)) : (($n >= $b) && ($n <= $a)));
}
