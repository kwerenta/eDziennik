<?php
session_start();
require '../functions/isLoggedIn.php';
require_once '../view.php';
require_once '../config.php';
$header = new View('header');
$header->allocate('scripts', ['clock', GSAP, 'snackalert']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

$settings = new View('settings');
$settings->allocate("rank", "admin");
$settings->render();

if (isset($_SESSION['snackalert'])) {
  $snackalert = new View('snackalert');
  $snackalert->allocate('alert', [$_SESSION['snackalert']['type'], $_SESSION['snackalert']['text']]);
  $snackalert->render();
  unset($_SESSION['snackalert']);
}
