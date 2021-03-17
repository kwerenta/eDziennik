<?php
session_start();
require '../functions/isLoggedIn.php';
require '../db.php';
require '../view.php';
$header = new View('header');
$header->allocate('scripts', ['clock']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

$conn = connectToDB();

$latestGrades = [];

$sql = "SELECT `grade`,`subject_id`,`category_id`,`date` FROM grades WHERE `student_id` = {$_SESSION['user']['id']} ORDER BY `date` DESC LIMIT 8";
$query = mysqli_query($conn, $sql);

while (($row = mysqli_fetch_array($query)) !== null) {
  $latestGrades[] = $row;
}

$sql = "SELECT `date`,`teacher_id`,`description`,`points` FROM notes WHERE `student_id` = {$_SESSION['user']['id']} ORDER BY `date` DESC LIMIT 1";
$query = mysqli_query($conn, $sql);
if ($query) $latestNote = mysqli_fetch_array($query);

?>


<main class="studentDashboard">
  <div class="studentDashboard__panel studentDashboard__panel--left">
    <div class="studentDashboard__basicInfo">
      <div class="studentDashboard__tile">
        <h2>Witaj, <?php echo "{$_SESSION['user']['first_name']} {$_SESSION['user']['last_name']}!" ?></h2>
        <p>Jesteś w klasie <?php echo $_SESSION["user"]["class"] ?>.</p>
      </div>
      <div class="studentDashboard__tile">
        <h2>Najbliższy dzień wolny</h2>
        <p>Wielkanoc</p>
      </div>
      <div class="studentDashboard__tile">
        <h2>Szczęśliwy numer</h2>
        <p><?php echo rand(1, 31) ?></p>
      </div>
    </div>

    <div class="studentDashboard__latestGrades">
      <h2>Ostatnie oceny</h2>
      <div class="studentDashboard__latestGradesItem">
        <h2>Przedmiot</h2>
        <h2>Ocena</h2>
        <h2>Kategoria</h2>
        <h2>Data</h2>
      </div>
      <?php
      foreach ($latestGrades as $grade) {
        $subject = $_SESSION['subjects'][$grade['subject_id'] - 1];
        $category = $_SESSION['categories'][$grade['category_id'] - 1];
        $date = date('d.m.Y', strtotime($grade['date']));
        echo <<<HTML
          <div class="studentDashboard__latestGradesItem">
            <h4>{$subject['name']}</h4>
            <h3>{$grade['grade']}</h3>
            <p>{$category['name']}</p>
            <p>{$date}</p>
          </div>
          HTML;
      }
      ?>
    </div>
  </div>

  <div class="studentDashboard__panel studentDashboard__panel--right">
    <div class="studentDashboard__latestNote">
      <?php
      if (isset($latestNote)) {
        $idColumn = array_column($_SESSION['teachers'], 'id');
        $teacherIndex = array_search($grade['teacher_id'], $idColumn);
        $teacher = $_SESSION['teachers'][$teacherIndex];

        if ($latestNote['points'] <= 0) $sign = "";
        else $sign = "+";
        $date = date('d.m.Y', strtotime($latestNote['date']));
        echo <<<HTML
        <div class="studentDashboard__latestNoteRow">
          <h2>Ostatnia uwaga</h2>
          <p>{$date}</p>
        </div>
        <div class="studentDashboard__latestNoteRow">
          <h3>{$teacher['first_name']} {$teacher['last_name']}</h3>
          <h2>{$sign}{$latestNote['points']}</h2>
        </div>
        <p>{$latestNote['description']}</p>
        HTML;
      } else {
        echo <<<HTML
        <div class="studentDashboard__latestNoteRow">
          <h2>Brak uwag</h2>
        </div>
        HTML;
      }
      ?>
    </div>
    <div class="studentDashboard__shortTimetable">
      <h2>Plan lekcji</h2>
      <ol class="studentDashboard__shortTimetableList">
        <li>W-F</li>
        <li>GKiAI</li>
        <li>Matematyka</li>
        <li>Matematyka</li>
        <li>HiS</li>
      </ol>
    </div>
  </div>
</main>