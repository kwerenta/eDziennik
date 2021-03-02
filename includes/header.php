<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/assets/css/global.css">
  <?php
  foreach ($styles as $style) {
    echo '<link rel="stylesheet" href="/assets/css/' . $style . '.css">';
  }
  foreach ($scripts as $script) {
    if (strpos($script, "http") !== 0) {
      echo '<script defer src="/assets/js/' . $script . '.js"></script>';
    } else {
      echo '<script defer src="' . $script . '"></script>';
    }
  }
  ?>
  <title>eDziennik</title>

</head>

<body>