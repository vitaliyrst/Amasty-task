<?php
echo 'Введите значения: ' . PHP_EOL;
$getLine = trim(fgets(STDIN));

$numbers = explode(' ', $getLine);
$getNewNumbers = [];

foreach ($numbers as $number) {
    if (preg_match('/^-?[1-9][0-9]*$/', $number) || $number === '0') {
        $getNewNumbers[] = $number;
    }
    sort($getNewNumbers);
    $result = array_unique($getNewNumbers, SORT_NUMERIC);
}

fwrite(STDOUT, implode(' ', $result));
