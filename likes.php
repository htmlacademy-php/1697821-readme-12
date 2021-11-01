<?php

require('bootstrap.php');
$connect = dbConnection();
$path = $_SERVER['HTTP_REFERER'];

if (!empty($_GET) &&
    !empty($_GET['post_id']) &&
    !empty($_GET['user_id'])) {
    if (changeLikes($connect, $_GET)) {
        header("Location: $path");
    } else {
        print_r('Не получилось произвести действия с лайками');
    }
}