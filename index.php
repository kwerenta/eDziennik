<?php

session_start();

if (isset($_SESSION["user"])) {
  header('Location: /' . $_SESSION['user']['rank']);
}

require 'view.php';

$header = new View('header');
$header->allocate('styles', ['forms']);
$header->allocate('scripts', ['https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js', 'changeForm']);
$header->render();

$forms = new View("forms");
$forms->render();
