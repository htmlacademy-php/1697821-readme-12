<?php
/**
 * @var array $errors --массив ошибок валидации формы
 */
?>
<div class="adding-post__textarea-wrapper form__textarea-wrapper <?= isErrorCss($errors['post-text']); ?>">
    <label class="adding-post__label form__label" for="post-text">Текст поста <span
                class="form__input-required">*</span></label>
    <div class="form__input-section">
        <textarea class="adding-post__textarea form__textarea form__input" id="post-text" name="post-text"
                  placeholder="Введите текст публикации"><?= getPostVal('post-text') ?></textarea>
        <button class="form__error-button button" type="button">!<span
                    class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title"><?= FORM_ERROR ?></h3>
            <p class="form__error-desc"><?= $errors['post-text'] ?></p>
        </div>
    </div>
</div>
