<?php
require 'config.php';

function connectToDB()
{
  $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_SCHEMA);
  if (!$connection) {
    die("Błąd podczas połączenia z bazą danych! " . mysqli_connect_error());
  }

  return $connection;
}
