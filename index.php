<?php

session_start();

if (isset($_SESSION["user"])) {
  header('Location: /' . $_SESSION['user']['rank']);
  exit();
}
require 'view.php';
require 'config.php';
if (empty($_SESSION['classes'])) {
  $numbers = ['1', '2', '3', '4'];
  $letters = ['A', 'B', 'C', 'D'];
  foreach ($numbers as $number) {
    foreach ($letters as $letter) {
      $_SESSION['classes'][] = $number . $letter;
    }
  }
}



$header = new View('header');
$header->allocate('scripts', [GSAP, 'changeForm']);
$header->render();

$forms = new View("forms");
$forms->render();
