<?php
session_start();
require '../functions/isLoggedIn.php';
require '../view.php';
$header = new View('header');
$header->allocate('styles', ['navbar', 'studentDashboard']);
$header->allocate('scripts', ['clock']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

?>


<main class="dashboardContainer">
  <div class="leftPanel">
    <div class="simpleInfo">
      <div class="dashboardTile">
        <h2>Witaj, <?php echo $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"] . "!" ?></h2>
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
        <h4>Matematyka</h4>
        <h3>5</h3>
        <p>Kartkówka</p>
        <p>02.03.2021</p>
      </div>
      <div class="latestGradesItem">
        <h4>Polski</h4>
        <h3>6</h3>
        <p>Praca klasowa</p>
        <p>02.03.2021</p>
      </div>
      <div class="latestGradesItem">
        <h4>PrPZ</h4>
        <h3>6</h3>
        <p>Praca klasowa</p>
        <p>19.03.2021</p>
      </div>
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