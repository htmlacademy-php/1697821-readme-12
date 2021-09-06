<?php

$isAuth = rand(0, 1);
$user_name = 'Игорь'; // укажите здесь ваше имя

date_default_timezone_set('Europe/Moscow');
$title = 'Project site';
$counter = 0; // счетчик для функции generate_random_date

require_once 'bootstrap.php';

$connect = dbConnection();
$typesList = getContentTypes($connect);
$pageParams = popularParams();
$postsList = getListPosts($connect, $pageParams["type_id"], $pageParams["sort_type"], $pageParams["sort_direction"]);

$pageContent = includeTemplate(
    'main.php',
    [
        'types' => $typesList,
        'posts' => $postsList,
        'counter' => $counter,
        'page_params' => $pageParams
    ]
);

$layoutContent = includeTemplate(
    'layout.php',
    [
        'mainContainer' => $pageContent,
        'is_auth' => $isAuth,
        'title' => $title
    ]
);

print($layoutContent);
