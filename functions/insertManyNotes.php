<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "teacher")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}
require 'validate.php';

$arePointsOk = true;

foreach ($_POST['points'] as $points) {
  if (!empty($points) && !isValueCorrect($points, -150, 150)) {
    $arePointsOk = false;
    break;
  }
}

if ($arePointsOk && areStudentsCorrect()) {
  require "../db.php";
  $conn = connectToDB();

  $description = mysqli_real_escape_string($conn, $_POST['description']);

  $prepareValue = function ($points, $id) use ($description) {
    $studentId = $_POST['student_id'][$id];
    return "({$studentId},{$_SESSION['user']['id']}, {$points}, '{$description}')";
  };

  $data = array_filter($_POST['points']);
  $valuesArray = array_map($prepareValue, $data, array_keys($data));

  $values = implode(",", $valuesArray);

  $sql = <<<SQL
  INSERT INTO notes
  (`student_id`,
  `teacher_id`,
  `points`,
  `description`) 
  VALUES 
  {$values}
SQL;
  mysqli_query($conn, $sql);

  if (mysqli_affected_rows($conn) > 0) {
    $_SESSION['snackalert'] = ["type" => "success", "text" => "Uwaga została dodana"];
  } else {
    $_SESSION['snackalert'] = ["type" => "error", "text" => "Nie udało się dodać uwagi"];
  }
} else {
  $_SESSION['snackalert'] = ["type" => "error", "text" => "Formularz został błędnie wypełniony"];
}
header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/notes.php");
