<?php
session_start();
require '../functions/isLoggedIn.php';
require '../db.php';
require '../view.php';
$header = new View('header');
$header->allocate('styles', ['navbar', 'studentDashboard']);
$header->allocate('scripts', ['clock']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

$conn = connectToDB();

$latestGrades = [];

$sql = "SELECT * FROM grades WHERE `student_id` = {$_SESSION['user']['id']} ORDER BY `date` DESC LIMIT 10";
$query = mysqli_query($conn, $sql);

while (($row = mysqli_fetch_array($query)) !== null) {
  $latestGrades[] = $row;
}

?>


<main class="dashboardContainer">
  <div class="leftPanel">
    <div class="simpleInfo">
      <div class="dashboardTile">
        <h2>Witaj, <?php echo "{$_SESSION['user']['first_name']} {$_SESSION['user']['last_name']}!" ?></h2>
        <p>Jesteś w klasie <?php echo $_SESSION["user"]["class"] ?>.</p>
      </div>
      <div class="dashboardTile">
        <h2>Najbliższe dni wolne</h2>
        <p>Wielkanoc</p>
      </div>
      <div class="dashboardTile">
        <h2>Szczęśliwy numer</h2>
        <p><?php echo rand(1, 31) ?></p>
      </div>
    </div>

    <div class="latestGrades">
      <h2>Ostatnie oceny</h2>
      <div class="latestGradesItem">
        <h2>Przedmiot</h2>
        <h2>Ocena</h2>
        <h2>Kategoria</h2>
        <h2>Data</h2>
      </div>
      <?php
      foreach ($latestGrades as $grade) {
        $subject = $_SESSION['subjects'][$grade['subject_id'] - 1];
        $category = $_SESSION['categories'][$grade['category_id'] - 1];
        echo <<<HTML
          <div class="latestGradesItem">
            <h4>{$subject['name']}</h4>
            <h3>{$grade['grade']}</h3>
            <p>{$category['name']}</p>
            <p>{$grade['date']}</p>
          </div>
          HTML;
      }
      ?>
    </div>
  </div>

  <div class="rightPanel">
    <div class="latestNote">
      <div class="latestNoteRow">
        <h2>Ostatnia uwaga</h2>
        <p>02.03.2021</p>
      </div>
      <div class="latestNoteRow">
        <h3>Fajny Nauczyciel</h3>
        <h2>+150</h2>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facilis tempore doloremque fugiat laborum accusantium? Dicta, vitae. Excepturi dolorum debitis aut aperiam accusamus tempore. Molestiae quae earum eos nihil nostrum. Excepturi?</p>
    </div>
    <div class="shortTimetable">
      <h2>Plan lekcji</h2>
      <ol class="shortTimetableList">
        <li>W-F</li>
        <li>GKiAI</li>
        <li>Matematyka</li>
        <li>Matematyka</li>
        <li>HiS</li>
      </ol>
    </div>
  </div>
</main>