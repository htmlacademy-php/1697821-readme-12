<?php

/**
 * Функция db_connection производит подключение к базе данных.
 * Переменные db_hostname, db_username, db_password, db_name находятся в файле constants.php.
 * Если подключение не выполнено, то происходит вывод ошибки подключения и операции приостанавливаются.
 * @return mysqli|void
 */
function db_connection()
{
    $connect = mysqli_connect(db_hostname, db_username, db_password, db_name);
    mysqli_set_charset($connect, "utf8");

    if ($connect == false) {
        exit("Ошибка подключения: " . mysqli_connect_error());
    }

    return $connect;
}

/**
 * Функция получает все типы постов из БД readme.
 * Возвращает массив содержащий id типов постов, названия типов постов и ссылки на иконки типов постов.
 * @param $connect
 * @return array|void
 */
function get_content_types($connect)
{
    $sql_category = "SELECT id, title, icon_url FROM types";
    $result_category = mysqli_query($connect, $sql_category);

    if (!$result_category) {
        exit('Ошибка запроса: ' . mysqli_error($connect));
    }

    return mysqli_fetch_all($result_category, MYSQLI_ASSOC);
}

/**
 * Функция получает 6 (число можно изменить изменив константу quality_popular_posts)
 * самых популярных постов из БД readme.
 * Возвращает массив содержащий данные поста,
 * объединённых с данными пользователей, типами постов и отсортированные по популярности.
 * Если подключение не выполнено, то происходит вывод ошибки подключения и операции приостанавливаются.
 * @param $connect
 * @param $type_id - для сортировки по типу поста
 * @param $sort_type - для сортировки по популярности, лайкам или дате
 * @param $sort_direction - для сортировки ASC, DESC
 * @return array|void
 */
function get_list_posts($connect, $type_id, $sort_type, $sort_direction)
{
    $order = "";
    switch ($sort_type) {
        case 'popular':
            $order = " posts.views_count $sort_direction";
            break;
        case 'like':
            $order = " count_post_likes $sort_direction";
            break;
        case 'date':
            $order = " posts.created_at $sort_direction";
            break;
    }

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
        posts.views_count,
        (SELECT COUNT(likes.user_id) FROM likes WHERE likes.post_id = posts.id) AS 'count_post_likes',
        (SELECT COUNT(comments.id) FROM comments WHERE comments.post_id=posts.id) AS 'count_post_comments'
FROM posts
          INNER JOIN users ON posts.user_id = users.id
          INNER JOIN types ON posts.type_id = types.id
WHERE $type_id > 0 AND types.id = $type_id OR $type_id = 0 AND types.id >= $type_id
ORDER BY " . $order . " LIMIT " . quality_popular_posts;

    $result_posts = mysqli_query($connect, $sql_posts);

    if (!$result_posts) {
        exit('Ошибка запроса: ' . mysqli_error($connect));
    }

    return mysqli_fetch_all($result_posts, MYSQLI_ASSOC);
}

/**
 * Функция получает на вход id поста и запрашивает необходимые данные из БД по данному посту
 * @param $connect
 * @param $id -id поста
 * @return array|void
 */
function get_post_info($connect, $id)
{
    $sql_post_info = "SELECT
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
        posts.views_count,
        (SELECT COUNT(posts.id) FROM posts WHERE posts.user_id = users.id) AS 'count_user_posts',
        (SELECT COUNT(likes.user_id) FROM likes WHERE likes.post_id = posts.id) AS 'count_post_likes',
        (SELECT COUNT(subscriptions.subscriber_user_id) FROM subscriptions WHERE subscriptions.subscribed_to_user_id = users.id) AS 'count_user_subscribers',
        (SELECT COUNT(comments.id) FROM comments WHERE comments.post_id=posts.id) AS 'count_post_comments',
        (SELECT COUNT(posts.id) FROM posts WHERE posts.repost_flag = 1) AS 'count_post_reposts'
FROM posts
          INNER JOIN users ON posts.user_id = users.id
          INNER JOIN types ON posts.type_id = types.id
WHERE posts.id = $id";

    $result_post = mysqli_query($connect, $sql_post_info);

    if (!$result_post) {
        exit('Ошибка запроса: ' . mysqli_error($connect));
    }

    return mysqli_fetch_all($result_post, MYSQLI_ASSOC);
}

function get_post_hashtags($connect, $id)
{
    $sql_post_hashtags = "SELECT
        post_hashtags.post_id,
        post_hashtags.hashtag_id,
        hashtags.title AS 'hashtag_title'
FROM post_hashtags
        INNER JOIN hashtags ON post_hashtags.hashtag_id = hashtags.id
WHERE post_hashtags.post_id = $id";

    $result_post = mysqli_query($connect, $sql_post_hashtags);

    if (!$result_post) {
        exit('Ошибка запроса: ' . mysqli_error($connect));
    }

    return mysqli_fetch_all($result_post, MYSQLI_ASSOC);
}

function get_post_comments($connect, $id, $count_comments)
{
    $limit = "";
    if ($count_comments != 'all') {
        $limit = "LIMIT $count_comments";
    }

    $sql_post_hashtags = "SELECT 
        comments.id,
        comments.content,
        comments.created_at,
        comments.updated_at,
        users.id AS 'user_id',
        users.login AS 'user_login',
        users.avatar_url AS 'user_avatar_url',
        posts.id AS 'post_id'
FROM comments
        INNER JOIN users ON comments.user_id = users.id
        INNER JOIN posts ON comments.post_id = posts.id
WHERE posts.id = $id
ORDER BY comments.created_at DESC $limit";

    $result_post = mysqli_query($connect, $sql_post_hashtags);

    if (!$result_post) {
        exit('Ошибка запроса: ' . mysqli_error($connect));
    }

    return mysqli_fetch_all($result_post, MYSQLI_ASSOC);
}
