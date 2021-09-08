<!--содержимое для поста-цитаты-->
<blockquote>
    <p><?= htmlValidate($post['content']) ?></p>
    <cite>
        <?= $post['author_quote'] ?? "Неизвестный Автор"; ?>
    </cite>
</blockquote>