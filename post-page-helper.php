<?php

/**
 * Функция для вывода not-found-page.php
 * @param $isAuth
 * @param $title
 */
function showNotFoundPage($isAuth, $title)
{
    $pageContent = includeTemplate(
        'not-found-page.php'
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
}

/**
 * Функция для обработки случая когда поста не существует или не был передан ID
 * @param $connect
 * @param $isAuth
 * @param $title
 * @return array|void
 */
function handleMissingPost($connect, $title)
{
    try {
        $postId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        return getPost($connect, $postId);
    } catch (Exception $e) {
        showNotFoundPage($title);
        exit();
    }
}
