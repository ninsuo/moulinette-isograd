<?php

function diff($start, $end)
{
    list($start_usec, $start_sec) = explode(" ", $start);
    list($end_usec, $end_sec) = explode(" ", $end);
    $diff_sec = intval($end_sec) - intval($start_sec);
    $diff_usec = floatval($end_usec) - floatval($start_usec);
    return round(floatval($diff_sec) + $diff_usec, 2);
}

function red($string)
{
    return "\33[31m" . $string . "\33[39m";
}

function green($string)
{
    return "\33[32m" . $string . "\33[39m";
}

function display($title, $content, $lines)
{
    if (strlen($content) > 1024 * 1024) {
        return ;
    }
    $exp = explode("\n", $content);
    echo "{$title}\n";
    foreach (array_slice($exp, 0, $lines) as $line) {
        echo "{$line}\n";
    }
    if ($lines < count($exp)) {
        echo " ... and " . (count($exp) - $lines) . " other lines\n";
    }
}

$solution = 'answer.php';

$exo = null;
if (isset($argv[1]))
{
    $exo = $argv[1];
}

$inputs = glob("input*.txt");

$max = 0;
$list = array();
foreach ($inputs as $input)
{
    sscanf($input, "input%d.txt", $cur);
    $list[] = $cur;
}
sort($list);

foreach ($list as $no)
{
    $input = "input{$no}.txt";

    $key = null;
    sscanf($input, "input%d.txt", $key);

    if (!is_null($exo) && ($key != $exo))
    {
        continue;
    }

    $before = microtime();
    exec("php {$solution} < input{$key}.txt > result{$key}.txt 2>&1");
    $after = microtime();

    $actual = trim(file_get_contents("result{$key}.txt"), "\n");
    $expected = trim(file_get_contents("output{$key}.txt"), "\n");

    $time = diff($before, $after);
    if (strcmp($actual, $expected) == 0)
    {
        echo "\t{$key}: " . green("SUCCESS") . " (time = {$time})\n";
    }
    else
    {
        echo "\t{$key}: " . red("FAILED") . " - See error.{$key}.log\n";

        display("Expected:", $expected, 10);
        display("Actual:", $actual, 10);

        ob_start();
        echo "Expected:\n";
        echo "{$expected}\n";
        echo "Actual:\n";
        echo "{$actual}\n";
        file_put_contents("error.{$key}.log", ob_get_clean());
    }
}
