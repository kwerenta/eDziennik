<?php
session_start();
require '../functions/isLoggedIn.php';
require '../functions/isSelectionCorrect.php';
require_once '../db.php';
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

$sql = "SELECT `student_id`,`category_id`,`date`,`grade` FROM grades JOIN students ON grades.`student_id`=students.`id` WHERE `class`='{$_SESSION['class']}' AND `subject_id`={$_SESSION['subject']['id']} AND `teacher_id`={$_SESSION['user']['id']}";
$query = mysqli_query($conn, $sql);
while (($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) !== null) {
  if (!isset($numerator[$row['student_id']])) $numerator[$row['student_id']] = 0;
  if (!isset($denominator[$row['student_id']])) $denominator[$row['student_id']] = 0;

  $numerator[$row['student_id']] += $row['grade'] * $_SESSION['categories'][$row['category_id']]['weight'];
  $denominator[$row['student_id']] += $_SESSION['categories'][$row['category_id']]['weight'];

  $studentGrades[$row['student_id']][] = $row;
}

?>

<main>
  <div class="teacherContainer teacherContainer--grades">
    <div class="menu__tabs">
      <h2 class="menu__tabHeader menu__tabHeader--active">Wyświetl oceny</h2>
      <h2 class="menu__tabHeader">Wstaw ocenę</h2>
      <h2 class="menu__tabHeader">Wstaw wiele ocen</h2>
      <div class="menu__activeBar"></div>
    </div>
    <div class="grades__gradesList">
      <div class="grades__item grades__item--student">
        <h2 class="grades__header">Uczeń</h2>
        <h2 class="grades__header">Oceny</h2>
        <h2 class="grades__header">Średnia</h2>
      </div>
      <?php
      foreach ($_SESSION['students'] as $student) {
        echo "<div class='grades__item grades__item--student'><h2>{$student['first_name']} {$student['last_name']}</h2><p>";

        if (isset($studentGrades[$student['id']])) {
          echo implode(",", array_column($studentGrades[$student['id']], 'grade'));
        } else {
          echo "Brak ocen";
        }
        $avg = isset($denominator[$student['id']]) ? round(($numerator[$student['id']] / $denominator[$student['id']]), 2) : "-";
        echo <<<HTML
          </p>
            <p>{$avg}</p>
          </div> 
        HTML;
      }
      ?>
    </div>
    <div class="grades__insertOne">
      <form class="form form--gradesInsertOne" action="../functions/insertOneGrade.php" method="POST">
        <select name="student" required>
          <option value="" selected disabled hidden>Uczeń</option>
          <?php
          foreach ($_SESSION['students'] as $student) {
            echo "<option value='{$student['id']}'>{$student['first_name']} {$student['last_name']}</option>";
          }
          ?>
        </select>
        <input type="number" name="grade" placeholder="Ocena" min="1" max="6" required>
        <select name="category" required>
          <option value="" selected disabled hidden>Kategoria (waga)</option>
          <?php
          foreach ($_SESSION['categories'] as $category) {
            echo "<option value='{$category['id']}'>{$category['name']} ({$category['weight']})</option>";
          }
          ?>
        </select>
        <input type="text" name="description" placeholder="Opis">
        <button class="form__submit form__submit--insert form__submit--gradesInsertOne" type="submit">Dodaj ocenę</button>
      </form>
    </div>
    <div class="grades__insertMany">
      <form action="" method="post">
        <select name="student">
          <option value="">1</option>
          <option value="">2</option>
        </select>
      </form>
    </div>
  </div>
</main>