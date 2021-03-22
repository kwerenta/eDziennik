<?php
session_start();
require '../functions/isLoggedIn.php';
require '../view.php';
require_once '../db.php';

if (isset($_GET['class'])) {
  $classArray = array();
  $numbers = ['1', '2', '3', '4'];
  $letters = ['A', 'B', 'C', 'D'];
  foreach ($numbers as $number) {
    foreach ($letters as $letter) {
      $classArray[] = $number . $letter;
    }
  }

  if (in_array($_GET['class'], $classArray)) {
    $_SESSION['class'] = $_GET['class'];
  } else {
    unset($_SESSION['class']);
  }
}

if (!isset($_SESSION['class'])) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/teacher/class.php");
  exit();
};

$header = new View('header');
$header->allocate('scripts', ['clock']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

$conn = connectToDB();

$sql = "SELECT COUNT(1) FROM students WHERE `class`='{$_SESSION['class']}'";
$query = mysqli_query($conn, $sql);
$studentsCount = mysqli_fetch_array($query, MYSQLI_NUM)[0];

$sql = "SELECT `student_id`,`category_id`,`date`,`grade` FROM grades JOIN students ON grades.`student_id`=students.`id` WHERE `class`='{$_SESSION['class']}' AND `teacher_id`={$_SESSION['user']['id']} ORDER BY `date` DESC LIMIT 7";
$query = mysqli_query($conn, $sql);
while (($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) !== null) {
  $latestGrades[] = $row;
}

$sql = "SELECT `id`,`first_name`,`last_name` FROM students WHERE `class`='{$_SESSION['class']}'";
$query = mysqli_query($conn, $sql);
while (($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) !== null) {
  $_SESSION['students'][$row['id']] = $row;
}
?>

<main class="teacherDashboard">
  <div class="teacherDashboard__panel teacherDashboard__panel--top">
    <div class="teacherDashboard__tile">
      <h2>Witaj, <?php echo "{$_SESSION['user']['first_name']} {$_SESSION['user']['last_name']}!" ?></h2>
      <p>Wybrano klasę <strong><?php echo $_SESSION['class'] ?></strong>.</p>
    </div>
    <div class="teacherDashboard__tile">
      <h2>Najbliższe święto</h2>
      <p><?php echo "{$_SESSION['holiday']['localName']}, {$_SESSION['holiday']['date']}" ?></p>
    </div>
    <div class="teacherDashboard__tile">
      <h2>Liczba uczniów w klasie</h2>
      <h1><?php echo $studentsCount ?></h1>
    </div>
  </div>
  <div class="teacherDashboard__panel teacherDashboard__panel--bottom">
    <h2>Najnowsze wpisane przez Ciebie oceny</h2>
    <div class="teacherDashboard__latestGradesItem">
      <h2>Uczeń</h2>
      <h2>Ocena</h2>
      <h2>Kategoria</h2>
      <h2>Data</h2>
    </div>
    <?php
    foreach ($latestGrades as $grade) {
      $category = $_SESSION['categories'][$grade['category_id']];
      $student = $_SESSION['students'][$grade['student_id']];

      echo <<<HTML
          <div class="teacherDashboard__latestGradesItem">
            <h3>{$student['first_name']} {$student['last_name']}</h3>
            <p>{$grade['grade']}</p>
            <p>{$category['name']}</p>
            <h4>{$grade['date']}</h4>
          </div>
          HTML;
    }
    ?>
  </div>
</main>