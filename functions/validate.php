<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
function isEmpty(string $notRequired = "")
{
  foreach ($_POST as $index => $value) {
    if (empty($value) && (strpos($notRequired, $index) === false)) return true;
  }
  return false;
}

function isEmailCorrect()
{
  return filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
}

function isClassCorrect()
{
  foreach ($_SESSION['classes'] as $class) {
    if (!empty($_POST['class']) && $_POST['class'] === $class) {
      return true;
    }
  }
  return false;
}

function areStudentsCorrect()
{
  foreach ($_POST['student_id'] as $id) {
    if (!in_array($id, array_column($_SESSION['students'], "id"))) return false;
  }
  return true;
}

function isPhoneCorrect()
{
  if (empty($_POST['phone'])) return true;
  return preg_match('/^[0-9]{6}(?:[0-9]{3})?$/', $_POST['phone']);
}

function isValueCorrect(string $input, int $min, int $max)
{
  if ($input < $min || $input > $max) return false;
  return true;
}

function isLenghtCorrect(string $input, int $min, int $max)
{
  $length = strlen($input);
  if ($length < $min || $length > $max) return false;
  return true;
}
