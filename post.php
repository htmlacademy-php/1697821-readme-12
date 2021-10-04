<?php

date_default_timezone_set('Europe/Moscow');
$title = 'Project site';

$counter = 0; // счетчик для функции generate_random_date

require_once 'bootstrap.php';
require_once 'post-page-helper.php';


$connect = dbConnection();

$post = handleMissingPost($connect, $title);

$countComment = filter_input(INPUT_GET, 'comments', FILTER_SANITIZE_STRING);
if (!isset($countComment)) {
    $countComment = COUNT_SHOW_COMMENTS;
}

$hashtags = getPostHashtags($connect, $post['id']);
$comments = getPostComments($connect, $post['id'], $countComment);

$postContent = includeTemplate(
    "detail-posts/" . $post['type_title'] . "-post.php",
    ['post' => $post]
);

$pageContent = includeTemplate(
    'post-page.php',
    [
        'postContent' => $postContent,
        'counter' => $counter,
        'post' => $post,
        'hashtags' => $hashtags,
        'comments' => $comments,
        'countComment' => $countComment
    ]
);

$layoutContent = includeTemplate(
    'layout.php',
    [
        'mainContainer' => $pageContent,
        'isAuth' => $_SESSION['isAuth'],
        'userID' => $_SESSION['id'],
        'userEmail' => $_SESSION['userEmail'],
        'userLogin' => $_SESSION['userLogin'],
        'userAvatar' => $_SESSION['avatarUrl'],
        'title' => $title
    ]
);

print($layoutContent);
