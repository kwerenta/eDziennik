<?php
session_start();
require '../functions/isLoggedIn.php';
require '../view.php';
$header = new View('header');
$header->allocate('styles', ['navbar', 'studentGrades']);
$header->allocate('scripts', ['clock']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

?>

<main class="gradesContainer">
  <div class="gradesTabs">
    <h2 class="tabHeader active">Oceny częściowe</h2>
    <h2 class="tabHeader">Oceny szczgółowo</h2>
    <h2 class="tabHeader">Podsumowanie Ocen</h2>
    <div class="activeBar"></div>
  </div>
  <div class="gradesList">
    <div class="gradeItem">
      <h2 class="subject">Przedmiot</h2>
      <h2 class="grade">Ocena</h2>
      <h2 class="category">Kategoria</h2>
      <h2 class="date">Data</h2>
    </div>
    <div class="gradeItem">
      <h4 class="subject">Matematyka</h4>
      <h3 class="grade">5</h3>
      <p class="category">Kartkówka</p>
      <p class="date">02.03.2021</p>
    </div>
  </div>
</main>