<?php
session_start();
require '../functions/isLoggedIn.php';
require '../functions/isSelectionCorrect.php';
require_once '../db.php';
require '../view.php';
require_once '../config.php';
$header = new View('header');
$header->allocate('scripts', ['clock', GSAP, 'overlay', 'changeList', 'snackalert']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

if (isset($_SESSION['snackalert'])) {
  $snackalert = new View('snackalert');
  $snackalert->allocate('alert', [$_SESSION['snackalert']['type'], $_SESSION['snackalert']['text']]);
  $snackalert->render();
  unset($_SESSION['snackalert']);
}

$conn = connectToDB();

$numerator = array();
$denominator = array();

$sql = "SELECT `student_id`,`category_id`,`date`,`grade`,`description`,grades.`id` FROM grades JOIN students ON grades.`student_id`=students.`id` WHERE `class`='{$_SESSION['class']}' AND `subject_id`={$_SESSION['subject']['id']} AND `teacher_id`={$_SESSION['user']['id']}";
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
        echo <<<HTML
          <div class='grades__item grades__item--student'>
            <h2>{$student['last_name']} {$student['first_name']}</h2>
          <div class="item__row">
        HTML;

        if (isset($studentGrades[$student['id']])) {
          $details = function ($grade) {
            $category = $_SESSION['categories'][$grade['category_id']];
            $description = empty($grade['description']) === "" ? "Brak opisu" : $grade['description'];
            return <<<HTML
            <div class="item__container"
            data-grade={$grade['grade']} 
            data-category={$grade['category_id']} 
            data-description="{$grade['description']}" 
            data-student={$grade['student_id']}
            data-gradeid={$grade['id']}>
              <p>{$grade['grade']}</p>
              <div class="item__details">
                <h4>Opis:</h4><p>{$description}</p>
                <h4>Kategoria (waga):</h4><p>{$category['name']} ({$category['weight']})</p>
                <h4>Data:</h4><p>{$grade['date']}</p>
                <h4>Naciśnij, aby edytować</h4>
              </div>
            </div>
            HTML;
          };
          $grades = array_map($details, $studentGrades[$student['id']]);

          echo implode(",", $grades);
          $avg = $denominator[$student['id']] === 0 ? "-" : round(($numerator[$student['id']] / $denominator[$student['id']]), 2);
        } else {
          echo "Brak ocen";
          $avg = "-";
        }
        echo <<<HTML
          </div>
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
      <form class="form form--gradesInsertOne" action="../functions/insertOneGrade.php" method="POST">
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
        <button class="form__submit form__submit--insert form__submit--gradesInsertOne" type="submit">Dodaj oceny</button>
      </form>
    </div>
  </div>
  <div class="overlay">
    <div class="overlay__content">
      <h1 class="overlay__header">Edycja oceny</h1>
      <form class="form form--overlay" method="POST">
        <input type="number" name="grade" placeholder="Ocena" min="1" max="6">
        <select name="category">
          <option value="" selected disabled hidden>Kategoria (waga)</option>
          <?php
          foreach ($_SESSION['categories'] as $category) {
            echo "<option value='{$category['id']}'>{$category['name']} ({$category['weight']})</option>";
          }
          ?>
        </select>
        <input type="text" name="description" placeholder="Opis">
        <input type="hidden" name="student_id" value="">
        <input type="hidden" name="grade_id" value="">
        <button class="form__submit form__submit--edit" type="submit">Edytuj</button>
        <button class="form__submit form__submit--delete" type="submit">
          <h4>Usuń</h4>
        </button>
        <button class="form__button form__button--close">Anuluj</button>
      </form>
    </div>
  </div>
</main>