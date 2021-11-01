<?php

/**
 * Функция преобразует специальные символы в HTML-сущности
 * с помощью функции htmlspecialchars с флагами
 * @param $text
 * @return string
 */
function htmlValidate($text)
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Функция для валидации поля заголовка при добавлении поста
 * и вывода ошибок, если валидация не прошла
 * @param $value
 * @return string|void
 */
function validateHeading($value)
{
    $len = strlen(trim($_POST[$value]));

    if (empty(trim($_POST[$value]))) {
        return "Это поле должно быть заполнено";
    }

    if ($len < 5 or $len > 50) {
        return "Значение должно быть от 5 до 50 символов";
    }
}

/**
 * Функция для валидации поля цитаты при добавлении поста
 * и вывода ошибок, если валидация не прошла
 * @param $value
 * @return string|void
 */
function validateQuote($value)
{
    $len = strlen(trim($_POST[$value]));

    if (empty(trim($_POST[$value]))) {
        return "Это поле должно быть заполнено";
    }

    if ($len < 5 or $len > 70) {
        return "Значение должно быть от 5 до 70 символов";
    }
}

/**
 * Функция для валидации поля автора цитаты при добавлении поста
 * и вывода ошибок, если валидация не прошла
 * @param $value
 * @return string|void
 */
function validateQuoteAuthor($value)
{
    $len = strlen($_POST[$value]);

    if (empty($_POST[$value])) {
        return "Это поле должно быть заполнено";
    }

    if ($len < 2 or $len > 50) {
        return "Значение должно быть от 2 до 50 символов";
    }
}

/**
 * Функция для валидации поля текста поста при добавлении поста
 * и вывода ошибок, если валидация не прошла
 * @param $value
 * @return string|void
 */
function validatePostText($value)
{
    $len = strlen($_POST[$value]);

    if (empty($_POST[$value])) {
        return "Это поле должно быть заполнено";
    }

    if ($len < 2 or $len > 250) {
        return "Значение должно быть от 2 до 250 символов";
    }
}

/**
 * Функция для валидации поля комментария
 * и вывода ошибок, если валидация не прошла
 * @param $value
 * @return string|void
 */
function validateMessage($value)
{
    $len = strlen($_POST[$value]);

    if (empty($_POST[$value])) {
        return "Это поле должно быть заполнено";
    }

    if ($len < 2 or $len > 150) {
        return "Значение должно быть от 2 до 150 символов";
    }
}

/**
 * Функция для валидации поля ссылки при добавлении поста
 * и вывода ошибок, если валидация не прошла
 * @param $value
 * @return string|void
 */
function validateUrl($value)
{
    if (empty($_POST[$value])) {
        return "Это поле должно быть заполнено";
    }

    if (filter_var($_POST[$value], FILTER_VALIDATE_URL) === false) {
        return "Была введена неправильная ссылка";
    }
}

/**
 * Функция для валидации поля ссылки видео при добавлении поста
 * и вывода ошибок, если валидация не прошла
 * @param $value
 * @return string|void
 */
function validateVideo($value)
{
    if (empty($_POST[$value])) {
        return "Это поле должно быть заполнено";
    }

    if (filter_var($_POST[$value], FILTER_VALIDATE_URL) === false) {
        return "Была введена неправильная ссылка";
    }


    set_error_handler(function () {
    });
    $url = "https://www.youtube.com/oembed?url=" . $_POST[$value];
    $fop = fopen($url, "rb");
    if (!$fop && $fop == false) {
        return "Данное видео не найдено";
    };
    restore_error_handler();
}

/**
 * Функция для валидации поля ссылки на изображение при добавлении поста
 * и вывода ошибок, если валидация не прошла
 * @param $value
 * @return string|void
 */
function validateImageUrl($value)
{
    if (filter_var($_POST[$value], FILTER_VALIDATE_URL) === false && !empty($_POST[$value])) {
        return "Была введена неправильная ссылка";
    }

    $validImageTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

    if (empty($_POST[$value]) && (empty($_FILES['userpic-file-photo']) || $_FILES['userpic-file-photo']['error'] === 4)) {
        return 'Вы должны загрузить фото, либо прикрепить ссылку из интернета';
    }

    if (!empty($_POST[$value])) {
        $tmp = explode('.', $_POST[$value]);
        $type = 'image/' . end($tmp);

        if (!in_array($type, $validImageTypes)) {
            return 'Неверный формат загружаемого файла.';
        }

        if (file_get_contents($_POST[$value]) === false) {
            return 'Не удалось найти изображение. Проверьте ссылку.';
        }
    }
}

