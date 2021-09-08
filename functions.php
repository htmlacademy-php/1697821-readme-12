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
                return htmlValidate($line) . "...<a class='post-text__more-link' href='#'>Читать далее</a>";
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
function includeTemplate($name, array $data = [])
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
function embedYoutubeCover($youtube_url)
{
    $id = extractYoutubeId($youtube_url);

    if ($id === false) {
        return "";
    }

    $src = sprintf("https://img.youtube.com/vi/%s/mqdefault.jpg", $id);
    return '<img alt="youtube cover" width="320" height="120" src="' . $src . '" />';
}

/**
 * Извлекает из ссылки на youtube видео его уникальный ID
 * @param string $youtube_url Ссылка на youtube видео
 * @return array|false
 */
function extractYoutubeId($youtube_url)
{
    $parts = parse_url($youtube_url);

    if (!$parts) {
        return false;
    }

    if ($parts['path'] == '/watch') {
        parse_str($parts['query'], $vars);
        return $vars['v'] ?? null;
    }

    if ($parts['host'] == 'youtu.be') {
        return substr($parts['path'], 1);
    }

    return false;
}

/**
 * Возвращает код iframe для вставки youtube видео на страницу
 * @param string $youtube_url Ссылка на youtube видео
 * @return string
 */
function embedYoutubeVideo($youtube_url)
{
    $id = extractYoutubeId($youtube_url);
    if ($id === false) {
        return "";
    }

    $src = "https://www.youtube.com/embed/" . $id;
    return '<iframe width="760" height="400" src="' . $src . '" frameborder="0"></iframe>';
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
function getLinkUrlTitle($link_url)
{
    $url_contents = file_get_contents($link_url);
    preg_match("/<title>(.*)<\/title>/i", $url_contents, $matches);
    return $matches[1] ?? $link_url;
}

/**
 * Функция для добавления классов в виды сортировок
 * @param $page_params
 * @param $sort_type
 * @return string
 */
function popularAddClass($page_params, $sort_type)
{
    $popularAddClass = '';
    if (!empty($page_params['sort_type']) && $page_params['sort_type'] == $sort_type) {
        $popularAddClass .= " sorting__link--active";
    }
    if ($page_params['sort_direction'] == 'asc') {
        $popularAddClass .= " sorting__link--reverse";
    }
    return $popularAddClass;
}

/**
 * Массив для проверки данных сортировки
 * @return array
 */
function getPageDefaultParams()
{
    return [
        "type_id" => [0, 1, 2, 3, 4, 5],
        "sort_type" => ["popular", "like", "date"],
        "sort_direction" => ["asc", "desc"]
    ];
}


/**
 * Функция задает параметры страницы Популярное
 * Вначале задаются дефолтные параметры страницы
 * Если есть параметры, полученные из GET запроса,
 * то перезаписывает этот параметр в массиве page_params,
 * если они проходят проверку.
 * @return array
 */
function popularParams()
{
    $avail_params = getPageDefaultParams();

    $page_params = ["type_id" => 0, "sort_type" => "popular", "sort_direction" => "desc"];

    if (!empty($_GET["type_id"])) {
        $type_id = filter_input(INPUT_GET, "type_id", FILTER_SANITIZE_NUMBER_INT);
        if (in_array($type_id, $avail_params["type_id"])) {
            $page_params["type_id"] = $type_id;
        }
    }
    if (!empty($_GET["sort_type"])) {
        $type_id = filter_input(INPUT_GET, "sort_type", FILTER_SANITIZE_STRING);
        if (in_array($type_id, $avail_params["sort_type"])) {
            $page_params["sort_type"] = $type_id;
        }
    }
    if (!empty($_GET["sort_direction"])) {
        $type_id = filter_input(INPUT_GET, "sort_direction", FILTER_SANITIZE_STRING);
        if (in_array($type_id, $avail_params["sort_direction"])) {
            $page_params["sort_direction"] = $type_id;
        }
    }
    return $page_params;
}

/**
 * Функция для генерации параметров ссылок сортировки
 * На вход подается массив текущих параметров и массив параметров для ссылки
 * На выходе мы получаем обновленный массив параметров
 * @param array $page_params
 * @param array $mod_params
 * @param false $reverseSort
 * @return array|mixed
 */
function modPageParams($page_params = [], array $mod_params = [], $reverseSort = false)
{
    if (!empty($mod_params["sort_type"]) && $page_params["sort_type"] != $mod_params["sort_type"]) {
        $reverseSort = false;
        $page_params["sort_direction"] = "desc";
    }

    if ($reverseSort) {
        $page_params['sort_direction'] = ($page_params['sort_direction'] == 'asc') ? 'desc' : 'asc';
    }

    foreach ($mod_params as $mod => $value) {
        $page_params[$mod] = $value;
    }
    return $page_params;
}

/**
 * Функция гля генерации ссылки сортировки
 * @param array $page_params
 * @param array $mod_params
 * @param false $reverseSort
 * @return string
 */
function getModPageQuery($page_params = [], array $mod_params = [], $reverseSort = false)
{
    $params = modPageParams($page_params, $mod_params, $reverseSort);
    return http_build_query($params);
}

/**
 * Функция для проверки кол-ва отображаемых комментариев
 * @param array $post
 * @return bool
 */
function isShowAllComments(array $post)
{
    if (filter_input(INPUT_GET, "comments", FILTER_SANITIZE_STRING) != 'all' &&
        $post['count_post_comments'] >= COUNT_SHOW_COMMENTS) {
        return true;
    }
    return false;
}

/**
 * Convert all applicable characters to HTML entities.
 * @param $text -The string being converted.
 * @return string The converted string.
 */
function htmlValidate($text)
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}