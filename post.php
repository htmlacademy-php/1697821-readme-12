<?php

$is_auth = rand(0, 1);
$user_name = 'Игорь'; // укажите здесь ваше имя

date_default_timezone_set('Europe/Moscow');
$title = 'Project site';

$counter = 0; // счетчик для функции generate_random_date

require_once 'bootstrap.php';

$post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (empty($post_id)) {
    include("templates/not-found-page.php");
    exit();
}
$connect = db_connection();
$post_page = get_post_info($connect, $post_id);
if (empty($post_page)) {
    include("templates/not-found-page.php");
    exit();
}
$count_comment = filter_input(INPUT_GET, 'comments', FILTER_SANITIZE_STRING);
if (!isset($count_comment)) $count_comment = count_show_comments;

$hashtags = get_post_hashtags($connect, $post_id);
$comments = get_post_comments($connect, $post_id, $count_comment);
$pageContent = include_template(
    'post-page.php',
    [
        'counter' => $counter,
        'post_page' => $post_page,
        'hashtags' => $hashtags,
        'comments' => $comments,
        'count_comment' => $count_comment
    ]
);

$layoutContent = include_template(
    'layout.php',
    [
        'mainContainer' => $pageContent,
        'is_auth' => $is_auth,
        'title' => $title
    ]
);

print($layoutContent);
