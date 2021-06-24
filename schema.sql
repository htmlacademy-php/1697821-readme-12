CREATE DATABASE IF NOT EXISTS readme;

CREATE TABLE `readme`.`users` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(50) NOT NULL,
    `login` VARCHAR(50) NOT NULL,
    `password` VARCHAR(42) NOT NULL,
    `avatar` VARCHAR(50) NOT NULL
);

CREATE TABLE `readme`.`hashtags` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `hashtag` VARCHAR(50) NOT NULL
);

CREATE TABLE `readme`.`types` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `icon` VARCHAR(50) NOT NULL
);

CREATE TABLE `readme`.`posts` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `title` VARCHAR(50) NOT NULL,
    `content` TEXT NULL,
    `author` VARCHAR(42) NULL,
    `image` VARCHAR(50)  NULL,
    `video_link` VARCHAR(50)  NULL,
    `website_link` VARCHAR(50)  NULL,
    `views` INT(11) UNSIGNED,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `type_id` INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (type_id) REFERENCES types (id)
);

CREATE TABLE `readme`.`comments` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `content` TEXT NOT NULL,
    `user_id` INT(11) UNSIGNED NULL,
    `post_id` INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (post_id) REFERENCES posts (id)
);

CREATE TABLE `readme`.`likes` (
    `user_id` INT(11) UNSIGNED NOT NULL,
    `post_id` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY (user_id, post_id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (post_id) REFERENCES posts (id)
);

CREATE TABLE `readme`.`subscriptions` (
    `author` INT(11) UNSIGNED NOT NULL,
    `subscriber` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY (author, subscriber),
    FOREIGN KEY (author) REFERENCES users (id),
    FOREIGN KEY (subscriber) REFERENCES users (id)
);

CREATE TABLE `readme`.`messages` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `create_time` DATETIME NOT NULL,
    `content` TEXT NOT NULL,
    `author` INT(11) UNSIGNED NOT NULL,
    `receiver` INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (author) REFERENCES users (id),
    FOREIGN KEY (receiver) REFERENCES users (id)
);

/*как избежать данного наименования я так и не придумал*/
CREATE TABLE `readme`.`posts_hashtags` (
    `post_id` INT(11) UNSIGNED NOT NULL,
    `hashtag_id` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY (post_id, hashtag_id),
    FOREIGN KEY (post_id) REFERENCES posts (id),
    FOREIGN KEY (hashtag_id) REFERENCES hashtags (id)
);
