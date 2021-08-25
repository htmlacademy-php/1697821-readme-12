-- Используем базу данных
USE readme;

-- добавление в БД типов контента для поста
INSERT INTO types
SET name        = 'text',
    icon        = 'icon-filter-text';
INSERT INTO types
SET name        = 'quote',
    icon        = 'icon-filter-quote';
INSERT INTO types
SET name        = 'photo',
    icon        = 'icon-filter-photo';
INSERT INTO types
SET name        = 'video',
    icon        = 'icon-filter-video';
INSERT INTO types
SET name        = 'link',
    icon        = 'icon-filter-link';

-- добавление в БД пользователей
INSERT INTO users
SET email        = 'larisa@mail.ru',
    login        = 'Лариса',
    password     = 'larisa',
    avatar       = 'userpic-larisa-small.jpg';
INSERT INTO users
SET email        = 'vladik@mail.ru',
    login        = 'Владик',
    password     = 'vladik',
    avatar       = 'userpic.jpg';
INSERT INTO users
SET email        = 'victor@mail.ru',
    login        = 'Виктор',
    password     = 'victor',
    avatar       = 'userpic-mark.jpg';

-- добавление в БД несколько постов
INSERT INTO posts
SET /*created_at         = '',*/
  title = 'Цитата',
  content = 'Мы в жизни любим только раз, а после ищем лишь похожих',
  author = '',
  image = '',
  video_link = '',
  website_link = '',
  views = '10',
  user_id = '1',
  type_id = '2';
INSERT INTO posts
SET /*created_at         = '',*/
  title = 'Игра престолов',
  content = 'Не могу дождаться начала финального сезона своего любимого сериала!',
  author = '',
  image = '',
  video_link = '',
  website_link = '',
  views = '17',
  user_id = '2',
  type_id = '1';
INSERT INTO posts
SET /*created_at         = '',*/
  title = 'Наконец, обработал фотки!',
  content = '',
  author = '',
  image = 'rock-medium.jpg',
  video_link = '',
  website_link = '',
  views = '78',
  user_id = '3',
  type_id = '3';

-- добавление в БД несколько комментариев
INSERT INTO comments
SET /*created_at         = '',*/
  content = 'очень интересно',
  user_id = '2',
  post_id = '1';
INSERT INTO comments
SET /*created_at         = '',*/
  content = 'Красивое',
  user_id = '1',
  post_id = '3';

-- получение списка постов с сортировкой по популярности и вместе с именами авторов и типом контента
SELECT  posts.id                AS "post_id",
        posts.title             AS "post_title",
        users.login             AS "post_author",
        types.name              AS "tipe_content",
        posts.views             AS "views"
FROM posts
          INNER JOIN users ON posts.user_id = users.id
          INNER JOIN types ON posts.type_id = types.id
ORDER BY posts.views DESC;

-- получение списка постов для конкретного пользователя
SELECT  users.login             AS "user_login",
        posts.id                AS "post_id",
        posts.title             AS "post_title"
FROM users
          LEFT JOIN posts ON users.id = posts.user_id
WHERE users.login = 'user1';

-- получить список комментариев для одного поста, в комментариях должен быть логин пользователя
SELECT  users.login              AS "user_login",
        comments.content         AS "comment"
FROM posts
          LEFT JOIN users ON posts.user_id = users.id
          LEFT JOIN comments ON posts.id = comments.post_id
WHERE posts.id = '1';

-- добавить лайк к посту
INSERT INTO likes VALUES ('2', '3');

-- подписаться на пользователя
INSERT INTO subscriptions VALUES ('1', '2');
