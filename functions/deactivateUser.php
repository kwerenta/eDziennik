<?php
session_start();
if (!isset($_SESSION["user"]) && $_SESSION['user']['rank'] !== "admin") {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
  exit();
}
require "../db.php";
$conn = connectToDB();

$sql = sprintf(
  "SELECT `isActivated` FROM users WHERE `id`=%s AND `email`='%s' AND `isActivated`=%s",
  mysqli_real_escape_string($conn, $_POST['id']),
  mysqli_real_escape_string($conn, $_POST['email']),
  mysqli_real_escape_string($conn, $_POST['isActivated']),
);
$isActivated = mysqli_query($conn, $sql);

if ($isActivated->num_rows !== 0) {
  $newValue = $_POST['isActivated'] === "0" ? 1 : 0;
  $snackText = $newValue === 1 ? "odblokowa" : "zablokowa";
  $sql = "UPDATE users SET `isActivated` = {$newValue} WHERE `id`={$_POST['id']} AND `email`='{$_POST['email']}'";
  mysqli_query($conn, $sql);

  if (mysqli_affected_rows($conn) > 0) {
    $_SESSION['snackalert'] = ["type" => "success", "text" => "Użytkownik został {$snackText}ny"];
  } else {
    $_SESSION['snackalert'] = ["type" => "error", "text" => "Nie udało się {$snackText}ć użytkownia"];
  };
}
$get = "";
if ($_SESSION['deactivatedOnly'] === -1) $get = "?deactivatedOnly=true";
header("Location: http://{$_SERVER['HTTP_HOST']}/admin/users.php{$get}");
