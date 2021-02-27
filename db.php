<?php
DEFINE("DB_HOST", "localhost");
DEFINE("DB_USER", "dziennik");
DEFINE("DB_PASS", "123");
DEFINE("DB_DATA", "gradebook");

function connectToDB()
{
  $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATA);
  if ($connection === false) {
    die("Błąd podczas połączenia z bazą danych! " . mysqli_connect_error());
  }

  return $connection;
}
