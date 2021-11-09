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

$errorFieldTitles = [
    'comment' => 'комментарий'
];

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $validate = [
        'comment' => validateMessage("comment")
    ];

    if (!empty($validate['comment'])) {
        $errors['comment'] = $validate['comment'];
    }

    if (!array_filter($errors)) {
        $saveComment = saveComment($connect, $_POST['comment'], $_SESSION['id'], $post['id']);
        $URL = '/post.php?id=' . $post['id'];
        header("Location: $URL");
    }
}
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
        'countComment' => $countComment,
        'errors' => $errors
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
