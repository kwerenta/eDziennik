<?php
if (!empty($_GET)) {
  unset($_SESSION['class']);
  unset($_SESSION['subject']);

  if (isset($_GET['class'])) {
    if (in_array($_GET['class'], $_SESSION['classes'])) {
      $_SESSION['class'] = $_GET['class'];
    } else {
      header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/selection.php");
      exit();
    }
  } else {
    header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/selection.php");
    exit();
  }

  if (isset($_GET['subject'])) {
    if (in_array($_GET['subject'], array_column($_SESSION['subjects'], "id"))) {
      $_SESSION['subject'] = $_SESSION['subjects'][$_GET['subject']];
    } else {
      header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/selection.php");
      exit();
    }
  } else {
    header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/selection.php");
    exit();
  }
} elseif (!isset($_SESSION['class']) || !isset($_SESSION['subject'])) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/selection.php");
  exit();
}
