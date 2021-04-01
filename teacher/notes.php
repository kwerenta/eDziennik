<?php
session_start();
require '../functions/isLoggedIn.php';
require '../functions/isSelectionCorrect.php';
require '../view.php';
require_once '../db.php';
require_once '../config.php';
$header = new View('header');
$header->allocate('scripts', ['clock', GSAP, 'changeList', 'snackalert']);
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

$sql = "SELECT notes.`id`,`student_id`,`date`,`description`,`points` FROM notes JOIN students ON notes.`student_id`=students.`id` WHERE `class`='{$_SESSION['class']}' AND `teacher_id`={$_SESSION['user']['id']} ORDER BY `date` DESC";
$query = mysqli_query($conn, $sql);
while (($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) !== null) {
  $notes[$row['student_id']][] = $row;
}

?>

<main>
  <div class="teacherContainer teacherContainer--notes">
    <div class="menu__tabs">
      <h2 class="menu__tabHeader menu__tabHeader--active">Wyświetl uwagi</h2>
      <h2 class="menu__tabHeader">Wstaw uwagę</h2>
      <h2 class="menu__tabHeader">Wstaw wiele uwag</h2>
      <div class="menu__activeBar"></div>
    </div>
    <div class="notes__list">
      <?php
      foreach ($_SESSION['students'] as $index => $student) {
        if (!empty($notes[$index])) {
          echo "<div class='notes__item--student'><h2>{$student['last_name']} {$student['first_name']}</h2>";

          foreach ($notes[$index] as $note) {
            $sign = $note['points'] <= 0 ? "" : "+";
            $description = $note['description'] === "" ? "Brak opisu" : $note['description'];
            echo <<<HTML
          <div class="notes__item" data-studentid={$note['student_id']} data-noteid={$note['id']}>
            <div class="notes__title">
              <h2>{$sign}{$note['points']}</h2>
              <h3>{$note['date']}</h3>
            </div>
            <div class="notes__data">
              <div>
                <h4>Opis</h4>
                <p>{$description}</p>
              </div>
            </div>
          </div>
          HTML;
          }
          echo "</div>";
        }
      }
      ?>
    </div>
    <div class="notes__insertOne">
      <form class="form form--notes" action="../functions/insertOneNote.php" method="POST">
        <select name="student" required>
          <option value="" selected disabled hidden>Uczeń</option>
          <?php
          foreach ($_SESSION['students'] as $student) {
            echo "<option value='{$student['id']}'>{$student['first_name']} {$student['last_name']}</option>";
          }
          ?>
        </select>
        <input type="number" name="points" placeholder="Punkty" min="-150" max="150" required>
        </select>
        <textarea type="text" name="description" placeholder="Opis" cols="40" rows="10"></textarea>
        <button class="form__submit form__submit--insert form__submit--insertNote" type="submit">Dodaj uwagę</button>
      </form>
    </div>
    <div class="notes__insertMany">
      <form class="form form--notes" action="../functions/insertManyNotes.php" method="POST">
        <input type="number" name="points" placeholder="Punkty" min="-150" max="150" required>
        </select>
        <textarea type="text" name="description" placeholder="Opis" cols="40" rows="10"></textarea>
        <button class="form__submit form__submit--insert form__submit--insertNote" type="submit">Dodaj uwagi</button>
      </form>
    </div>
  </div>
</main>