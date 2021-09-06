<?php
function showNotFoundPage($is_auth, $title)
{
    $pageContent = includeTemplate(
        'not-found-page.php'
    );

    $layoutContent = includeTemplate(
        'layout.php',
        [
            'mainContainer' => $pageContent,
            'is_auth' => $is_auth,
            'title' => $title
        ]
    );

    print($layoutContent);
}

function handleMissingPost($connect, $isAuth, $title)
{
    try {
        $post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        return getPost($connect, $post_id);;
    }catch (Exception $e){
        showNotFoundPage($isAuth, $title);
        exit();
    }
}
