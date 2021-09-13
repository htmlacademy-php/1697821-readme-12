<?php
/**
 * @var array $addPosts --массив текущего поста
 * @var array $types --массив типов постов
 * @var int $typeId --id текущего элемента
 * @var array $errors --массив ошибок
 */

?>
<main class="page__main page__main--adding-post">
    <div class="page__main-section">
        <div class="container">
            <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
            <div class="adding-post__tabs-wrapper tabs">
                <div class="adding-post__tabs filters">
                    <ul class="adding-post__tabs-list filters__list tabs__list">
                        <?php foreach ($types as $type): ?>
                            <li class="adding-post__tabs-item filters__item">
                                <a class="adding-post__tabs-link filters__button filters__button--<?= $type['title'] ?>
                                <?= (isset($type['title']) && $currentType === $type['title']) ? "filters__button--active tabs__item--active" : "" ?>
                                tabs__item button"
                                   href="/add.php?<?= "type=" . $type['title'] ?>">
                                    <span class="visually-hidden"><?= $type['title'] ?></span>
                                    <svg class="filters__icon" width="22" height="18">
                                        <use xlink:href="#<?= $type['icon_url'] ?>"></use>
                                    </svg>
                                    <span><?= $type['title'] ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="adding-post__tab-content">
                    <?= $addFormPost; ?>
                </div>
            </div>
        </div>
</main>
