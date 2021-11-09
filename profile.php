<?php

date_default_timezone_set('Europe/Moscow');
$title = 'readme: пользователь';

require_once 'bootstrap.php';

if (empty($_SESSION)) {
    header("Location: /index.php");
}
$currentUser = $_SESSION['id'];
$usersWhoLike = [];

$currentTab = $_GET['tab'] ?? 'posts';
$connect = dbConnection();

$userInfo = handleMissingUser($connect, 1, $title);

$userPosts = getUserPosts($connect, $_GET['id']);
$userLikesPosts = getUserLikes($connect, $_GET['id']);
foreach ($userLikesPosts as $userLikesPost) {
    array_push($usersWhoLike, $userLikesPost['who_like_id']);
}
$isYourProfile = $currentUser == $_GET['id'];
$isSubscription = $isYourProfile ? false : !empty(checkSubscription($connect, $currentUser['id'], $_GET['id']));
$usersWhoLike = array_unique($usersWhoLike);
$userDataWhoLikePost = getUserDataWhoLikePost($connect, $usersWhoLike);
$userSubscriptions = getUserSubscriptions($connect, $_GET['id']);

$checkSubs = function ($userId) use ($connect, $currentUser) {
    return !empty(checkSubscription($connect, $userId, $currentUser));
};


$pageContent = includeTemplate(
    'profile/profile-page.php',
    [
        'userInfo' => $userInfo,
        'userPosts' => $userPosts,
        'connect' => $connect,
        'currentTab' => $currentTab,
        'userLikesPosts' => $userLikesPosts,
        'userDataWhoLikePost' => $userDataWhoLikePost,
        'userSubscriptions' => $userSubscriptions,
        'checkSubs' => $checkSubs,
        'currentUser' => $currentUser,
        'isYourProfile' => $isYourProfile,
        'isSubscription' => $isSubscription
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
    ]
);

print($layoutContent);
