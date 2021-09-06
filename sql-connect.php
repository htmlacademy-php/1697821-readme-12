<?php

/**
 * Функция db_connection производит подключение к базе данных.
 * Переменные db_hostname, db_username, db_password, db_name находятся в файле constants.php.
 * Если подключение не выполнено, то происходит вывод ошибки подключения и операции приостанавливаются.
 * @return mysqli|void
 */
function dbConnection()
{
    $connect = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
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
function getContentTypes($connect)
{
    $sqlCategory = "SELECT id, title, icon_url FROM types";
    $resultCategory = mysqli_query($connect, $sqlCategory);

    if (!$resultCategory) {
        exit('Ошибка запроса: ' . mysqli_error($connect));
    }

    return mysqli_fetch_all($resultCategory, MYSQLI_ASSOC);
}

/**
 * Функция получает 6 (число можно изменить изменив константу quality_popular_posts)
 * самых популярных постов из БД readme.
 * Возвращает массив содержащий данные поста,
 * объединённых с данными пользователей, типами постов и отсортированные по популярности.
 * Если подключение не выполнено, то происходит вывод ошибки подключения и операции приостанавливаются.
 * @param $connect
 * @param $typeId - для сортировки по типу поста
 * @param $sortType - для сортировки по популярности, лайкам или дате
 * @param $sortDirection - для сортировки ASC, DESC
 * @return array|void
 */
function getListPosts($connect, $typeId, $sortType, $sortDirection)
{
    $order = "";
    switch ($sortType) {
        case 'popular':
            $order = " posts.views_count $sortDirection";
            break;
        case 'like':
            $order = " count_post_likes $sortDirection";
            break;
        case 'date':
            $order = " posts.created_at $sortDirection";
            break;
    }

    $sqlPosts = "SELECT
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
WHERE $typeId > 0 AND types.id = $typeId OR $typeId = 0 AND types.id >= $typeId
ORDER BY " . $order . " LIMIT " . QUALITY_POPULAR_POSTS;

    $resultPosts = mysqli_query($connect, $sqlPosts);

    if (!$resultPosts) {
        exit('Ошибка запроса: ' . mysqli_error($connect));
    }

    return mysqli_fetch_all($resultPosts, MYSQLI_ASSOC);
}

/**
 * Функция получает на вход id поста и запрашивает необходимые данные из БД по данному посту
 * @param $connect
 * @param $id -id поста
 * @return array|void
 * @throws Exception
 */
function getPost($connect, $id)
{
    if (empty($id)) {
        throw new Exception('Не задан ID поста');
    }
    $sqlPostInfo = "SELECT
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

    $resultPost = mysqli_query($connect, $sqlPostInfo);

    if (!$resultPost) {
        exit('Ошибка запроса: ' . mysqli_error($connect));
    }

    if ($post = mysqli_fetch_assoc($resultPost)) {
        return $post;
    }

    throw new Exception('Пост не найден');
}

function getPostHashtags($connect, $id)
{
    $sqlPostHashtags = "SELECT
        post_hashtags.post_id,
        post_hashtags.hashtag_id,
        hashtags.title AS 'hashtag_title'
FROM post_hashtags
        INNER JOIN hashtags ON post_hashtags.hashtag_id = hashtags.id
WHERE post_hashtags.post_id = $id";

    $resultPost = mysqli_query($connect, $sqlPostHashtags);

    if (!$resultPost) {
        exit('Ошибка запроса: ' . mysqli_error($connect));
    }

    return mysqli_fetch_all($resultPost, MYSQLI_ASSOC);
}

function getPostComments($connect, $id, $countComments)
{
    $limit = "";
    if ($countComments != 'all') {
        $limit = "LIMIT $countComments";
    }

    $sqlPostHashtags = "SELECT
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

    $resultPost = mysqli_query($connect, $sqlPostHashtags);

    if (!$resultPost) {
        exit('Ошибка запроса: ' . mysqli_error($connect));
    }

    return mysqli_fetch_all($resultPost, MYSQLI_ASSOC);
}
