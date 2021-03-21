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

$sql = "SELECT * FROM notes WHERE `student_id` = {$_SESSION['user']['id']}";
$query = mysqli_query($conn, $sql);

$sum = 0;
while (($row = mysqli_fetch_array($query)) !== null) {
  $sum += $row['points'];
  $notes[] = $row;
}

?>

<main>
  <div class="studentContainer studentContainer--notes">
    <h1>Suma punktów: <?php echo $sum ?></h1>
    <div class="notes__list">
      <?php
      $idColumn = array_column($_SESSION['teachers'], 'id');
      foreach ($notes as $note) {
        $sign = $note['points'] <= 0 ? "" : "+";

        $teacherIndex = array_search($note['teacher_id'], $idColumn);
        $teacher = $_SESSION['teachers'][$teacherIndex];

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