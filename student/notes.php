<?php
session_start();
require '../functions/isLoggedIn.php';
require '../view.php';
$header = new View('header');
$header->allocate('scripts', ['clock']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

require '../db.php';
$conn = connectToDB();

$sql = "SELECT * FROM notes WHERE `student_id` = {$_SESSION['user']['id']} ORDER BY `date` DESC";
$query = mysqli_query($conn, $sql);

$sum = 0;
while (($row = mysqli_fetch_array($query)) !== null) {
  $sum += $row['points'];
  $notes[] = $row;
}

?>

<main>
  <div class="studentContainer studentContainer--notes">
    <h1>
      <?php
      if (!empty($notes)) echo "Suma punktów: {$sum}";
      else echo "Brak uwag";
      ?>
    </h1>
    <div class="notes__list">
      <?php
      if (!empty($notes)) {
        foreach ($notes as $note) {
          $sign = $note['points'] <= 0 ? "" : "+";
          $teacher = $_SESSION['teachers'][$note['teacher_id']];
          $description = $note['description'] === "" ? "Brak opisu" : $note['description'];
          echo <<<HTML
        <div class="notes__item">
          <div class="notes__title">
            <h2>{$sign}{$note['points']}</h2>
            <h3>{$note['date']}</h3>
          </div>
          <div class="notes__data">
            <div>
              <h4>Nauczyciel</h4>
              <p>{$teacher['first_name']} {$teacher['last_name']}</p>
            </div>
            <div>
              <h4>Opis</h4>
              <p>{$description}</p>
            </div>
          </div>
        </div>
        HTML;
        }
      }
      ?>
    </div>
  </div>
</main>