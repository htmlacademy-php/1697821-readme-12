<?php

$user_name = 'Игорь'; // укажите здесь ваше имя

date_default_timezone_set('Europe/Moscow');
$title = 'readme: регистрация';

require_once 'bootstrap.php';

$connect = dbConnection();

$errorFieldTitles = [
    'email' => 'Почта',
    'login' => 'Логин',
    'password' => 'Пароль',
    'password-repeat' => 'Повтор пароля',
    'userpic-file' => 'Фото'
];

$errors = [];

$validate = [
    "email" => function () use ($connect) {
        return validateEmail("email", $connect);
    },

    "login" => function () {
        return validateLogin("login");
    },

    "password" => function () {
        return validatePassword("password");
    },

    "password-repeat" => function () {
        return validateRepeatPassword("password", "password-repeat");
    },

    "userpic-file" => function () {
        return validateImage("userpic-file");
    }
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($validate as $key => $value) {
        if (!empty($value())) {
            $errors[$key] = $value();
        }
    }

    if (!array_filter($errors)) {
        $fileUrl = null;

        if (!empty($_POST['userpic-file-photo'])) {
            $photoPath = '/uploads/users/';
            $fileUrl = saveImage('userpic-file-photo');
        }


        saveUser($connect, $_POST, $fileUrl);
        header("Location: /");
    }
}


$pageContent = includeTemplate(
    'reg-page.php',
    [
        'errors' => $errors,
        'errorTitleRus' => $errorFieldTitles
    ]
);

$layoutContent = includeTemplate(
    'layout.php',
    [
        'mainContainer' => $pageContent,
        'title' => $title,
        'isRegPage' => true,
        'isAuth' => 0
    ]
);

print($layoutContent);
