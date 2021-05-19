<?php
function cropText($text, $count)
{
    $i = 0;
    $line = "";
    if (strlen($text) > $count) {
        $pieces = explode(" ", $text);
        foreach ($pieces as $piece) {
            $long = strlen($piece);
            $i = $i + $long+'1'; //+1 для учитывания пробела между словами
            if ($i < $count) {
                $line .= "$piece ";
            } else {
                return htmlspecialchars($line, ENT_QUOTES) . "...<a class='post-text__more-link' href='#'>Читать далее</a>";
            }
        }
    } else {
        return $text;
    }
}

function include_template($name, array $data = [])
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function generate_random_date($index)
{
    $deltas = [['minutes' => 59], ['hours' => 23], ['days' => 6], ['weeks' => 4], ['months' => 11]];
    $dcnt = count($deltas);

    if ($index < 0) {
        $index = 0;
    }

    if ($index >= $dcnt) {
        $index = $dcnt - 1;
    }

    $delta = $deltas[$index];
    $timeval = rand(1, current($delta));
    $timename = key($delta);

    $ts = strtotime("$timeval $timename ago");
    $dt = date('Y-m-d H:i:s', $ts);

    return $dt;
}

function get_noun_plural_form(int $number, string $one, string $two, string $many)
{
    $number = (int)$number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

function publication_life($publishTime)
{
    $currentTime = time();
    $differentTime = $currentTime - strtotime($publishTime);

    switch (true) {
        case ($differentTime < 3600):
            $differentTime = floor($differentTime / 60);
            return "{$differentTime} " .
                get_noun_plural_form(
                    $differentTime,
                    'минута',
                    'минуты',
                    'минут'
                ) . " назад";

        case ($differentTime >= 3600 && $differentTime < 86400):
            $differentTime = floor($differentTime / 3600);
            return "{$differentTime} " .
                get_noun_plural_form(
                    $differentTime,
                    'час',
                    'часа',
                    'часов'
                ) . " назад";
        case ($differentTime >= 86400 && $differentTime < 604800):
            $differentTime = floor($differentTime / 86400);
            return "{$differentTime} " .
                get_noun_plural_form(
                    $differentTime,
                    'день',
                    'дня',
                    'дней'
                ) . " назад";
        case ($differentTime >= 604800 && $differentTime < 2419200):
            $differentTime = floor($differentTime / 604800);
            return "{$differentTime} " .
                get_noun_plural_form(
                    $differentTime,
                    'неделя',
                    'недели',
                    'недель'
                ) . " назад";
        case ($differentTime >= 2419200):
            $differentTime = floor($differentTime / 2419200);
            return "{$differentTime} " .
                get_noun_plural_form(
                    $differentTime,
                    'месяц',
                    'месяца',
                    'месяцев'
                ) . " назад";
        default:
            return "Время";
    }
}
