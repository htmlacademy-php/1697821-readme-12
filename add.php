<?php

$isAuth = rand(0, 1);
$user_name = 'Игорь'; // укажите здесь ваше имя

date_default_timezone_set('Europe/Moscow');
$title = 'readme: добавление публикации';

require_once 'bootstrap.php';

$connect = dbConnection();
$types = getContentTypes($connect);
$currentType = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
if (!isset($currentType)) {
    $currentType = 'text';
}

$errorFieldTitles = [
    'heading' => 'Заголовок',
    'post-tags' => 'Теги',
    'photo-url' => 'Ссылка из интернета',
    'userpic-file-photo' => 'Изображение',
    'video-url' => 'Ссылка Youtube',
    'post-text' => 'Текст поста',
    'quote-text' => 'Текст цитаты',
    'quote-author' => 'Автор цитаты',
    'post-link' => 'Ссылка'
];

$errors = [];

$validate = [
    'quote' => [
        "heading" => function () {
            return validateHeading("heading");
        },

        "quote-text" => function () {
            return validateQuote("quote-text");
        },

        "quote-author" => function () {
            return validateQuoteAuthor("quote-author");
        },

        "post-tags" => function () {
            return validateHashtag("post-tags");
        }
    ],
    'text' => [
        "heading" => function () {
            return validateHeading("heading");
        },

        "post-text" => function () {
            return validatePostText("post-text");
        },

        "post-tags" => function () {
            return validateHashtag("post-tags");
        }
    ],
    'photo' => [
        "heading" => function () {
            return validateHeading("heading");
        },

        "userpic-file-photo" => function () {
            return validateImage("userpic-file-photo");
        },

        "photo-url" => function () {
            return validateImageUrl("photo-url");
        },

        "post-tags" => function () {
            return validateHashtag("photo-tags");
        }
    ],
    'video' => [
        "heading" => function () {
            return validateHeading("heading");
        },

        "video-url" => function () {
            return validateVideo("video-url");
        },

        "post-tags" => function () {
            return validateHashtag("video-tags");
        }
    ],
    'link' => [
        "heading" => function () {
            return validateHeading("heading");
        },

        "post-link" => function () {
            return validateUrl("post-link");
        },

        "link-tags" => function () {
            return validateHashtag("link-tags");
        }
    ]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($validate[$currentType] as $key => $value) {
        if (!empty($validate[$currentType][$key])) {
            $rule = $validate[$currentType][$key];
            $errors[$key] = $rule($value);
        }
    }

    if (!array_filter($errors)) {
        $fileUrl = null;
        if ($currentType === 'photo') {
            $fileUrl = uploadImage('userpic-file-photo', 'photo-url');
        }

        $postTypeId = $types[array_search($currentType, array_column($types, 'title'))]['id'];
        $post_id = savePost($connect, $_POST, $postTypeId, $currentType, $fileUrl);

        if (isset($_POST['post-tags'])) {
            save_tags($connect, $_POST['post-tags'], $post_id);
        }

        $URL = '/post.php?id=' . $post_id;
        header("Location: $URL");
    }
}

$addPostContent = includeTemplate(
    "add-posts/" . $currentType . "-post.php",
    [
        'errors' => $errors
    ]
);

$addFormPost = includeTemplate(
    "add-posts/form-post.php",
    [
        "errors" => $errors,
        "addPostContent" => $addPostContent,
        "currentType" => $currentType,
        'errorTitleRus' => $errorFieldTitles
    ]
);

$pageContent = includeTemplate(
    'add-post.php',
    [
        'addFormPost' => $addFormPost,
        'types' => $types,
        'errors' => $errors,
        'currentType' => $currentType
    ]
);

$layoutContent = includeTemplate(
    'layout.php',
    [
        'mainContainer' => $pageContent,
        'isAuth' => $isAuth,
        'title' => $title
    ]
);

print($layoutContent);
