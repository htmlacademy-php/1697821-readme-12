<div class="adding-post__textarea-wrapper form__input-wrapper <?= isErrorCss($errors['post-link']); ?>">
    <label class="adding-post__label form__label" for="post-link">Ссылка <span
                class="form__input-required">*</span></label>
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="post-link" type="text" name="post-link"
               value="<?= getPostVal('post-link') ?>">
        <button class="form__error-button button" type="button">!<span
                    class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title"><?= FORM_ERROR ?></h3>
            <p class="form__error-desc"><?= $errors['post-link'] ?></p>
        </div>
    </div>
</div>
<div class="adding-post__input-wrapper form__input-wrapper <?= isErrorCss($errors['link-tags']); ?>">
    <label class="adding-post__label form__label" for="link-tags">Теги</label>
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="link-tags" type="text" name="link-tags"
               placeholder="Введите ссылку" value="<?= getPostVal('link-tags') ?>">
        <button class="form__error-button button" type="button">!<span
                    class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title"><?= FORM_ERROR ?></h3>
            <p class="form__error-desc"><?= $errors['link-tags'] ?></p>
        </div>
    </div>
</div>

