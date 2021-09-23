<?php
/**
 * @var array $errors --массив ошибок валидации формы
 */
?>
<div class="adding-post__input-wrapper form__input-wrapper <?= isErrorCss($errors['video-url']); ?>">
    <label class="adding-post__label form__label" for="video-url">
        Ссылка youtube
        <span class="form__input-required">*</span>
    </label>
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="video-url" type="text" name="video-url"
               placeholder="Введите ссылку" value="<?= getPostVal('video-url') ?>">
        <button class="form__error-button button" type="button">!<span
                    class="visually-hidden">Информация об ошибке</span>
        </button>
        <div class="form__error-text">
            <h3 class="form__error-title"><?= FORM_ERROR ?></h3>
            <p class="form__error-desc"><?= $errors['video-url'] ?></p>
        </div>
    </div>
</div>
