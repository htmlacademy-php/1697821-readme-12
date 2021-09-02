<!--содержимое для поста-цитаты-->
<div class="post-details__image-wrapper post-quote">
    <div class="post__main">
        <blockquote>
            <p>
                <?= htmlspecialchars($post['content'], ENT_QUOTES) ?>
            </p>
            <cite>
                <?= !$post['author_quote'] ? "Неизвестный Автор" : $post['author_quote']; ?>
            </cite>
        </blockquote>
    </div>
</div>