<?php
session_start();

if (!isset($_SESSION["user"])) {
  header('Location: /');
}
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
    </div>
    <div class="dashboardTile">
      <h2>Twoje najnowsze oceny: </h2>
    </div>
    <div class="dashboardTile">
      <h2>Twoje najnowsze uwagi: </h2>
    </div>
  </div>
</main>