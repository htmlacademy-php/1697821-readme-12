<?php

$isAuth = rand(0, 1);
$user_name = 'Игорь'; // укажите здесь ваше имя

date_default_timezone_set('Europe/Moscow');
$title = 'readme: добавление публикации';

require_once 'bootstrap.php';

$connect = dbConnection();
$types = getContentTypes($connect);
$typeId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!isset($typeId)) {
    $typeId = 1;
}

$currentType = $types[array_search($typeId, array_column($types, 'id'))]['title'];


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
    /*    $required = [
            'quote' => ["heading", "quote-text", "quote-author"],
            'text' => ["heading", "post-text"],
            'photo' => ["heading", "userpic-file-photo"],
            'video' => ["heading", "video-url"],
            'link' => ["heading", "post-link"]
        ];*/


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

            "post-tags" => function () {
                return validateHashtag("post-tags");
            }
        ]
    ];

    $fields = [
        "text" => filter_input_array(
            INPUT_POST,
            [
                "heading" => FILTER_SANITIZE_STRING,
                "post-text" => FILTER_SANITIZE_STRING,
                "post-tags" => FILTER_SANITIZE_STRING
            ],
            true
        ),
        "quote" => filter_input_array(
            INPUT_POST,
            [
                "heading" => FILTER_SANITIZE_STRING,
                "quote-text" => FILTER_SANITIZE_STRING,
                "quote-author" => FILTER_SANITIZE_STRING,
                "quote-tags" => FILTER_SANITIZE_STRING
            ],
            true
        ),
        "photo" => filter_input_array(
            INPUT_POST,
            [
                "heading" => FILTER_SANITIZE_STRING,
                "userpic-file-photo",
                "photo-url" => FILTER_SANITIZE_STRING,
                "photo-tags" => FILTER_SANITIZE_STRING
            ],
            true
        )
    ];

    foreach ($fields['text'] as $key => $value) {
        if (isset($validate['text'][$key])) {
            $rule = $validate['text'][$key];
            $errors[$key] = $rule($value);
        }
    }
}

var_dump($errors);


$addPosts = getAddPost($connect, $typeId);

$pageContent = includeTemplate(
    'add-post.php',
    [
        'addPosts' => $addPosts,
        'types' => $types,
        'typeId' => $typeId,
        'errors' => $errors
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

