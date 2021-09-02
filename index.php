<?php

$is_auth = rand(0, 1);
$user_name = 'Игорь'; // укажите здесь ваше имя

date_default_timezone_set('Europe/Moscow');
$title = 'Project site';
$counter = 0; // счетчик для функции generate_random_date

require_once 'bootstrap.php';

$connect = db_connection();
$types_list = get_content_types($connect);
$page_params = popular_params();
$posts_list = get_list_posts($connect, $page_params["type_id"], $page_params["sort_type"], $page_params["sort_direction"]);

$pageContent = include_template(
    'main.php',
    [
        'types' => $types_list,
        'posts' => $posts_list,
        'counter' => $counter,
        'page_params' => $page_params
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
