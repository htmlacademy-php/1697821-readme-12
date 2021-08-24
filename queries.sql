-- Используем базу данных
USE readme;

-- добавление в БД типов контента для поста
INSERT INTO types
SET name        = 'Текст',
    icon        = 'text';
INSERT INTO types
SET name        = 'Цитата',
    icon        = 'quote';
INSERT INTO types
SET name        = 'Картинка',
    icon        = 'photo';
INSERT INTO types
SET name        = 'Видео',
    icon        = 'video';
INSERT INTO types
SET name        = 'Ссылка',
    icon        = 'link';

-- добавление в БД типов контента для поста
INSERT INTO users
SET email        = 'user1@mail.ru',
    login        = 'user1',
    password     = 'user1',
    avatar       = '';
INSERT INTO users
SET email        = 'user2@mail.ru',
    login        = 'user2',
    password     = 'user2',
    avatar       = '';
INSERT INTO users
SET email        = 'user3@mail.ru',
    login        = 'user3',
    password     = 'user3',
    avatar       = '';

-- добавление в БД несколько постов
INSERT INTO posts
SET /*created_at         = '',*/
  title = 'заголовок',
  content = 'интересный текст',
  author = '',
  image = '',
  video_link = '',
  website_link = '',
  views = '10',
  user_id = '1',
  type_id = '2';
INSERT INTO posts
SET /*created_at         = '',*/
  title = 'заголовок2',
  content = 'интересный текст2',
  author = '',
  image = '',
  video_link = '',
  website_link = '',
  views = '17',
  user_id = '2',
  type_id = '4';
INSERT INTO posts
SET /*created_at         = '',*/
  title = 'заголовок3',
  content = 'интересный текст3',
  author = '',
  image = '',
  video_link = '',
  website_link = '',
  views = '78',
  user_id = '3',
  type_id = '1';

-- добавление в БД несколько комментариев
INSERT INTO comments
SET /*created_at         = '',*/
  content = 'очень интересно',
  user_id = '2',
  post_id = '1';
INSERT INTO comments
SET /*created_at         = '',*/
  content = 'очень интересно2',
  user_id = '1',
  post_id = '2';

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
