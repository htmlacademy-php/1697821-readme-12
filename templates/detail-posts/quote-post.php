<!--содержимое для поста-цитаты-->
<div class="post-details__image-wrapper post-quote">
    <div class="post__main">
        <blockquote>
            <p>
                <?= htmlValidate($post['content']) ?>
            </p>
            <cite>
                <?= $post['author_quote'] ?? "Неизвестный Автор"; ?>
            </cite>
        </blockquote>
    </div>
</div>