<?php
session_start();
require '../functions/isLoggedIn.php';
require '../db.php';
require '../view.php';
$header = new View('header');
$header->allocate('styles', ['navbar', 'studentGrades']);
$header->allocate('scripts', ['clock', 'changeGradesList', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

$conn = connectToDB();

$grades = [];

$sql = "SELECT * FROM grades WHERE `student_id` = {$_SESSION['user']['id']}";
$query = mysqli_query($conn, $sql);

while (($row = mysqli_fetch_array($query)) !== null) {
  $grades[$row['subject_id']][] = $row;
}

?>

<main clas="gradesContainer">
  <div class="gradesPanel">
    <div class="gradesTabs">
      <h2 class="tabHeader active">Oceny częściowe</h2>
      <h2 class="tabHeader">Oceny szczgółowo</h2>
      <h2 class="tabHeader">Podsumowanie Ocen</h2>
      <div class="activeBar"></div>
    </div>
    <div class="gradesList">
      <div class="subjectItem">
        <h2 class="header">Przedmiot</h2>
        <h2 class="header">Oceny</h2>
      </div>
      <?php
      foreach ($grades as $index => $subjects) {
        $subject = $_SESSION['subjects'][$index - 1];
        echo "<div class='subjectItem'><h2>{$subject['name']}</h2><p>";

        foreach ($subjects as $index => $grade) {
          echo $grade['grade'];
          if ($index !== array_key_last($grades[$subject['id']])) echo ',';
        }

        echo "</p></div>";
      }
      ?>
    </div>
    <div class="detailedGradesList">
      <?php
      foreach ($grades as $index => $subjects) {
        $subject = $_SESSION['subjects'][$index - 1];
        echo "<div class='detailedSubjectItem'><h2>{$subject['name']}</h2>";

        foreach ($subjects as $grade) {
          $category = $_SESSION['categories'][$grade['category_id'] - 1];
          echo <<<HTML
          <div class="detailedGradeItem">
            <div class="grade">
              <h4>Ocena</h4>
              <p>{$grade['grade']}</p>
            </div>
            <div class="description">
              <h4>Opis</h4>
              <p>{$grade['description']}</p>
            </div>
            <div class="category">
              <h4>Kategoria (waga)</h4>
              <p>{$category['name']} ({$category['weight']})</p>
            </div>
            <div class="created">
              <h4>Wystawiona</h4>
              <p>{$grade['teacher_id']}, {$grade['date']}</p>
            </div>
          </div>
          HTML;
        }
        echo "</div>";
      }
      ?>
    </div>
    <div class="gradesSummary">
      <div class="summaryItem">
        <h2>Przedmiot</h2>
        <h2>Średnia</h2>
      </div>
      <?php
      foreach ($grades as $index => $subjects) {
        $subject = $_SESSION['subjects'][$index - 1];
        $sum = 0;
        foreach ($subjects as $grade) {
          $sum += $grade['grade'];
        }
        $average = $sum / count($subjects);
        echo "<div class='summaryItem'><h2>{$subject['name']}</h2><p>{$average}</p></div>";
      }
      ?>
    </div>
  </div>
</main>