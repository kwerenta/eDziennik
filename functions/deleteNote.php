<?php
session_start();
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "teacher")) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}

require "../db.php";
$conn = connectToDB();
$sql = sprintf(
  "DELETE FROM notes WHERE `teacher_id`=%s AND `student_id`=%s AND `id`=%s",
  $_SESSION['user']['id'],
  mysqli_real_escape_string($conn, $_POST['student_id']),
  mysqli_real_escape_string($conn, $_POST['note_id'])
);
mysqli_query($conn, $sql);
if (mysqli_affected_rows($conn) > 0) {
  $_SESSION['snackalert'] = ["type" => "success", "text" => "The note has been deleted"];
} else {
  $_SESSION['snackalert'] = ["type" => "error", "text" => "The note could not be deleted"];
};

header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/notes.php");
