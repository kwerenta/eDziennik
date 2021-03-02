<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
  foreach ($styles as $style) {
    echo '<link rel="stylesheet" href="/assets/css/' . $style . '.css">';
  }
  ?>
  <title>eDziennik</title>

</head>

<body>