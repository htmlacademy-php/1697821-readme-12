<?php
/**
 * @var array $addPosts --массив текущего поста
 * @var array $types --массив типов постов
 * @var int $typeId --id текущего элемента
 * @var array $errors --массив ошибок
 */

?>
<main class="page__main page__main--adding-post">
    <div class="page__main-section">
        <div class="container">
            <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
            <div class="adding-post__tabs-wrapper tabs">
                <div class="adding-post__tabs filters">
                    <ul class="adding-post__tabs-list filters__list tabs__list">
                        <?php foreach ($types as $type): ?>
                            <li class="adding-post__tabs-item filters__item">
                                <a class="adding-post__tabs-link filters__button filters__button--<?= $type['title'] ?>
                                <?= (isset($type['id']) && $typeId == $type['id']) ? "filters__button--active tabs__item--active" : "" ?>
                                tabs__item button"
                                   href="/add.php?<?= "id=" . $type['id'] ?>">
                                    <span class="visually-hidden"><?= $type['title'] ?></span>
                                    <svg class="filters__icon" width="22" height="18">
                                        <use xlink:href="#<?= $type['icon_url'] ?>"></use>
                                    </svg>
                                    <span><?= $type['title'] ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php foreach ($addPosts

                as $addPost): ?>
                <div class="adding-post__tab-content">
                    <section class="adding-post__<?= $addPost['title'] ?> tabs__content tabs__content--active">
                        <h2 class="visually-hidden">Форма добавления <?= isRusNameTypes($addPost['title']) ?></h2>
                        <form class="adding-post__form form" action="/add.php?id=<?= $addPost['id'] ?>" method="post"
                              enctype="multipart/form-data">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper
                                    <?= isErrorCss($errors['heading']); ?>">
                                        <label class="adding-post__label form__label" for="heading">Заголовок <span
                                                    class="form__input-required">*</span></label>
                                        <div class="form__input-section">
                                            <input class="adding-post__input form__input" id="heading" type="text"
                                                   name="heading" placeholder="Введите заголовок"
                                                   value="<?= getPostVal('heading') ?>">
                                            <button class="form__error-button button" type="button">!<span
                                                        class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $errors['heading'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php switch ($addPost['title']):
                                        case 'quote':
                                            print(includeTemplate(
                                                "add-posts/quote-post.php",
                                                ['addPost' => $addPost, 'errors' => $errors]
                                            ));
                                            break;
                                        case 'text':
                                            print(includeTemplate(
                                                "add-posts/text-post.php",
                                                ['addPost' => $addPost, 'errors' => $errors]
                                            ));
                                            break;
                                        case 'photo':
                                            print(includeTemplate(
                                                "add-posts/photo-post.php",
                                                ['addPost' => $addPost, 'errors' => $errors]
                                            ));
                                            break;
                                        case 'link':
                                            print(includeTemplate(
                                                "add-posts/link-post.php",
                                                ['addPost' => $addPost, 'errors' => $errors]
                                            ));
                                            break;
                                        case 'video':
                                            print(includeTemplate(
                                                "add-posts/video-post.php",
                                                ['addPost' => $addPost, 'errors' => $errors]
                                            ));
                                    endswitch;
                                    endforeach; ?>
                                    <div class="adding-post__buttons">
                                        <button class="adding-post__submit button button--main" type="submit">
                                            Опубликовать
                                        </button>
                                        <a class="adding-post__close" href="#">Закрыть</a>
                                    </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
</main>