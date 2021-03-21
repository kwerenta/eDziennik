<?php
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
}
require '../view.php';

$header = new View('header');
$header->allocate('scripts', ['clock']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

?>

<main class="teacherDashboard">
  <div class="teacherContainer teacherContainer--classSelection">
    <h1 class="classSelection__title">Wybierz klasę</h1>
    <div class="classSelection__list">
      <?php
      $numbers = ['1', '2', '3', '4'];
      $letters = ['A', 'B', 'C', 'D'];
      foreach ($numbers as $number) {
        foreach ($letters as $letter) {
          $class = $number . $letter;
          echo "<a href='/teacher?class={$class}' class='classSelection__item'>{$class}</a>";
        }
      }
      ?>
    </div>
  </div>

</main>