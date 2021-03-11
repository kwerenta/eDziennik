<?php
session_start();
require '../functions/isLoggedIn.php';
require '../view.php';
$header = new View('header');
$header->allocate('styles', ['navbar', 'studentNotes']);
$header->allocate('scripts', ['clock']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

require '../db.php';
$conn = connectToDB();

$sql = "SELECT * FROM notes WHERE `student_id` = {$_SESSION['user']['id']}";
$query = mysqli_query($conn, $sql);

while (($row = mysqli_fetch_array($query)) !== null) {
  $notes[] = $row;
}

?>

<main>
  <div class="notesPanel">
    <div class="notesList">
      <?php
      foreach ($notes as $note) {
        if ($note['points'] <= 0) $sign = "";
        else $sign = "+";

        echo <<<HTML
      <div class="notesItem">
        <div class="notesRowTitle">
          <h2>{$sign}{$note['points']}</h2>
          <h3>{$note['date']}</h3>
        </div>
        <div class="notesData">
          <div class="grade">
            <h4>Nauczyciel</h4>
            <p>{$note['teacher_id']}</p>
          </div>
          <div class="description">
            <h4>Opis</h4>
            <p>{$note['description']}</p>
          </div>
        </div>
      </div>
      HTML;
      }
      ?>
    </div>
  </div>
</main>