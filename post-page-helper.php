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
            'is_auth' => $isAuth,
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
function handleMissingPost($connect, $isAuth, $title)
{
    try {
        $postId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        return getPost($connect, $postId);
    } catch (Exception $e) {
        showNotFoundPage($isAuth, $title);
        exit();
    }
}
