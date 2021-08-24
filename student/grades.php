<?php
session_start();
require '../functions/isLoggedIn.php';
require '../db.php';
require '../view.php';
require_once '../config.php';
$header = new View('header');
$header->allocate('scripts', ['clock', GSAP, 'changeList']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

$conn = connectToDB();

$numerator = array();
$denominator = array();

$grades = [];

$sql = "SELECT grades.`id`,`student_id`,`teacher_id`,`subject_id`,`category_id`,`date`,`grade`,`description` FROM grades JOIN subjects ON grades.`subject_id`=subjects.`id` WHERE `student_id` = {$_SESSION['user']['id']} ORDER BY `name`,`date` DESC";
$query = mysqli_query($conn, $sql);

while (($row = mysqli_fetch_array($query)) !== null) {
  if (!isset($numerator[$row['subject_id']])) $numerator[$row['subject_id']] = 0;
  if (!isset($denominator[$row['subject_id']])) $denominator[$row['subject_id']] = 0;

  $weight = $_SESSION['categories'][$row['category_id']]['weight'];
  $numerator[$row['subject_id']] += $row['grade'] * $weight;
  $denominator[$row['subject_id']] += $weight;

  $grades[$row['subject_id']][] = $row;
}
?>

<main>
  <div class="studentContainer studentContainer--grades">
    <div class="menu__tabs">
      <h2 class="menu__tabHeader menu__tabHeader--active">Grades</h2>
      <h2 class="menu__tabHeader">Detailed grades</h2>
      <h2 class="menu__tabHeader">Grades summary</h2>
      <div class="menu__activeBar"></div>
    </div>
    <div class="grades__gradesList">
      <div class="grades__item grades__item--subject">
        <h2 class="grades__header">Subject</h2>
        <h2 class="grades__header">Grades</h2>
      </div>
      <?php
      if (!empty($grades)) {
        foreach ($grades as $index => $subjects) {
          $subject = $_SESSION['subjects'][$index];
          echo "<div class='grades__item grades__item--subject'><h2>{$subject['name']}</h2><p>";
          echo implode(",", array_column($grades[$subject['id']], 'grade'));
          echo "</p></div>";
        }
      } else {
        echo "<h2>No grades</h2>";
      }
      ?>
    </div>
    <div class="grades__detailedGradesList">
      <?php
      if (!empty($grades)) {
        foreach ($grades as $index => $subjects) {
          $subject = $_SESSION['subjects'][$index];
          echo "<div class='grades__item--detailedSubject'><h2>{$subject['name']}</h2>";

          foreach ($subjects as $grade) {
            $category = $_SESSION['categories'][$grade['category_id']];
            $teacher = $_SESSION['teachers'][$grade['teacher_id']];
            $description = $grade['description'] === "" ? "Brak opisu" : $grade['description'];
            echo <<<HTML
          <div class="grades__item--detailedGrade">
            <div>
              <h4>Grade</h4>
              <p>{$grade['grade']}</p>
            </div>
            <div>
              <h4>Description</h4>
              <p>{$description}</p>
            </div>
            <div>
              <h4>Category (weight)</h4>
              <p>{$category['name']} ({$category['weight']})</p>
            </div>
            <div>
              <h4>Teacher & Date</h4>
              <p>{$teacher['first_name']} {$teacher['last_name']}, {$grade['date']}</p>
            </div>
          </div>
          HTML;
          }
          echo "</div>";
        }
      } else {
        echo "<h2>No grades</h2>";
      }
      ?>
    </div>
    <div class="grades__gradesSummary">
      <div class="grades__item--summary">
        <h2>Subject</h2>
        <h2>Average grade</h2>
      </div>
      <?php
      if (!empty($grades)) {
        foreach ($_SESSION['subjects'] as $subject) {
          if (isset($denominator[$subject['id']])) {
            $average = round(($numerator[$subject['id']] / $denominator[$subject['id']]), 2);
            echo "<div class='grades__item--summary'><h2>{$subject['name']}</h2><p>{$average}</p></div>";
          }
        }
      } else {
        echo "<h2>No grades</h2>";
      }
      ?>
    </div>
  </div>
</main>