CREATE DATABASE IF NOT EXISTS readme;

CREATE TABLE `readme`.`users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL,
    `login` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `avatar_url` VARCHAR(2048) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `readme`.`hashtags` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `readme`.`types` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `icon_url` VARCHAR(2048) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `readme`.`posts` (
                                  `id`               INT UNSIGNED                           NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                  `created_at`       DATETIME     DEFAULT CURRENT_TIMESTAMP NOT NULL,
                                  `updated_at`       DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                  `title`            VARCHAR(255)                           NOT NULL,
                                  `content`          TEXT                                   NULL,
                                  `author_quote`     VARCHAR(255)                           NULL, -- автор цитаты (author_quote)?
                                  `image_url`        VARCHAR(2048)                          NULL,
                                  `video_url`        VARCHAR(2048)                          NULL,
                                  `website_url`      VARCHAR(2048)                          NULL,
                                  `views_count`      INT UNSIGNED DEFAULT 0,                      -- число просмотров
                                  `repost_flag`      BOOL         DEFAULT FALSE,                  -- 3.4. Репост флаг репоста
                                  `original_post_id` INT UNSIGNED,                                -- и ID оригинального поста
                                  `user_id`          INT UNSIGNED                           NOT NULL,
                                  `type_id`          INT UNSIGNED                           NOT NULL,
                                  FOREIGN KEY (user_id) REFERENCES users (id),
                                  FOREIGN KEY (type_id) REFERENCES types (id)
);

CREATE TABLE `readme`.`comments` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `content` TEXT NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `post_id` INT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (post_id) REFERENCES posts (id)
);

CREATE TABLE `readme`.`likes` (
    `user_id` INT UNSIGNED NOT NULL,
    `post_id` INT UNSIGNED NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (user_id, post_id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (post_id) REFERENCES posts (id)
);

CREATE TABLE `readme`.`subscriptions` (
    `subscribed_to_user_id` INT UNSIGNED NOT NULL,
    `subscriber_user_id` INT UNSIGNED NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (subscribed_to_user_id, subscriber_user_id),
    FOREIGN KEY (subscribed_to_user_id) REFERENCES users (id),
    FOREIGN KEY (subscriber_user_id) REFERENCES users (id)
);

CREATE TABLE `readme`.`messages` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `content` TEXT NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `receiver_user_id` INT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (receiver_user_id) REFERENCES users (id)
);

CREATE TABLE `readme`.`post_hashtags` (
    `post_id` INT UNSIGNED NOT NULL,
    `hashtag_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (post_id, hashtag_id),
    FOREIGN KEY (post_id) REFERENCES posts (id),
    FOREIGN KEY (hashtag_id) REFERENCES hashtags (id)
);
