<?php
$is_auth = rand(0, 1);
$user_name = 'Игорь'; // укажите здесь ваше имя
?>
<?php
$title = 'Project site';
$posts = [
  ['Цитата',
  'post-quote',
  'Мы в жизни любим только раз, а после ищем лишь похожих',
  'Лариса',
  'userpic-larisa-small.jpg'],
  ['Игра престолов',
  'post-text',
  'Не могу дождаться начала финального сезона своего любимого сериала!',
  'Владик',
  'userpic.jpg'],
  ['Наконец, обработал фотки!',
  'post-photo',
  'rock-medium.jpg',
  'Виктор',
  'userpic-mark.jpg'],
  ['Моя мечта',
  'post-photo',
  'coast-medium.jpg',
  'Лариса',
  'userpic-larisa-small.jpg'],
  ['Лучшие курсы',
  'post-link',
  'www.htmlacademy.ru',
  'Владик',
  'userpic.jpg']
];

require ('functions.php');

$pageContent = include_template(
  'main.php',
  Array(
    'posts' => $posts
  )
);
$layoutContent = include_template(
  'layout.php',
  Array(
    'mainContainer' => $pageContent,
    'is_auth' => $is_auth,
    'title' => $title
  )
);
print ($layoutContent);
?>
