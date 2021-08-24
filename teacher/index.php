<?php
session_start();
require '../functions/isLoggedIn.php';
require '../functions/isSelectionCorrect.php';
require '../view.php';
require_once '../db.php';

$header = new View('header');
$header->allocate('scripts', ['clock']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

$conn = connectToDB();

$sql = "SELECT `student_id`,`category_id`,`date`,`grade` FROM grades JOIN students ON grades.`student_id`=students.`id` WHERE `class`='{$_SESSION['class']}' AND `subject_id`={$_SESSION['subject']['id']} AND `teacher_id`={$_SESSION['user']['id']} ORDER BY `date` DESC LIMIT 7";
$query = mysqli_query($conn, $sql);
while (($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) !== null) {
  $latestGrades[] = $row;
}

if (!isset($_SESSION['students'])) {
  $sql = "SELECT `id`,`first_name`,`last_name` FROM students WHERE `class`='{$_SESSION['class']}' ORDER BY `last_name`,`first_name`";
  $query = mysqli_query($conn, $sql);
  while (($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) !== null) {
    $_SESSION['students'][$row['id']] = $row;
  }
}
?>

<main class="teacherDashboard">
  <div class="teacherDashboard__panel teacherDashboard__panel--top">
    <div class="teacherDashboard__tile">
      <h2>Hi, <?php echo "{$_SESSION['user']['first_name']} {$_SESSION['user']['last_name']}!" ?></h2>
      <p>Class <strong><?php echo $_SESSION['class'] ?></strong> and subject of <strong><?php echo $_SESSION['subject']['name'] ?></strong> were chosen</p>
    </div>
    <div class="teacherDashboard__tile">
      <h2>Next holiday</h2>
      <p><?php echo "{$_SESSION['holiday']['localName']}, {$_SESSION['holiday']['date']}" ?></p>
    </div>
    <div class="teacherDashboard__tile">
      <h2>Number of students in class</h2>
      <h1><?php echo count($_SESSION['students']) ?></h1>
    </div>
  </div>
  <div class="teacherDashboard__panel teacherDashboard__panel--bottom">
    <h2>Last grades inserted</h2>
    <div class="teacherDashboard__latestGradesItem">
      <h2>Student</h2>
      <h2>Grade</h2>
      <h2>Category</h2>
      <h2>Date</h2>
    </div>
    <?php
    if (!empty($latestGrades)) {
      foreach ($latestGrades as $grade) {
        $category = $_SESSION['categories'][$grade['category_id']];
        $student = $_SESSION['students'][$grade['student_id']];

        echo <<<HTML
          <div class="teacherDashboard__latestGradesItem">
            <h3>{$student['last_name']} {$student['first_name']}</h3>
            <p>{$grade['grade']}</p>
            <p>{$category['name']}</p>
            <h4>{$grade['date']}</h4>
          </div>
          HTML;
      }
    } else {
      echo "<h2>No grades</h2>";
    }
    ?>
  </div>
</main>