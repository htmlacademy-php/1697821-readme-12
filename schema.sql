CREATE DATABASE IF NOT EXISTS readme;

CREATE TABLE `readme`.`user` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(50) NOT NULL,
    `login` VARCHAR(50) NOT NULL,
    `password` VARCHAR(42) NOT NULL,
    `avatar` VARCHAR(50) NOT NULL
);

CREATE TABLE `readme`.`hashtag` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `hashtag` VARCHAR(50) NOT NULL
);

CREATE TABLE `readme`.`type` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `icon` VARCHAR(50) NOT NULL
);

CREATE TABLE `readme`.`post` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `title` VARCHAR(50) NOT NULL,
    `content` TEXT NULL,
    `author` VARCHAR(42) NULL,
    `image` VARCHAR(50)  NULL,
    `video_link` VARCHAR(50)  NULL,
    `website_link` VARCHAR(50)  NULL,
    `views` INT(11),
    `user_id` INT(11) UNSIGNED NOT NULL,
    `type_id` INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user (id),
    FOREIGN KEY (type_id) REFERENCES type (id)
);

CREATE TABLE `readme`.`comment` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `content` TEXT NOT NULL,
    `user_id` INT(11) UNSIGNED NULL,
    `post_id` INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user (id),
    FOREIGN KEY (post_id) REFERENCES post (id)
);

CREATE TABLE `readme`.`like` (
    `user_id` INT(11) UNSIGNED NOT NULL,
    `post_id` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY (user_id, post_id),
    FOREIGN KEY (user_id) REFERENCES user (id),
    FOREIGN KEY (post_id) REFERENCES post (id)
);

CREATE TABLE `readme`.`subscription` (
    `author` INT(11) UNSIGNED NOT NULL,
    `subscriber` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY (author, subscriber),
    FOREIGN KEY (author) REFERENCES user (id),
    FOREIGN KEY (subscriber) REFERENCES user (id)
);

CREATE TABLE `readme`.`message` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `create_time` DATETIME NOT NULL,
    `content` TEXT NOT NULL,
    `author` INT(11) UNSIGNED NOT NULL,
    `receiver` INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (author) REFERENCES user (id),
    FOREIGN KEY (receiver) REFERENCES user (id)
);

CREATE TABLE `readme`.`post_hashtag` (
    `post_id` INT(11) UNSIGNED NOT NULL,
    `hashtag_id` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY (post_id, hashtag_id),
    FOREIGN KEY (post_id) REFERENCES post (id),
    FOREIGN KEY (hashtag_id) REFERENCES hashtag (id)
);
