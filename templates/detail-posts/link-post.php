<!--содержимое для поста-ссылки-->
<div class="post__main">
    <div class="post-link__wrapper">
        <a class="post-link__external" href="<?= htmlspecialchars($post['website_url'], ENT_QUOTES) ?>"
           title="Перейти по ссылке">
            <div class="post-link__info-wrapper">
                <div class="post-link__icon-wrapper">
                    <img src="https://www.google.com/s2/favicons?domain=<?= htmlspecialchars(
                        $post['website_url'],
                        ENT_QUOTES
                    ) ?>" alt="Иконка сайта">
                </div>
                <div class="post-link__info">
                    <h3><?= get_link_url_title(htmlspecialchars($post['website_url'], ENT_QUOTES)) ?></h3>
                </div>
            </div>
        </a>
    </div>
</div>
