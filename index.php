<?php

date_default_timezone_set('Europe/Moscow');
$title = 'readme: незарегистрированный пользователь';

require_once 'bootstrap.php';

if (!empty($_SESSION)) {
    header("Location: /feed.php");
}

$connect = dbConnection();

$validate = [
    "login" => function () use ($connect) {
        return validateEnterEmail("login", $connect);
    },

    "password" => function () use ($connect) {
        return validateEnterPassword("password", $connect);
    }
];
$errorsFieldTitles = [
    'login' => 'Логин',
    'password' => 'Пароль'
];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($validate as $key => $value) {
        if (!empty($value())) {
            $errors[$key] = $value();
        }
    }

    if (!array_filter($errors)) {
        $userData = getUserData($connect, $_POST['login']);
        $_SESSION['isAuth'] = 1;
        $_SESSION['userLogin'] = $userData['login'];
        $_SESSION['userEmail'] = $userData['email'];
        $_SESSION['avatarUrl'] = $userData['avatar_url'];
        $_SESSION['id'] = $userData['id'];

        header("Location: /popular.php");
    }
}

$pageContent = includeTemplate(
    'main.php',
    [
        'errors' => $errors
    ]
);

$layoutContent = includeTemplate(
    'layout.php',
    [
        'mainContainer' => $pageContent,
        'title' => $title,
        'isMainPage' => true
    ]
);

print($layoutContent);