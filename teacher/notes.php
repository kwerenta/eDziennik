<?php
session_start();
require '../functions/isLoggedIn.php';
require '../functions/isSelectionCorrect.php';
require '../view.php';
require_once '../config.php';
$header = new View('header');
$header->allocate('scripts', ['clock', GSAP, 'snackalert']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

if (isset($_SESSION['snackalert'])) {
  $snackalert = new View('snackalert');
  $snackalert->allocate('alert', [$_SESSION['snackalert']['type'], $_SESSION['snackalert']['text']]);
  $snackalert->render();
  unset($_SESSION['snackalert']);
}

?>

<main>
  <div class="teacherContainer">
    <h1 class="notes__title">Dodaj uwagę</h1>
    <div class="teacherContainer--notes">
      <form class="form form--notes" action="../functions/insertNote.php" method="POST">
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
  </div>
</main>