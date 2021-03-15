<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Kamil Wenta">
  <meta name="description" content="Prosty eDziennik do zastosowań lokalnych">
  <link rel="stylesheet" href="/assets/css/main.css">

  <?php

  if (isset($_SESSION['user']['rank'])) {
    echo "<link rel='stylesheet' href='/assets/css/{$_SESSION['user']['rank']}.css'>";
    echo "<link rel='stylesheet' href='/assets/css/navbar.css'>";
  } else echo "<link rel='stylesheet' href='/assets/css/forms.css'>";

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