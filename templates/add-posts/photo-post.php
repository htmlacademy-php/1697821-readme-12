<?php
/**
 * @var array $errors --массив ошибок валидации формы
 */
?>
<div class="adding-post__input-wrapper form__input-wrapper <?= isErrorCss($errors['photo-url']); ?>">
    <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="photo-url" type="text" name="photo-url"
               placeholder="Введите ссылку" value="<?= getPostVal('photo-url') ?>">
        <button class="form__error-button button" type="button">!<span
                    class="visually-hidden">Информация об ошибке</span>
        </button>
        <div class="form__error-text">
            <h3 class="form__error-title"><?= FORM_ERROR ?></h3>
            <p class="form__error-desc"><?= $errors['photo-url'] ?></p>
        </div>
    </div>
</div>
