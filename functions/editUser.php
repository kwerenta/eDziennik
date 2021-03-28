<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "admin")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

$isEmpty = false;
$isLastInputCorrect = false;

foreach ($_POST as $input => $value) {
  if ($value === null) {
    $isEmpty = true;
  }
}

if (isset($_POST['class'])) {
  $letters = ['A', 'B', 'C', 'D'];
  $numbers = ['1', '2', '3', '4'];
  foreach ($numbers as $number) {
    foreach ($letters as $letter) {
      $class = $number . $letter;
      if ($_POST['class'] === $class) {
        $isLastInputCorrect = true;
        break 2;
      }
    }
  }
} else {
  $isLastInputCorrect = preg_match('/^[0-9]{6}(?:[0-9]{3})?$/', $_POST['phone']);
}

if (!$isEmpty && $isLastInputCorrect) {
  require "../db.php";
  $conn = connectToDB();

  $rank = isset($_POST['class']) ? "students" : "teachers";
  $lastField = isset($_POST['class']) ? "`class`='{$_POST['class']}'" : "`phone`='{$_POST['phone']}'";

  $sql = sprintf(
    "UPDATE %s SET `first_name` = '%s', `last_name`= '%s', %s WHERE `id`=%s AND `user_id`=%s",
    $rank,
    mysqli_real_escape_string($conn, $_POST['first_name']),
    mysqli_real_escape_string($conn, $_POST['last_name']),
    $lastField,
    mysqli_real_escape_string($conn, $_POST['typeid']),
    mysqli_real_escape_string($conn, $_POST['id']),
  );
  mysqli_query($conn, $sql);
}

header("Location: http://{$_SERVER['HTTP_HOST']}/admin/users.php");
