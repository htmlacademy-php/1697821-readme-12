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


$error_field_titles = [
    'post-heading' => 'Заголовок',
    'post-tags' => 'Теги',
    'photo-url' => 'Ссылка из интернета',
    'userpic-file-photo' => 'Файл',
    'video-url' => 'Ссылка Youtube',
    'post-text' => 'Текст поста',
    'cite-text' => 'Текст цитаты',
    'quote-author' => 'Автор цитаты',
    'post-link' => 'Ссылка'
];

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
                return validatePhoto("userpic-file-photo");
            },

            "photo-url" => function () {
                return validatePhotoUrl("photo-url");
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


    foreach ($validate[$currentType] as $key => $value) {
        if (isset($validate[$currentType][$key])) {
            $rule = $validate[$currentType][$key];
            $errors[$key] = $rule($value);
        }
    }
}
var_dump($errors);

$addPostContent = includeTemplate(
    "add-posts/" . $currentType . "-post.php",
    [
        'currentType' => $currentType,
        'errors' => $errors
    ]
);

$addFormPost = includeTemplate(
    "add-posts/form-post.php",
    [
        "errors" => $errors,
        "addPostContent" => $addPostContent,
        "types" => $types,
        "currentType" => $currentType
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

