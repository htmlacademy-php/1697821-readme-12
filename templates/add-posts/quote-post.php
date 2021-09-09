<div class="adding-post__input-wrapper form__textarea-wrapper">
    <label class="adding-post__label form__label" for="quote-text">Текст цитаты <span
                class="form__input-required">*</span></label>
    <div class="form__input-section">
        <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" id="quote-text"
                  name="quote-text" placeholder="Текст цитаты"></textarea>
        <button class="form__error-button button" type="button">!<span
                    class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title">Заголовок сообщения</h3>
            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
        </div>
    </div>
</div>
<div class="adding-post__textarea-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="quote-author">Автор <span
                class="form__input-required">*</span></label>
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="quote-author" type="text" name="quote-author">
        <button class="form__error-button button" type="button">!<span
                    class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title">Заголовок сообщения</h3>
            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
        </div>
    </div>
</div>
<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="quote-tags">Теги</label>
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="quote-tags" type="text" name="quote-tags"
               placeholder="Введите теги">
        <button class="form__error-button button" type="button">!<span
                    class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title">Заголовок сообщения</h3>
            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
        </div>
    </div>
</div>
</div>
<? include('./templates/add-posts/invalid-block.php') ?>
</div>
