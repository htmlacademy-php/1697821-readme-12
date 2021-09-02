<!--содержимое для поста-цитаты-->
<blockquote>
    <p><?= htmlspecialchars($post['content'], ENT_QUOTES) ?></p>
    <cite>
        <?= !$post['author_quote'] ? "Неизвестный Автор" : $post['author_quote']; ?>
    </cite>
</blockquote>