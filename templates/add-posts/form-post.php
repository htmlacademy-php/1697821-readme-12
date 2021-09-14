<?php

/**
 * @var array $errors --массив ошибок валидации формы
 * @var string $currentType -- текущий тип поста
 * @var string $addPostContent -- вывод html страницы полей текущего поста
 * @var array $errorTitleRus -- массив заголовков возможных ошибок
 */

?>
<section class="adding-post__<?= $currentType ?> tabs__content tabs__content--active">
    <h2 class="visually-hidden"><?= isRusNameTypes($currentType) ?></h2>
    <form class="adding-post__form form" action="/add.php?type=<?= $currentType ?>" method="post"
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
                            <h3 class="form__error-title"><?= FORM_ERROR ?></h3>
                            <p class="form__error-desc"><?= $errors['heading'] ?></p>
                        </div>
                    </div>
                </div>
                <?= $addPostContent ?>
            </div>
            <? if (!empty($errors)): ?>
                <div class="form__invalid-block">
                    <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                    <ul class="form__invalid-list">
                        <? foreach ($errors as $key => $value):
                            if (!empty($value)):?>
                                <li class="form__invalid-item"><?= $errorTitleRus[$key] ?>. <?= $value ?>.</li>
                            <?endif;
                        endforeach; ?>
                    </ul>
                </div>
            <? endif; ?>
        </div>
        <? if ($currentType === "photo"): ?>
            <div class="adding-post__input-file-container form__input-container form__input-container--file">
                <div class="adding-post__input-file-wrapper form__input-file-wrapper">
                    <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone">
                        <input class="adding-post__input-file form__input-file" id="userpic-file-photo" type="file"
                               name="userpic-file-photo" title=" ">
                        <div class="form__file-zone-text">
                            <span>Перетащите фото сюда</span>
                        </div>
                    </div>
                    <button
                        class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button"
                        type="button">
                        <span>Выбрать фото</span>
                        <svg class="adding-post__attach-icon form__attach-icon" width="10" height="20">
                            <use xlink:href="#icon-attach"></use>
                        </svg>
                    </button>
                </div>
                <div class="adding-post__file adding-post__file--photo form__file dropzone-previews">

                </div>
            </div>
        <? endif; ?>
        <div class="adding-post__buttons">
            <button class="adding-post__submit button button--main" type="submit">
                Опубликовать
            </button>
            <a class="adding-post__close" href="#">Закрыть</a>
        </div>
    </form>
</section>
