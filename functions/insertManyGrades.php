<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "teacher")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

require 'validate.php';

$areGradesOk = true;

foreach ($_POST['grade'] as $grade) {
  if (!empty($grade) && !isValueCorrect($grade, 1, 6)) {
    $areGradesOk = false;
    break;
  }
}

$isCategoryOk = !empty($_POST['category']) ? in_array($_POST['category'], array_column($_SESSION['categories'], "id")) : false;

if (!isEmpty('description') && $isCategoryOk && $areGradesOk && isStudentCorrect()) {
  require "../db.php";
  $conn = connectToDB();

  $description = empty($_POST['description']) ? "" : ", '{$_POST['description']}'";
  $sqlDescription = $description === "" ? "" : ", `description`";

  $prepareValue = function ($grade, $id) use ($description) {
    $studentId = $_POST['student_id'][$id];
    return "({$studentId},{$_SESSION['user']['id']}, {$_SESSION['subject']['id']}, {$_POST['category']}, {$grade}{$description})";
  };

  $data = array_filter($_POST['grade']);
  $valuesArray = array_map($prepareValue, $data, array_keys($data));

  $values = implode(",", $valuesArray);

  $sql = <<<SQL
  INSERT INTO grades
  (`student_id`,
  `teacher_id`,
  `subject_id`,
  `category_id`,
  `grade`
  {$sqlDescription}) 
  VALUES 
  {$values}
SQL;

  mysqli_query($conn, $sql);
  if (mysqli_affected_rows($conn) > 0) {
    $_SESSION['snackalert'] = ["type" => "success", "text" => "Oceny zostały dodane"];
  } else {
    $_SESSION['snackalert'] = ["type" => "error", "text" => "Nie udało się dodać ocen"];
  }
} else {
  $_SESSION['snackalert'] = ["type" => "error", "text" => "Formularz został błędnie wypełniony"];
}
header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/grades.php");
