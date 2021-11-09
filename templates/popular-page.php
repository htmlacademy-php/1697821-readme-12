<?php
/**
 * @var array $posts --массив постов
 * @var array $pageParams -- массив параметров страницы
 * @var array $types --массив типов постов
 * @var $counter --счетчик
 */

?>
<section class="page__main page__main--popular">
    <div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__sorting sorting">
                <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
                <ul class="popular__sorting-list sorting__list">
                    <li class="sorting__item sorting__item--popular">
                        <a class="sorting__link<?= popularAddClass($pageParams, 'popular'); ?>"
                           href="/popular.php?<?= getModPageQuery($pageParams, ["sort_type" => "popular"], true); ?>">
                            <span>Популярность</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link<?= popularAddClass($pageParams, 'like'); ?>"
                           href="/popular.php?<?= getModPageQuery($pageParams, ["sort_type" => "like"], true); ?>">
                            <span>Лайки</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link<?= popularAddClass($pageParams, 'date'); ?>"
                           href="/popular.php?<?= getModPageQuery($pageParams, ["sort_type" => "date"], true); ?>">
                            <span>Дата</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                        <a class="filters__button filters__button--ellipse filters__button--all
                        <?= $pageParams["type_id"] == 0 ? "filters__button--active" : "" ?>"
                           href="/popular.php">
                            <span>Все</span>
                        </a>
                    </li>
                    <?php foreach ($types as $type): ?>
                        <li class="popular__filters-item filters__item">
                            <a class="filters__button filters__button--<?= $type['title'] ?> button
                            <?= (isset($type['id']) && $pageParams["type_id"] == $type['id']) ? "filters__button--active" : "" ?>"
                               href="/popular.php?<?= getModPageQuery(
                                   $pageParams,
                                   [
                                       "type_id" => $type["id"],
                                       "sort_type" => "popular"
                                   ]
                               ); ?>">
                                <span class="visually-hidden"><?= $type['title'] ?></span>
                                <svg class="filters__icon" width="22" height="18">
                                    <use xlink:href="#<?= $type['icon_url'] ?>"></use>
                                </svg>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="popular__posts">
            <?php foreach ($posts as $post): ?>
                <article class="popular__post post post-<?= $post['type_title'] ?>">
                    <header class="post__header">
                        <h2>
                            <a href="/post.php?id=<?= $post['id'] ?>">
                                <?= htmlValidate($post['title']) ?>
                            </a>
                        </h2>
                    </header>
                    <div class="post__main">
                        <!--здесь содержимое карточки-->
                        <?= includeTemplate("forms-posts/" . $post['type_title'] . "-post.php", ['post' => $post]); ?>
                    </div>
                    <footer class="post__footer">
                        <div class="post__author">
                            <a class="post__author-link" href="/profile.php?id=<?= $post['user_id'] ?>" title="Автор">
                                <div class="post__avatar-wrapper">
                                    <!--укажите путь к файлу аватара-->
                                    <img class="post__author-avatar"
                                         src="img/<?= htmlValidate($post['user_avatar_url']) ?>"
                                         alt="Аватар пользователя">
                                </div>
                                <div class="post__info">
                                    <b class="post__author-name"><!--здесь имя пользователя--><?= strip_tags(
                                            $post['user_login']
                                        ) ?></b>
                                    <time class="post__time" <?= htmlTime($post['created_at']) ?>>
                                        <?= publicationLife($post['created_at']) ?>
                                    </time>
                                </div>
                            </a>
                        </div>
                        <div class="post__indicators">
                            <div class="post__buttons">
                                <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                    <svg class="post__indicator-icon" width="20" height="17">
                                        <use xlink:href="#icon-heart"></use>
                                    </svg>
                                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20"
                                         height="17">
                                        <use xlink:href="#icon-heart-active"></use>
                                    </svg>
                                    <span><?= $post['count_post_likes'] ?></span>
                                    <span class="visually-hidden">количество лайков</span>
                                </a>
                                <a class="post__indicator post__indicator--comments button"
                                   href="/post.php?id=<?= $post['id'] ?>"
                                   title="Комментарии">
                                    <svg class="post__indicator-icon" width="19" height="17">
                                        <use xlink:href="#icon-comment"></use>
                                    </svg>
                                    <span><?= $post['count_post_comments'] ?></span>
                                    <span class="visually-hidden">количество комментариев</span>
                                </a>
                            </div>
                        </div>
                    </footer>
                </article>
            <?php endforeach ?>
        </div>
        <div class="popular__page-links">
            <? if ($pageParams['page'] - 1 <= 0): ?>
                <span class="popular__page-link popular__page-link--prev button--gray">Предыдущая страница</span>
            <? else: ?>
                <a class="popular__page-link popular__page-link--prev button button--gray"
                   href="/popular.php?<?= getModPageQuery($pageParams, ["page" => $pageParams['page'] - 1],false,true); ?>">
                    Предыдущая страница</a>
            <? endif; ?>
            <? if ($pageParams['page'] + 1 > ($countPosts / QUANTITY_POPULAR_POSTS)): ?>
                <span class="popular__page-link popular__page-link--prev button--gray">Следующая страница</span>
            <? else: ?>
                <a class="popular__page-link popular__page-link--next button button--gray"
                   href="/popular.php?<?= getModPageQuery($pageParams, ["page" => $pageParams['page'] + 1],false,true); ?>">
                    Следующая страница</a>
            <? endif; ?>
        </div>
    </div>
</section>
