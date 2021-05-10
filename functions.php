<?
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
   return $t;
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
?>
