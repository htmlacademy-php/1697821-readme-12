<?php

$isAuth = rand(0, 1);
$user_name = 'Игорь'; // укажите здесь ваше имя

date_default_timezone_set('Europe/Moscow');
$title = 'Project site';

$counter = 0; // счетчик для функции generate_random_date

require_once 'bootstrap.php';
require_once 'post-page-helper.php';


$connect = dbConnection();

$post = handleMissingPost($connect, $isAuth, $title);


$count_comment = filter_input(INPUT_GET, 'comments', FILTER_SANITIZE_STRING);
if (!isset($count_comment)) {
    $count_comment = COUNT_SHOW_COMMENTS;
}

$hashtags = getPostHashtags($connect, $post['id']);
$comments = getPostComments($connect, $post['id'], $count_comment);
$pageContent = includeTemplate(
    'post-page.php',
    [
        'counter' => $counter,
        'post' => $post,
        'hashtags' => $hashtags,
        'comments' => $comments,
        'count_comment' => $count_comment
    ]
);

$layoutContent = includeTemplate(
    'layout.php',
    [
        'mainContainer' => $pageContent,
        'isAuth' => $isAuth,
        'title' => $title
    ]
);

print($layoutContent);
