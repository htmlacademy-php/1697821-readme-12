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
  '<script>Виктор</script>',
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
function cropText ($t, $count) {
  $i = 0;
  $line = "";
  if (strlen ($t) > $count) {
    $pieces = explode (" ", $t);
    foreach ($pieces as $piece) {
      $long = strlen ($piece);
      $i = $i + $long+'1';
      if ($i < $count) {
        $line .= "$piece ";
      }
      else {
        return htmlspecialchars($line) . "..." . "<a class='post-text__more-link' href='#'>Читать далее</a>";
        break;
      }
    }
  }
  else {
   return htmlspecialchars($t);
  }
}

function include_template($name, array $data = [])
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}
$pageContent = include_template('main.php',['posts' => $posts]);
$layoutContent = include_template('layout.php',['mainContainer'=>$pageContent, 'is_auth'=>$is_auth, 'title'=>$title]);
print($layoutContent);
 ?>
