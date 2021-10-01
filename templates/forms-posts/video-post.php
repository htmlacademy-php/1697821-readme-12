<!--содержимое для поста-видео-->
<div class="post-video__block">
    <div class="post-video__preview">
        <?= embedYoutubeCover($post['video_url']); ?>
    </div>
    <a href="/post.php?id=<?= $post['id'] ?>" class="post-video__play-big button">
        <svg class="post-video__play-big-icon" width="14" height="14">
            <use xlink:href="#icon-video-play-big"></use>
        </svg>
        <span class="visually-hidden">Запустить проигрыватель</span>
    </a>
</div>