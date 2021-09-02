<?php

/**
 * Функция для обрезания текста, если он превышает заданную длину
 * @param string $text Входящий текст
 * @param int $count Кол-во символов до обрезания
 * @return mixed|string|void
 */
function cropText($text, $count)
{
    $i = 0;
    $line = "";
    if (strlen($text) > $count) {
        $pieces = explode(" ", $text);
        foreach ($pieces as $piece) {
            $long = strlen($piece);
            $i = $i + $long + 1; //+1 для учитывания пробела между словами
            if ($i < $count) {
                $line .= "$piece ";
            } else {
                return htmlspecialchars(
                        $line,
                        ENT_QUOTES
                    ) . "...<a class='post-text__more-link' href='#'>Читать далее</a>";
            }
        }
    } else {
        return $text;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
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

/**
 * Функция для генерации случайной даты вида Y-m-d H:i:s
 * @param $index
 * @return false|string
 */
function generateRandomDate($index)
{
    $deltas = [
        [
            'minutes' => 59
        ],
        [
            'hours' => 23
        ],
        [
            'days' => 6
        ],
        [
            'weeks' => 4
        ],
        [
            'months' => 11
        ]
    ];

    $countElement = count($deltas);

    if ($index < 0) {
        $index = 0;
    }

    if ($index >= $countElement) {
        $index = $countElement - 1;
    }

    $delta = $deltas[$index];
    $timeVal = rand(1, current($delta));
    $timeName = key($delta);

    $calculateTime = strtotime("$timeVal $timeName ago");

    return date('Y-m-d H:i:s', $calculateTime);
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} ".
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественного числа
 */
function getNounPluralForm(int $number, string $one, string $two, string $many)
{
    //$number = $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        case ($mod100 >= 11 && $mod100 <= 20):
        case ($mod10 > 5):
        default:
            return $many;
    }
}

/**
 * Возвращает img-тег с обложкой видео для вставки на страницу
 * @param string $youtube_url Ссылка на youtube видео
 * @return string
 */
function embed_youtube_cover($youtube_url)
{
    $res = "";
    $id = extract_youtube_id($youtube_url);

    if ($id) {
        $src = sprintf("https://img.youtube.com/vi/%s/mqdefault.jpg", $id);
        $res = '<img alt="youtube cover" width="320" height="120" src="' . $src . '" />';
    }

    return $res;
}

/**
 * Извлекает из ссылки на youtube видео его уникальный ID
 * @param string $youtube_url Ссылка на youtube видео
 * @return array
 */
function extract_youtube_id($youtube_url)
{
    $id = false;

    $parts = parse_url($youtube_url);

    if ($parts) {
        if ($parts['path'] == '/watch') {
            parse_str($parts['query'], $vars);
            $id = $vars['v'] ?? null;
        } else {
            if ($parts['host'] == 'youtu.be') {
                $id = substr($parts['path'], 1);
            }
        }
    }

    return $id;
}

/**
 * Функция для подсчета времени, прошедшего с момента публикации
 * @param $publishTime - время публикации
 * @return string - сколько прошло времени с момента публикации
 */
function publicationLife($publishTime)
{
    $differentTime = time() - strtotime($publishTime);

    switch (true) {
        case ($differentTime < 3600):
            $differentTime = floor($differentTime / 60);
            return "{$differentTime} " .
                getNounPluralForm(
                    $differentTime,
                    'минута',
                    'минуты',
                    'минут'
                ) . " назад";

        case ($differentTime >= 3600 && $differentTime < 86400):
            $differentTime = floor($differentTime / 3600);
            return "{$differentTime} " .
                getNounPluralForm(
                    $differentTime,
                    'час',
                    'часа',
                    'часов'
                ) . " назад";
        case ($differentTime >= 86400 && $differentTime < 604800):
            $differentTime = floor($differentTime / 86400);
            return "{$differentTime} " .
                getNounPluralForm(
                    $differentTime,
                    'день',
                    'дня',
                    'дней'
                ) . " назад";
        case ($differentTime >= 604800 && $differentTime < 2419200):
            $differentTime = floor($differentTime / 604800);
            return "{$differentTime} " .
                getNounPluralForm(
                    $differentTime,
                    'неделя',
                    'недели',
                    'недель'
                ) . " назад";
        case ($differentTime >= 2419200):
            $differentTime = floor($differentTime / 2419200);
            return "{$differentTime} " .
                getNounPluralForm(
                    $differentTime,
                    'месяц',
                    'месяца',
                    'месяцев'
                ) . " назад";
        default:
            return "Время";
    }
}

/**
 * Функция для вытаскивания заголовка с вебсайта
 * @param $link_url
 * @return mixed
 */
function get_link_url_title($link_url){
    $url_contents = file_get_contents($link_url);
    preg_match("/<title>(.*)<\/title>/i", $url_contents, $matches);
    return $matches['1'];
}