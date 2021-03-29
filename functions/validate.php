<?php
function isEmpty(string $notRequired = "")
{
  foreach ($_POST as $index => $value) {
    if (empty($value) && $index !== $notRequired) return true;
  }
  return false;
}

function isEmailCorrect()
{
  return filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
}

function isClassCorrect()
{
  $letters = ['A', 'B', 'C', 'D'];
  $numbers = ['1', '2', '3', '4'];
  foreach ($numbers as $number) {
    foreach ($letters as $letter) {
      $class = $number . $letter;
      if (!empty($_POST['class']) && $_POST['class'] === $class) {
        return true;
      }
    }
  }
  return false;
}

function isPhoneCorrect()
{
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
