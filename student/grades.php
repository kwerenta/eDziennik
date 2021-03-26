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
      <h2 class="menu__tabHeader menu__tabHeader--active">Oceny częściowe</h2>
      <h2 class="menu__tabHeader">Oceny szeczgółowo</h2>
      <h2 class="menu__tabHeader">Podsumowanie Ocen</h2>
      <div class="menu__activeBar"></div>
    </div>
    <div class="grades__gradesList">
      <div class="grades__item grades__item--subject">
        <h2 class="grades__header">Przedmiot</h2>
        <h2 class="grades__header">Oceny</h2>
      </div>
      <?php
      foreach ($grades as $index => $subjects) {
        $subject = $_SESSION['subjects'][$index];
        echo "<div class='grades__item grades__item--subject'><h2>{$subject['name']}</h2><p>";
        echo implode(",", array_column($grades[$subject['id']], 'grade'));
        echo "</p></div>";
      }
      ?>
    </div>
    <div class="grades__detailedGradesList">
      <?php
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
              <h4>Ocena</h4>
              <p>{$grade['grade']}</p>
            </div>
            <div>
              <h4>Opis</h4>
              <p>{$description}</p>
            </div>
            <div>
              <h4>Kategoria (waga)</h4>
              <p>{$category['name']} ({$category['weight']})</p>
            </div>
            <div>
              <h4>Wystawiona</h4>
              <p>{$teacher['first_name']} {$teacher['last_name']}, {$grade['date']}</p>
            </div>
          </div>
          HTML;
        }
        echo "</div>";
      }
      ?>
    </div>
    <div class="grades__gradesSummary">
      <div class="grades__item--summary">
        <h2>Przedmiot</h2>
        <h2>Średnia</h2>
      </div>
      <?php
      foreach ($_SESSION['subjects'] as $subject) {
        if (isset($denominator[$subject['id']])) {
          $average = round(($numerator[$subject['id']] / $denominator[$subject['id']]), 2);
          echo "<div class='grades__item--summary'><h2>{$subject['name']}</h2><p>{$average}</p></div>";
        }
      }
      ?>
    </div>
  </div>
</main>