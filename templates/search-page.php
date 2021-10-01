<main class="page__main page__main--search-results">
    <h1 class="visually-hidden">Страница результатов поиска</h1>
    <section class="search">
        <h2 class="visually-hidden">Результаты поиска</h2>
        <div class="search__query-wrapper">
            <div class="search__query container">
                <span>Вы искали:</span>
                <span class="search__query-text"><?= $searchQueryText ?></span>
            </div>
        </div>
        <div class="search__results-wrapper">
            <?php if (empty($foundPosts)): ?>
                <div class="search__no-results container">
                    <p class="search__no-results-info">К сожалению, ничего не найдено.</p>
                    <p class="search__no-results-desc">
                        Попробуйте изменить поисковый запрос или просто зайти в раздел &laquo;Популярное&raquo;, там
                        живет самый крутой контент.
                    </p>
                    <div class="search__links">
                        <a class="search__popular-link button button--main" href="popular.php">Популярное</a>
                        <a class="search__back-link" href="#" onclick="history.go(-1); return false;">Вернуться
                            назад</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="container">
                    <div class="search__content">
                        <?php foreach ($foundPosts as $foundPost): ?>
                            <article class="search__post post post-photo">
                                <header class="post__header post__author">
                                    <a class="post__author-link" href="#" title="Автор">
                                        <div class="post__avatar-wrapper">
                                            <img class="post__author-avatar"
                                                 src="./img/<?= $foundPost["user_avatar_url"] ?>"
                                                 alt="Аватар пользователя" width="60" height="60">
                                        </div>
                                        <div class="post__info">
                                            <b class="post__author-name"><?= $foundPost["user_login"] ?></b>
                                            <span class="post__time">15 минут назад</span>
                                        </div>
                                    </a>
                                </header>
                                <div class="post__main">
                                    <h2><a href="/post.php?id=<?= $foundPost["id"] ?>"><?= $foundPost["title"] ?></a>
                                    </h2>
                                    <?php print(includeTemplate(
                                        "detail-posts/" . $foundPost['type_title'] . "-post.php",
                                        ['post' => $foundPost]
                                    )); ?>
                                </div>
                                <footer class="post__footer post__indicators">
                                    <div class="post__buttons">
                                        <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                            <svg class="post__indicator-icon" width="20" height="17">
                                                <use xlink:href="#icon-heart"></use>
                                            </svg>
                                            <svg class="post__indicator-icon post__indicator-icon--like-active"
                                                 width="20" height="17">
                                                <use xlink:href="#icon-heart-active"></use>
                                            </svg>
                                            <span><?= $foundPost["count_post_likes"] ?></span>
                                            <span class="visually-hidden">количество лайков</span>
                                        </a>
                                        <a class="post__indicator post__indicator--comments button" href="#"
                                           title="Комментарии">
                                            <svg class="post__indicator-icon" width="19" height="17">
                                                <use xlink:href="#icon-comment"></use>
                                            </svg>
                                            <span><?= $foundPost["count_post_comments"] ?></span>
                                            <span class="visually-hidden">количество комментариев</span>
                                        </a>
                                    </div>
                                </footer>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>