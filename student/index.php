<?php
session_start();
require '../functions/isLoggedIn.php';
require '../view.php';
$header = new View('header');
$header->allocate('styles', ['navbar', 'dashboard']);
$header->allocate('scripts', ['clock']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

?>

<div class="topbar">
  <h1 class="clock">00:00:00</h1>
</div>

<main>
  <div class="dashboardContainer">
    <div class="dashboardTile">
      <h1>Witaj, <?php echo $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"] . "!" ?></h1>
      <p>Jesteś w klasie <?php echo $_SESSION["user"]["class"] ?>.</p>
    </div>
    <div class="dashboardTile">
      <h2>Twoi nauczyciele: </h2>
      <p>Jacek śmieć</p>
    </div>
    <div class="dashboardTile">
      <h2>Twoje najnowsze oceny: </h2>
      <p>6,6,6,6,6,6</p>
    </div>
    <div class="dashboardTile">
      <h2>Twoje najnowsze uwagi: </h2>
      <p>+150 na chęci do życia</p>
    </div>
  </div>
</main>