/**
 * Функция для валидации поля загружаемого изображения при добавлении поста
 * и вывода ошибок, если валидация не прошла
 * @param $value
 * @return string|void
 */
function validateImage($value)
{
    if ($_FILES[$value] && $_FILES[$value]['error'] !== 4) {
        $fileType = $_FILES[$value]['type'];

        $validImageTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

        if (!in_array($fileType, $validImageTypes)) {
            return $fileType . 'Неверный формат загружаемого файла. Допустимый формат: ' . implode(
                    ' , ',
                    $validImageTypes
                );
        }
    }
}

/**
 * Функция для валидации поля хэштегов при добавлении поста
 * и вывода ошибок, если валидация не прошла
 * @param $value
 * @return string|void
 */
function validateHashtag($value)
{
    if (!empty($_POST[$value])) {
        $len = strlen($_POST[$value]);

        if ($len < 2 or $len > 250) {
            return "Значение должно быть от 2 до 250 символов";
        }

        $hashtags = explode(' ', $_POST[$value]);

        foreach ($hashtags as $hashtag) {
            if (substr($hashtag, 0, 1) !== '#') {
                return 'Хэштег должен начинаться со знака решетки';
            }
            if (strrpos($hashtag, '#') > 0) {
                return 'Хэш-теги разделяются пробелами';
            }
            if (strlen($hashtag) < 2) {
                return 'Хэш-тег не может состоять только из знака решетки';
            }
        }
    }
}

/**
 * Функция для валидации поля почта при регистрации пользователя
 * и вывода ошибок, если валидация не прошла
 * @param $value
 * @param $connectDb
 * @return string|void
 */
function validateEmail($value, $connectDb)
{
    if (empty($_POST[$value])) {
        return "Это поле должно быть заполнено";
    }

    $len = strlen($_POST[$value]);

    if ($len < 3 or $len > 150) {
        return "Значение должно быть от 3 до 150 символов";
    }

    if (filter_var($_POST[$value], FILTER_VALIDATE_EMAIL) === false) {
        return "Был введен неправильный Email";
    }

    if (checkEmailInDb($connectDb, $_POST[$value]) === true) {
        return "Такой Email уже существует";
    }
}

/**
 * Функция для валидации поля логин при регистрации пользователя
 * и вывода ошибок, если валидация не прошла
 * @param $value
 * @return string|void
 */
function validateLogin($value)
{
    if (empty($_POST[$value])) {
        return "Это поле должно быть заполнено";
    }

    $len = strlen($_POST[$value]);

    if ($len < 3 or $len > 50) {
        return "Значение должно быть от 3 до 50 символов";
    }
}

/**
 * Функция для валидации поля пароль при регистрации пользователя
 * и вывода ошибок, если валидация не прошла
 * @param $value
 * @return string|void
 */
function validatePassword($value)
{
    if (empty($_POST[$value])) {
        return "Это поле должно быть заполнено";
    }

    $len = strlen($_POST[$value]);

    if ($len < 8 or $len > 150) {
        return "Значение должно быть от 8 до 150 символов";
    }

    if (!preg_match('/^\S*$/', $_POST[$value])) {
        return 'Пароль не должен содержать пробелы';
    }
}

/**
 * Функция для валидации поля повторите пароль при регистрации пользователя
 * и вывода ошибок, если валидация не прошла
 * @param $pass
 * @param $repeatPass
 * @return string|void
 */
function validateRepeatPassword($pass, $repeatPass)
{
    if (empty($_POST[$repeatPass])) {
        return "Это поле должно быть заполнено";
    }

    if ($_POST[$pass] !== $_POST[$repeatPass]) {
        return "Пароли не совпадают";
    }
}

/**
 * Функция валидации поля email при авторизации.
 * @param $value
 * @param $connect
 * @return string|void
 */
function validateEnterEmail($value, $connect)
{
    if (empty($_POST[$value])) {
        return "Это поле должно быть заполнено";
    }

    if (checkEmailInDb($connect, $_POST[$value]) === true) {
        return "Данный Email не зарегистрирован";
    }
}

function validateEnterPassword($value, $connect)
{
    if (empty($_POST[$value])) {
        return "Это поле должно быть заполнено";
    }

    if (!empty($_POST[$value]) && !empty($_POST["password"]) && !checkUser($connect, $_POST)) {
        return 'Вы ввели неверный email/пароль.';
    }
}
