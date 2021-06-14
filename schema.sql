CREATE DATABASE IF NOT EXISTS readme;

CREATE TABLE `readme`.`user` (
    `user_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(50) NOT NULL,
    `login` VARCHAR(50) NOT NULL,
    `password` VARCHAR(42) NOT NULL,
    `avatar` VARCHAR(50) NOT NULL
) ;

CREATE TABLE `readme`.`hashtag` (
    `hashtag_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `hashtag` VARCHAR(50) NOT NULL
) ;

CREATE TABLE `readme`.`type` (
    `type_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `icon` VARCHAR(50) NOT NULL
) ;

CREATE TABLE `readme`.`post` (
    `post_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `create_time` DATETIME NOT NULL,
    `title` VARCHAR(50) NOT NULL,
    `content` TEXT NULL,
    `author` VARCHAR(42) NULL,
    `image` VARCHAR(50)  NULL,
    `video_link` VARCHAR(50)  NULL,
    `website_link` VARCHAR(50)  NULL,
    `views` INT(11),
    `user_id` INT(11) NOT NULL,
    `type_id` INT(11) NOT NULL,
    `hashtag_id` INT(11) NULL,
    FOREIGN KEY (user_id) REFERENCES user (user_id),
    FOREIGN KEY (type_id) REFERENCES type (type_id),
    FOREIGN KEY (hashtag_id) REFERENCES hashtag (hashtag_id)
) ;

CREATE TABLE `readme`.`comment` (
    `comment_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `create_time` DATETIME NOT NULL,
    `content` TEXT NOT NULL,
    `user_id` INT(11) NOT NULL,
    `post_id` INT(11) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user (user_id),
    FOREIGN KEY (post_id) REFERENCES post (post_id)
) ;

CREATE TABLE `readme`.`like` (
    `user_id` INT(11) NOT NULL,
    `post_id` INT(11) NOT NULL,
    PRIMARY KEY (user_id, post_id),
    FOREIGN KEY (user_id) REFERENCES user (user_id),
    FOREIGN KEY (post_id) REFERENCES post (post_id)
) ;

CREATE TABLE `readme`.`subscribe` (
    `author` INT(11) NOT NULL,
    `subscriber` INT(11) NOT NULL,
    PRIMARY KEY (author, subscriber),
    FOREIGN KEY (author) REFERENCES user (user_id),
    FOREIGN KEY (subscriber) REFERENCES user (user_id)
) ;

CREATE TABLE `readme`.`message` (
    `message_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `create_time` DATETIME NOT NULL,
    `content` TEXT NOT NULL,
    `user_get` INT(11) NOT NULL,
    `user_give` INT(11) NOT NULL,
    FOREIGN KEY (user_get) REFERENCES user (user_id),
    FOREIGN KEY (user_give) REFERENCES user (user_id)
) ;
