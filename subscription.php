<?php

require('bootstrap.php');

$connect = dbConnection();
$path = $_SERVER['HTTP_REFERER'];

if (!empty($_GET) &&
    !empty($_GET['user_id']) &&
    !empty($_GET['follower_id']) &&
    !empty($_GET['action'])) {
    if (changeSubscription($connect, $_GET)) {
        $subTo = getUserInfo($connect, $_GET['user_id']);
        //mailSubMessage($_SESSION, $subTo);
        header("Location: $path");
    } else {
        print_r('Не получилось произвести действия с подпиской');
    }
}
