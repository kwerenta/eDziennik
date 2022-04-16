<?php
$sql = "INSERT INTO timetables VALUES ";
$values = [];

$classArray = [];
$letters = ['A', 'B', 'C', 'D'];
$numbers = ['1', '2', '3', '4'];
foreach ($numbers as $number) {
  foreach ($letters as $letter) {
    $classArray[] = $number . $letter;
  }
}

foreach ($classArray as $class) {
  foreach (range(1, 5) as $weekday) {
    $implode = "";
    $lessons = [];
    $rand = rand(5, 9);
    $first = rand(1, 51);
    if ($first % 3) $lessons[] = 0;
    foreach (range(1, $rand) as $number) {
      $lessons[] = rand(1, 18);
    }
    $implode = implode(',', $lessons);
    $values[] = "('{$class}',$weekday,'[{$implode}]')";
  }
}
$result = $sql . implode(',', $values);

die(var_dump($result));

// require 'db.php';
// $conn = connectToDB();

// $query = mysqli_query($conn, $result);

// die(var_dump($query));
