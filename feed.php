<?php

$user_name = 'Игорь'; // укажите здесь ваше имя

date_default_timezone_set('Europe/Moscow');
$title = 'readme: лента';

require_once 'bootstrap.php';

if (empty($_SESSION)) {
    header("Location: /index.php");
}

$connect = dbConnection();
$typesList = getContentTypes($connect);
$validTypeId = getPageDefaultParams();
$currentTypeID = 0;
if (isset($_GET['id']) && in_array(intval($_GET['id']), $validTypeId["type_id"], true)) {
    $currentTypeID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
}
$userFeed = getUserFeed($connect, $_SESSION['id'], $currentTypeID);

$pageContent = includeTemplate(
    'feed-page.php',
    [
        'types' => $typesList,
        'currentTypeID' => $currentTypeID,
        'posts' => $userFeed
    ]
);

$layoutContent = includeTemplate(
    'layout.php',
    [
        'mainContainer' => $pageContent,
        'title' => $title,
        'activePage' => "feed",
        'isAuth' => $_SESSION['isAuth'],
        'userID' => $_SESSION['id'],
        'userEmail' => $_SESSION['userEmail'],
        'userLogin' => $_SESSION['userLogin'],
        'userAvatar' => $_SESSION['avatarUrl']
    ]
);

print($layoutContent);