INSERT INTO users (email, login, password, avatar_url)
VALUES ('maxim@mail.ru', 'Максим', '$2y$10$ihaBGypJUq7cuCURl74OPOyYbxPBEM8FAZ1CnfftQVDGBMHMqbdmG', ''),
       ('natasha@mail.ru', 'Наташа', '$2y$10$c4humWN6Fp5v2R6WT4o8p.oWKYG2AxpZFKKPcI4xyfvNXqwHircKO', ''),
       ('marina@mail.ru', 'Марина', '$2y$10$ge1rY5fj1t6raaP75t4ngu051aSDWtrqjNmbeld8Ki2uHYI3AVTH6', ''),
       ('andrey@mail.ru', 'Андрей', '$2y$10$3SuGFuymuC5CMmIsXDBJkO2I8mD50OJBvWBiOiDNc59IrSkDZnExS', '');

INSERT INTO posts (title, content, author_quote, image_url, video_url, website_url, user_id, type_id)
VALUES ('Занятное видео', '', '', '', 'https://www.youtube.com/watch?v=_HbEl-2n5AQ', '', '4', '4'),
       ('Бум видео', '', '', '', 'https://www.youtube.com/watch?v=sABaxhk6hXo', '', '3', '4'),
       ('Интересная игра', '', '', '', '', 'https://ru.pathofexile.com/', '2', '5'),
       ('Сайт', '', '', '', '', 'https://www.php.net/', '6', '5'),
       ('Мой любимый актер', 'Если тебе где-то не рады в рваных носках, то и в целых туда идти не стоит',
        'Джейсон Стетхем', '', '', '', '2', '2'),
       ('Цитата великого человека', 'Будь собой, прочие роли уже заняты', 'Оскар Уайльд', '', '', '', '1', '2'),
       ('Фоточка', '', '', 'coast-medium.jpg', '', '', '2', '3'),
       ('Барбершоп', '', '', 'barbershop.png', '', '', '6', '3');

INSERT INTO likes (user_id, post_id)
VALUES (6, 4),
       (6, 5),
       (3, 4),
       (3, 7),
       (2, 6),
       (2, 8),
       (6, 2);

INSERT INTO subscriptions (subscribed_to_user_id, subscriber_user_id)
VALUES (6, 4),
       (6, 5),
       (3, 4),
       (3, 7),
       (2, 6),
       (2, 4),
       (6, 2);

INSERT INTO hashtags (title)
VALUES ('ух'),
       ('perfecto'),
       ('nice');

INSERT INTO post_hashtags (post_id, hashtag_id)
VALUES (4, 4),
       (6, 5),
       (7, 3);