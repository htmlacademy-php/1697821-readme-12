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
