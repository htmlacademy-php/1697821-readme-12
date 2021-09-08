-- добавление в БД типов контента для поста
INSERT INTO types
SET title        = 'text',
    icon_url     = 'icon-filter-text';
INSERT INTO types
SET title        = 'quote',
    icon_url     = 'icon-filter-quote';
INSERT INTO types
SET title        = 'photo',
    icon_url     = 'icon-filter-photo';
INSERT INTO types
SET title        = 'video',
    icon_url     = 'icon-filter-video';
INSERT INTO types
SET title        = 'link',
    icon_url     = 'icon-filter-link';

-- добавление в БД пользователей
INSERT INTO users
SET email        = 'larisa@mail.ru',
    login        = 'Лариса',
    password     = 'larisa',
    avatar_url   = 'userpic-larisa-small.jpg';
INSERT INTO users
SET email        = 'vladik@mail.ru',
    login        = 'Владик',
    password     = 'vladik',
    avatar_url   = 'userpic.jpg';
INSERT INTO users
SET email        = 'victor@mail.ru',
    login        = 'Виктор',
    password     = 'victor',
    avatar_url   = 'userpic-mark.jpg';

-- добавление в БД несколько постов
INSERT INTO posts
SET /*created_at         = '',*/
  title = 'Цитата',
  content = 'Мы в жизни любим только раз, а после ищем лишь похожих',
  views_count = 10,
  user_id = 1,
  type_id = 2;
INSERT INTO posts
SET /*created_at         = '',*/
  title = 'Игра престолов',
  content = 'Не могу дождаться начала финального сезона своего любимого сериала!',
  views_count = 17,
  user_id = 2,
  type_id = 1;
INSERT INTO posts
SET /*created_at         = '',*/
  title = 'Наконец, обработал фотки!',
  image_url = 'rock-medium.jpg',
  views_count = 78,
  user_id = 3,
  type_id = 3;
INSERT INTO posts
SET /*created_at         = '',*/
    title = 'Новый видос',
    video_url = 'https://www.youtube.com/watch?v=doq943OoSdg',
    views_count = 30,
    user_id = 3,
    type_id = 4;
INSERT INTO posts
SET /*created_at         = '',*/
    title = 'Интересный сайт для обучения',
    website_url = 'http://code.mu/',
    views_count = 150,
    user_id = 2,
    type_id = 5;
INSERT INTO posts
SET /*created_at         = '',*/
    title = 'Мысль',
    content = 'Недостаточно овладеть премудростью, нужно также уметь пользоваться ею.',
    author_quote = 'Цицерон',
    views_count = 10,
    user_id = 1,
    type_id = 2;

-- добавление в БД несколько комментариев
INSERT INTO comments
SET /*created_at         = '',*/
  content = 'очень интересно',
  user_id = 2,
  post_id = 1;
INSERT INTO comments
SET /*created_at         = '',*/
  content = 'Красивое',
  user_id = 1,
  post_id = 3;
INSERT INTO comments
SET /*created_at         = '',*/
    content = 'Непонятно',
    user_id = 2,
    post_id = 1;
INSERT INTO comments
SET /*created_at         = '',*/
    content = 'Интересно',
    user_id = 3,
    post_id = 1;
INSERT INTO comments
SET /*created_at         = '',*/
    content = 'Круто',
    user_id = 1,
    post_id = 1;
INSERT INTO comments
SET /*created_at         = '',*/
    content = 'Красивое2',
    user_id = 2,
    post_id = 1;
INSERT INTO comments
SET /*created_at         = '',*/
    content = 'Красивое4',
    user_id = 3,
    post_id = 1;

-- получение списка постов с сортировкой по популярности и вместе с именами авторов и типом контента
SELECT  posts.id                AS "post_id",
        posts.title             AS "post_title",
        users.id                AS "user_id",
        users.login             AS "post_author",
        types.id                AS "types_id",
        types.title             AS "type_content",
        posts.views_count       AS "views_count"
FROM posts
          INNER JOIN users ON posts.user_id = users.id
          INNER JOIN types ON posts.type_id = types.id
ORDER BY posts.views_count DESC;

-- получение списка постов для конкретного пользователя
SELECT  users.id                AS "user_id",
        users.login             AS "user_login",
        posts.id                AS "post_id",
        posts.title             AS "post_title"
FROM users
          LEFT JOIN posts ON users.id = posts.user_id
WHERE users.id = 1;

-- получить список комментариев для одного поста, в комментариях должен быть логин пользователя
SELECT  users.id                AS "user_id",
        users.login             AS "user_login",
        comments.content        AS "text_comment"
FROM posts
          LEFT JOIN users ON posts.user_id = users.id
          LEFT JOIN comments ON posts.id = comments.post_id
WHERE posts.id = 1;

-- добавить лайки к постам
INSERT INTO likes
SET
    user_id = 2,
    post_id = 3;
INSERT INTO likes
SET
    user_id = 1,
    post_id = 4;
INSERT INTO likes
SET
    user_id = 2,
    post_id = 4;

-- подписаться на пользователя
INSERT INTO subscriptions
SET
    subscribed_to_user_id = 2,
    subscriber_user_id = 3;

-- добавить хэштэги
INSERT INTO hashtags (title)
VALUES ('картина'),('прекрасно'),('невообразимо');

-- добавить связи хэштеги и посты
INSERT INTO post_hashtags (post_id, hashtag_id) VALUES
(1,1),(1,2),(1,3),(2,1);

