<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
$colors = ['red', 'blue', 'green', 'yellow', 'lime', 'magenta', 'black', 'gold', 'gray', 'tomato'];
function getColors($elements, $count)
{
    $newColors = [];
    for ($i = 1; $i <= $count; $i++) {
        $newColors[$i] = $elements[rand(0, count($elements) - 1)];
    }
    return $newColors;
}

$items = getColors($colors, 25); ?>
<div>
    <?php foreach ($items as $key => $item) : ?>
        <strong style="color: <?php echo $colors[rand(0, count($colors) - 1)] ?>"><?php echo $item ?></strong>
        <?php if ($key % 5 === 0): ?>
            <br>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
</body>
</html>