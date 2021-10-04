<?php

date_default_timezone_set('Europe/Moscow');
$title = 'readme: поиск';

require_once 'bootstrap.php';

if (empty($_SESSION)) {
    header("Location: /index.php");
}

$connect = dbConnection();

$searchQueryText = !empty($_GET['search']) ? htmlValidate($_GET['search']) : null;
$foundPosts = [];

if ($searchQueryText) {
    $valueQuery = trim($searchQueryText);

    if (substr($valueQuery, 0, 1) === '#') {
        $valueQuery = substr($valueQuery, 1, strlen($valueQuery));
        $foundPosts = getSearchHashtagResult($connect, $valueQuery);
    } else {
        $foundPosts = getSeachResult($connect, $valueQuery);
    }
}

$pageContent = includeTemplate(
    'search-page.php',
    [
        'foundPosts' => $foundPosts,
        'searchQueryText' => $searchQueryText
    ]
);

$layoutContent = includeTemplate(
    'layout.php',
    [
        'mainContainer' => $pageContent,
        'title' => $title,
        'isAuth' => $_SESSION['isAuth'],
        'userID' => $_SESSION['id'],
        'userEmail' => $_SESSION['userEmail'],
        'userLogin' => $_SESSION['userLogin'],
        'userAvatar' => $_SESSION['avatarUrl'],
        'searchQueryText' => $searchQueryText
    ]
);

print($layoutContent);
