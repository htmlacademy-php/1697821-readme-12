<!--содержимое для поста-цитаты-->
<blockquote>
    <p><?= htmlspecialchars($post['content'], ENT_QUOTES) ?></p>
    <cite>
        <?php
        if (!isset($post['author_quote'])) {
            echo "Неизвестный Автор";
        } else {
            echo $post['author_quote'];
        }
        ?>
    </cite>
</blockquote>