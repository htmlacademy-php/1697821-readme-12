<?php

$is_auth = rand(0, 1);
$user_name = 'Игорь'; // укажите здесь ваше имя

date_default_timezone_set('Europe/Moscow');
$title = 'Project site';

$counter = 0; // счетчик для функции generate_random_date

require_once 'constant.php';
require_once 'functions.php';
require_once 'sql-connect.php';

$connect = db_connection();
$types_list = get_content_types($connect);
$posts_list = get_list_posts($connect);

$pageContent = include_template(
    'main.php',
    [
        'types' => $types_list,
        'posts' => $posts_list,
        'counter' => $counter
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
