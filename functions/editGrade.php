<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "teacher")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

$isEmpty = false;

foreach ($_POST as $input => $value) {
  if ($value === null) {
    $isEmpty = true;
  }
}
if (!$isEmpty) {
  require "../db.php";
  $conn = connectToDB();

  $sql = "UPDATE grades SET `grade`= {$_POST['grade']}, `description`='{$_POST['description']}', `category_id`='{$_POST['category']}' WHERE `id`={$_POST['grade_id']} AND `teacher_id`={$_SESSION['user']['id']} AND `student_id`={$_POST['student_id']}";
  mysqli_query($conn, $sql);
}

header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/grades.php");
