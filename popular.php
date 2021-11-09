<?php

date_default_timezone_set('Europe/Moscow');
$title = 'Project site';
$counter = 0; // счетчик для функции generate_random_date

require_once 'bootstrap.php';

if (empty($_SESSION)) {
    header("Location: /index.php");
}

$connect = dbConnection();
$typesList = getContentTypes($connect);
$pageParams = popularParams();
$offset = ($pageParams['page'] - 1) * QUANTITY_POPULAR_POSTS;
$countPosts = getCountPosts($connect, $pageParams["type_id"], $pageParams["sort_type"], $pageParams["sort_direction"]);
$postsList = getListPosts(
    $connect,
    $pageParams["type_id"],
    $pageParams["sort_type"],
    $pageParams["sort_direction"],
    $offset
);

$pageContent = includeTemplate(
    'popular-page.php',
    [
        'types' => $typesList,
        'posts' => $postsList,
        'counter' => $counter,
        'pageParams' => $pageParams,
        'countPosts' => $countPosts
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
        'activePage' => "popular",
        'title' => $title
    ]
);

print($layoutContent);
