<!--содержимое для поста-ссылки-->
<div class="post__main">
    <div class="post-link__wrapper">
        <a class="post-link__external" href="<?= $post['website_url'] ?>"
           title="Перейти по ссылке">
            <div class="post-link__info-wrapper">
                <div class="post-link__icon-wrapper">
                    <img src="https://www.google.com/s2/favicons?domain=<?= $post['website_url'] ?>" alt="Иконка сайта">
                </div>
                <div class="post-link__info">
                    <h3><?= getLinkUrlTitle($post['website_url']) ?></h3>
                </div>
            </div>
        </a>
    </div>
</div>
