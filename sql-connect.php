<?php
/**
 * Функция db_connection производит подключение к базе данных "readme".
 * Если подключение не выполнено, то происходит вывод ошибки подключения и операции приостанавливаются.
 * @return mysqli
 */
function db_connection()
{
    $connect = mysqli_connect("localhost","root","root","readme");
    mysqli_set_charset($connect,"utf8");

    if ($connect==false) {
        exit("Ошибка подключения: " . mysqli_connect_error());
    }

    return $connect;
}

/**
 * Функция получает все типы постов из БД readme
 * @param $connect --подключение к БД
 * @return array --массив содержащий типы данных и ссылки на иконки
 */

function get_content_types($connect)
{
    $sql_category = "SELECT id, title, icon_url FROM types";
    $result_category = mysqli_query($connect,$sql_category);

    if (!$result_category) {
        exit('Ошибка запроса: ' . mysqli_error($connect));
    }

    return mysqli_fetch_all($result_category,MYSQLI_ASSOC);
}

/**
 * Функция получает 6 самых популярных постов из БД readme
 * @param $connect --подключение к БД
 * @return array --массив содержащий данные поста, объединённых с данными пользователей, типами постов и отсортированные по популярности
 * --todo ps не знаю насколько обязательно каждому столбцу задавать новые названия через AS ?????
 * --todo следует ли в данных функциях указывать return type :array ?????
 */

function get_list_posts($connect)
{
    $sql_posts = "SELECT
        posts.id,
        posts.title,
        types.id AS 'type_id',
        types.title AS 'type_title',
        posts.content,
        posts.author_quote,
        posts.image_url,
        posts.video_url,
        posts.website_url,
        users.id AS 'user_id',
        users.login AS 'user_login',
        users.avatar_url AS 'user_avatar_url',
        posts.views_count
FROM posts
          INNER JOIN users ON posts.user_id = users.id
          INNER JOIN types ON posts.type_id = types.id
ORDER BY posts.views_count DESC LIMIT 6";

    $result_posts = mysqli_query($connect,$sql_posts);

    if (!$result_posts) {
        exit('Ошибка запроса: ' . mysqli_error($connect));
    }

    return mysqli_fetch_all($result_posts,MYSQLI_ASSOC);
}

