<main class="page__main page__main--profile">
    <h1 class="visually-hidden">Профиль</h1>
    <div class="profile profile--default">
        <div class="profile__user-wrapper">
            <div class="profile__user user container">
                <div class="profile__user-info user__info">
                    <div class="profile__avatar user__avatar">
                        <img class="profile__picture user__picture" src="./img/<?= $userInfo['avatar_url'] ?>"
                             alt="Аватар пользователя">
                    </div>
                    <div class="profile__name-wrapper user__name-wrapper">
                        <span class="profile__name user__name"><?= $userInfo['login'] ?></span>
                        <time class="profile__user-time user__time" datetime="<?= $userInfo['user_created_at'] ?>">
                            <?= publicationLife($userInfo['created_at']) ?>
                        </time>
                    </div>
                </div>
                <div class="profile__rating user__rating">
                    <p class="profile__rating-item user__rating-item user__rating-item--publications">
                        <span class="user__rating-amount"><?= $userInfo['count_user_posts'] ?></span>
                        <span class="profile__rating-text user__rating-text">публикаций</span>
                    </p>
                    <p class="profile__rating-item user__rating-item user__rating-item--subscribers">
                        <span class="user__rating-amount"><?= $userInfo['count_user_subscribers'] ?></span>
                        <span class="profile__rating-text user__rating-text">подписчиков</span>
                    </p>
                </div>
                <div class="profile__user-buttons user__buttons">
                    <?php if (!$isYourProfile): ?>
                        <?php if ($isSubscription): ?>
                            <a href="subscription.php?user_id=<?= $userInfo['id'] ?>&follower_id=<?= $currentUser ?>&action=remove"
                               class="profile__user-button user__button user__button--subscription button button--quartz">Отписаться</a>
                            <a class="profile__user-button user__button user__button--writing button button--green"
                               href="#">Сообщение</a>
                        <?php else: ?>
                            <a href="subscription.php?user_id=<?= $userInfo['id'] ?>&follower_id=<?= $currentUser ?>&action=add"
                               class="profile__user-button user__button user__button--subscription button button--main">Подписаться</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="profile__tabs-wrapper tabs">
            <div class="container">
                <div class="profile__tabs filters">
                    <b class="profile__tabs-caption filters__caption">Показать:</b>
                    <ul class="profile__tabs-list filters__list tabs__list">
                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link filters__button tabs__item <?= $currentTab === 'posts' ? 'filters__button--active tabs__item--active' : '' ?> button"
                               href="/profile.php?id=<?= $userInfo['id'] ?>&tab=posts">Посты</a>
                        </li>
                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link filters__button tabs__item <?= $currentTab === 'likes' ? 'filters__button--active tabs__item--active' : '' ?> button"
                               href="/profile.php?id=<?= $userInfo['id'] ?>&tab=likes">Лайки</a>
                        </li>
                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link filters__button tabs__item <?= $currentTab === 'subs' ? 'filters__button--active tabs__item--active' : '' ?> button"
                               href="/profile.php?id=<?= $userInfo['id'] ?>&tab=subs">Подписки</a>
                        </li>
                    </ul>
                </div>
                <div class="profile__tab-content">
                    <?php if ($currentTab === 'posts'): ?>
                        <section class="profile__posts tabs__content tabs__content--active">
                            <h2 class="visually-hidden">Публикации</h2>
                            <?php foreach ($userPosts as $userPost): ?>
                                <article class="profile__post post post-photo">
                                    <header class="post__header">
                                        <h2><a href="/post.php?id=<?= $userPost['id'] ?>"><?= $userPost['title'] ?></a>
                                        </h2>
                                    </header>
                                    <?php print(includeTemplate(
                                        "detail-posts/" . $userPost['type_title'] . "-post.php",
                                        ['post' => $userPost]
                                    )); ?>
                                    <footer class="post__footer">
                                        <div class="post__indicators">
                                            <div class="post__buttons">
                                                <a class="post__indicator post__indicator--likes button"
                                                   href="likes.php?post_id=<?= $userPost['id'] ?>&user_id=<?= $currentUser ?>"
                                                   title="Лайк">
                                                    <svg class="post__indicator-icon" width="20" height="17">
                                                        <use xlink:href="#icon-heart"></use>
                                                    </svg>
                                                    <svg class="post__indicator-icon post__indicator-icon--like-active"
                                                         width="20" height="17">
                                                        <use xlink:href="#icon-heart-active"></use>
                                                    </svg>
                                                    <span><?= $userPost['count_post_likes'] ?></span>
                                                    <span class="visually-hidden">количество лайков</span>
                                                </a>
                                                <a class="post__indicator post__indicator--repost button" href="#"
                                                   title="Репост">
                                                    <svg class="post__indicator-icon" width="19" height="17">
                                                        <use xlink:href="#icon-repost"></use>
                                                    </svg>
                                                    <span><?= $userPost['count_post_reposts'] ?></span>
                                                    <span class="visually-hidden">количество репостов</span>
                                                </a>
                                            </div>
                                            <time class="post__time"
                                                  datetime="<?= $userPost['created_at'] ?>"><?= publicationLife(
                                                    $userPost['created_at']
                                                ) ?></time>
                                        </div>
                                        <?php $hashtags = getPostHashtags($connect, $userPost['id']);
                                        if (!empty($hashtags)):?>
                                            <ul class="post__tags">
                                                <?php foreach ($hashtags as $hashtag): ?>
                                                    <li><a href="#">#<?= $hashtag['hashtag_title'] ?></a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </footer>
                                    <?php if ($userPost['count_post_comments']): ?>
                                        <div class="comments">
                                            <?php if (empty($showComments)): ?>
                                                <a class="comments__button button" href="/post.php?id=<?= $userPost['id']?>">Показать комментарии</a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </article>
                            <?php endforeach; ?>
                        </section>
                    <?php endif; ?>
                    <?php if ($currentTab === 'likes'): ?>
                        <section class="profile__likes tabs__content tabs__content--active">
                            <h2 class="visually-hidden">Лайки</h2>
                            <?php if (empty($userLikePosts)): ?>

                            <ul class="profile__likes-list">
                                <?php foreach ($userLikesPosts as $userLikePost): ?>
                                    <? $userData = $userDataWhoLikePost[array_search($userLikePost['who_like_id'],
                                        array_column($userDataWhoLikePost, 'id'))]; ?>
                                    <li class="post-mini post-mini--<?= $userLikePost['type_title'] ?> post user">
                                        <div class="post-mini__user-info user__info">
                                            <div class="post-mini__avatar user__avatar">
                                                <a class="user__avatar-link"
                                                   href="/profile.php?id=<?= $userData['id'] ?>">
                                                    <img class="post-mini__picture user__picture"
                                                         src="./img/<?= $userData['avatar_url'] ?>"
                                                         alt="Аватар пользователя">
                                                </a>
                                            </div>
                                            <div class="post-mini__name-wrapper user__name-wrapper">
                                                <a class="post-mini__name user__name"
                                                   href="/profile.php?id=<?= $userData['id'] ?>">
                                                    <span><?= $userData['login'] ?></span>
                                                </a>
                                                <div class="post-mini__action">
                                                    <span class="post-mini__activity user__additional">
                                                        Лайкнул(а) вашу публикацию
                                                    </span>
                                                    <time class="post-mini__time user__additional"
                                                          datetime="<?= $userInfo['created_at'] ?>">
                                                        <?= publicationLife($userInfo['created_at']) ?>
                                                    </time>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if (in_array($userLikePost['type_title'], ['text', 'link', 'quote'])): ?>
                                            <div class="post-mini__preview">
                                                <a class="post-mini__link" href="/post.php?id=<?= $userLikePost['post_id']?>" title="Перейти на публикацию">
                                                    <span class="visually-hidden">Текст</span>
                                                    <svg class="post-mini__preview-icon" width="20" height="21">
                                                        <use
                                                            xlink:href="#icon-filter-<?= $userLikePost['type_title'] ?>"></use>
                                                    </svg>
                                                </a>
                                            </div>
                                        <?php endif;
                                        if ($userLikePost['type_title'] === 'photo'): ?>
                                            <div class="post-mini__preview">
                                                <a class="post-mini__link" href="/post.php?id=<?= $userLikePost['post_id']?>" title="Перейти на публикацию">
                                                    <div class="post-mini__image-wrapper">
                                                        <img class="post-mini__image"
                                                             src="/img/<?= $userLikePost['image_url'] ?>"
                                                             width="109"
                                                             height="109" alt="Превью публикации">
                                                    </div>
                                                    <span class="visually-hidden">Фото</span>
                                                </a>
                                            </div>
                                        <?php endif;
                                        if ($userLikePost['type_title'] === 'video'): ?>
                                            <div class="post-mini__preview">
                                                <a class="post-mini__link" href="/post.php?id=<?= $userLikePost['post_id']?>" title="Перейти на публикацию">
                                                    <div class="post-mini__image-wrapper">
                                                        <img class="post-mini__image" src="<?= getYoutubeVideoMiniature(
                                                            $userLikePost['video_url']
                                                        ); ?>"
                                                             width="109" height="109" alt="Превью публикации">
                                                        <span class="post-mini__play-big">
                                                        <svg class="post-mini__play-big-icon" width="12" height="13">
                                                            <use xlink:href="#icon-video-play-big"></use>
                                                        </svg>
                                                    </span>
                                                    </div>
                                                    <span class="visually-hidden">Видео</span>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach;
                                endif; ?>
                            </ul>
                        </section>
                    <?php endif; ?>
                    <?php if ($currentTab === 'subs'): ?>
                        <section class="profile__subscriptions tabs__content tabs__content--active">
                            <h2 class="visually-hidden">Подписки</h2>
                            <ul class="profile__subscriptions-list">
                                <?php foreach ($userSubscriptions as $userSubscription): ?>
                                    <li class="post-mini post-mini--photo post user">
                                        <div class="post-mini__user-info user__info">
                                            <div class="post-mini__avatar user__avatar">
                                                <a class="user__avatar-link"
                                                   href="/profile.php?id=<?= $userSubscription['user_id'] ?>">
                                                    <img class="post-mini__picture user__picture"
                                                         src="./img/<?= $userSubscription['user_avatar_url'] ?>"
                                                         alt="Аватар пользователя">
                                                </a>
                                            </div>
                                            <div class="post-mini__name-wrapper user__name-wrapper">
                                                <a class="post-mini__name user__name"
                                                   href="/profile.php?id=<?= $userSubscription['user_id'] ?>">
                                                    <span><?= $userSubscription['user_login'] ?></span>
                                                </a>
                                                <time class="post-mini__time user__additional"
                                                      datetime="<?= $userSubscription['user_created_at'] ?>">
                                                    <?= publicationLife($userSubscription['created_at']) ?>
                                                </time>
                                            </div>
                                        </div>
                                        <div class="post-mini__rating user__rating">
                                            <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                                                <span
                                                    class="post-mini__rating-amount user__rating-amount"><?= $userSubscription['count_user_posts'] ?></span>
                                                <span class="post-mini__rating-text user__rating-text">публикаций</span>
                                            </p>
                                            <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                                                <span
                                                    class="post-mini__rating-amount user__rating-amount"><?= $userSubscription['count_user_subscribers'] ?></span>
                                                <span
                                                    class="post-mini__rating-text user__rating-text">подписчиков</span>
                                            </p>
                                        </div>
                                        <div class="post-mini__user-buttons user__buttons">
                                            <?php
                                            $yourSubscribe = $checkSubs($userSubscription['user_id']);
                                            ?>

                                            <?php if ($yourSubscribe): ?>
                                                <a
                                                    href="subscription.php?user_id=<?= $userInfo['id'] ?>&follower_id=<?= $userSubscription['user_id'] ?>&action=remove"
                                                    class="post-mini__user-button user__button user__button--subscription button button--quartz">Отписаться</a>
                                            <?php else: ?>
                                                <a
                                                    href="subscription.php?user_id=<?= $userInfo['id'] ?>&follower_id=<?= $userSubscription['user_id'] ?>&action=add"
                                                    class="post-mini__user-button user__button user__button--subscription button button--main">Подписаться</a>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </section>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>
