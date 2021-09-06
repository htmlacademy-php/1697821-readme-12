<main class="page__main page__main--publication">
    <div class="container">
        <h1 class="page__title page__title--publication"><?= $post['title']; ?></h1>
        <section class="post-details">
            <h2 class="visually-hidden">Публикация</h2>
            <div class="post-details__wrapper post-<?= $post['type_title'] ?>>">
                <div class="post-details__main-block post post--details">
                    <!--здесь содержимое карточки-->
                    <?php switch ($post['type_title']):
                        case 'quote':
                            include("templates/detail-posts/quote-post.php");
                            break;
                        case 'text':
                            include("templates/detail-posts/text-post.php");
                            break;
                        case 'photo':
                            include("templates/detail-posts/photo-post.php");
                            break;
                        case 'link':
                            include("templates/detail-posts/link-post.php");
                            break;
                        case 'video':
                            include("templates/detail-posts/video-post.php");
                    endswitch ?>
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
                                <span><?= $post['count_post_likes']; ?></span>
                                <span class="visually-hidden">количество лайков</span>
                            </a>
                            <a class="post__indicator post__indicator--comments button" href="#"
                               title="Комментарии">
                                <svg class="post__indicator-icon" width="19" height="17">
                                    <use xlink:href="#icon-comment"></use>
                                </svg>
                                <span><?= $post['count_post_comments']; ?></span>
                                <span class="visually-hidden">количество комментариев</span>
                            </a>
                            <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                                <svg class="post__indicator-icon" width="19" height="17">
                                    <use xlink:href="#icon-repost"></use>
                                </svg>
                                <span><?= $post['count_post_reposts']; ?></span>
                                <span class="visually-hidden">количество репостов</span>
                            </a>
                        </div>
                        <span class="post__view"><?= $post['views_count']; ?> просмотров</span>
                    </div>
                    <ul class="post__tags">
                        <?php foreach ($hashtags as $hashtag): ?>
                            <li><a href="#">#<?= $hashtag['hashtag_title'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="comments">
                        <form class="comments__form form" action="#" method="post">
                            <div class="comments__my-avatar">
                                <img class="comments__picture" src="../img/userpic-medium.jpg"
                                     alt="Аватар пользователя">
                            </div>
                            <div class="form__input-section form__input-section--error">
                            <textarea class="comments__textarea form__textarea form__input"
                                      placeholder="Ваш комментарий"></textarea>
                                <label class="visually-hidden">Ваш комментарий</label>
                                <button class="form__error-button button" type="button">!</button>
                                <div class="form__error-text">
                                    <h3 class="form__error-title">Ошибка валидации</h3>
                                    <p class="form__error-desc">Это поле обязательно к заполнению</p>
                                </div>
                            </div>
                            <button class="comments__submit button button--green" type="submit">Отправить</button>
                        </form>
                        <div class="comments__list-wrapper">
                            <ul class="comments__list">
                                <?php foreach ($comments as $comment): ?>
                                    <li class="comments__item user">
                                        <div class="comments__avatar">
                                            <a class="user__avatar-link" href="#">
                                                <img class="comments__picture"
                                                     src="../img/<?= $comment['user_avatar_url'] ?>"
                                                     alt="Аватар пользователя">
                                            </a>
                                        </div>
                                        <div class="comments__info">
                                            <div class="comments__name-wrapper">
                                                <a class="comments__user-name" href="#">
                                                    <span><?= $comment['user_login'] ?></span>
                                                </a>
                                                <time class="comments__time"
                                                      datetime="2019-03-20"><?= $comment['created_at'] ?></time>
                                            </div>
                                            <p class="comments__text">
                                                <?= $comment['content'] ?>
                                            </p>
                                        </div>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                            <?php if (isShowAllComments($post) === true): ?>
                            <a class="comments__more-link" href="<?= $_SERVER['REQUEST_URI'] ?>&comments=all">
                                <span>Показать все комментарии</span>
                                <sup class="comments__amount"><?= $post['count_post_comments'] - COUNT_SHOW_COMMENTS ?></sup>
                            </a>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <div class="post-details__user user">
                    <div class="post-details__user-info user__info">
                        <div class="post-details__avatar user__avatar">
                            <a class="post-details__avatar-link user__avatar-link" href="#">
                                <img class="post-details__picture user__picture"
                                     src="./img/<?= $post['user_avatar_url']; ?>"
                                     alt="Аватар пользователя">
                            </a>
                        </div>
                        <div class="post-details__name-wrapper user__name-wrapper">
                            <a class="post-details__name user__name" href="#">
                                <span><?= $post['user_login']; ?></span>
                            </a>
                            <time class="post-details__time user__time" datetime="2014-03-20">5 лет на сайте</time>
                        </div>
                    </div>
                    <div class="post-details__rating user__rating">
                        <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
                            <span class="post-details__rating-amount user__rating-amount"><?= $post['count_user_subscribers']; ?></span>
                            <span class="post-details__rating-text user__rating-text">подписчиков</span>
                        </p>
                        <p class="post-details__rating-item user__rating-item user__rating-item--publications">
                            <span class="post-details__rating-amount user__rating-amount"><?= $post['count_user_posts']; ?></span>
                            <span class="post-details__rating-text user__rating-text">публикаций</span>
                        </p>
                    </div>
                    <div class="post-details__user-buttons user__buttons">
                        <button class="user__button user__button--subscription button button--main" type="button">
                            Подписаться
                        </button>
                        <a class="user__button user__button--writing button button--green" href="#">Сообщение</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>