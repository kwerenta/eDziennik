<?php
if (!isset($_SESSION["user"])) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
} elseif (!fnmatch("/{$_SESSION['user']['rank']}*", $_SERVER['REQUEST_URI'])) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/{$_SESSION['user']['rank']}");
}
