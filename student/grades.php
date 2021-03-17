<?php
session_start();
require '../functions/isLoggedIn.php';
require '../db.php';
require '../view.php';
$header = new View('header');
$header->allocate('scripts', ['clock', 'changeList', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js']);
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

<main>
  <div class="studentContainer studentContainer--grades">
    <div class="menu__tabs">
      <h2 class="menu__tabHeader menu__tabHeader--active">Oceny częściowe</h2>
      <h2 class="menu__tabHeader">Oceny szczgółowo</h2>
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
        $subject = $_SESSION['subjects'][$index - 1];
        echo "<div class='grades__item grades__item--subject'><h2>{$subject['name']}</h2><p>";

        foreach ($subjects as $index => $grade) {
          echo $grade['grade'];
          if ($index !== array_key_last($grades[$subject['id']])) echo ',';
        }

        echo "</p></div>";
      }
      ?>
    </div>
    <div class="grades__detailedGradesList">
      <?php
      foreach ($grades as $index => $subjects) {
        $subject = $_SESSION['subjects'][$index - 1];
        echo "<div class='grades__item--detailedSubject'><h2>{$subject['name']}</h2>";

        foreach ($subjects as $grade) {
          $category = $_SESSION['categories'][$grade['category_id'] - 1];
          echo <<<HTML
          <div class="grades__item--detailedGrade">
            <div>
              <h4>Ocena</h4>
              <p>{$grade['grade']}</p>
            </div>
            <div>
              <h4>Opis</h4>
              <p>{$grade['description']}</p>
            </div>
            <div>
              <h4>Kategoria (waga)</h4>
              <p>{$category['name']} ({$category['weight']})</p>
            </div>
            <div>
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
    <div class="grades__gradesSummary">
      <div class="grades__item--summary">
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
        echo "<div class='grades__item--summary'><h2>{$subject['name']}</h2><p>{$average}</p></div>";
      }
      ?>
    </div>
  </div>
</main>