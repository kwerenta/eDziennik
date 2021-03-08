<?php
session_start();
require '../functions/isLoggedIn.php';
require '../db.php';
require '../view.php';
$header = new View('header');
$header->allocate('styles', ['navbar', 'studentGrades']);
$header->allocate('scripts', ['clock', 'changeGradesList', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

$conn = connectToDB();

$grades = [];

$sql = "SELECT * FROM grades WHERE `student_id` = {$_SESSION['user']['id']}";
$query = mysqli_query($conn, $sql);
var_dump($_SESSION['user']['id']);
while (($row = mysqli_fetch_array($query)) !== null) {
  $grades[] = $row;
}

?>

<main clas="gradesContainer">
  <div class="gradesPanel">
    <div class="gradesTabs">
      <h2 class="tabHeader active">Oceny częściowe</h2>
      <h2 class="tabHeader">Oceny szczgółowo</h2>
      <h2 class="tabHeader">Podsumowanie Ocen</h2>
      <div class="activeBar"></div>
    </div>
    <div class="gradesList">
      <div class="gradeItem">
        <h2>Przedmiot</h2>
        <h2>Ocena</h2>
        <h2>Kategoria</h2>
        <h2>Data</h2>
      </div>
      <?php
      foreach ($grades as $grade)
        echo <<<HTML
        <div class="gradeItem">
          <h4>{$grade['subject_id']}</h4>
          <h3>{$grade['grade']}</h3>
          <p>{$grade['category_id']}</p>
          <p>{$grade['date']}</p>
        </div>
        HTML;
      ?>
    </div>
    <div class="detailedGradesList">
      <div class="subjectItem">
        <h2>Język Polski</h2>
        <div class="detailedGradeItem">
          <div class="grade">
            <p>Ocena</p>
            <p>5</p>
          </div>
          <div class="description">
            <p>Opis</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque, ad quod nobis cum rem eaque repudiandae, iste provident alias architecto consectetur natus eligendi maiores commodi assumenda, laborum quae non exercitationem.</p>
          </div>
          <div class="category">
            <p>Kategoria (waga)</p>
            <p>Praca klasowa (3)</p>
          </div>
          <div class="created">
            <p>Wystawiona</p>
            <p>Fajny Nauczyciel, 08.03.2021</p>
          </div>
        </div>
        <div class="detailedGradeItem">
          <div class="grade">
            <p>Ocena</p>
            <p>5</p>
          </div>
          <div class="description">
            <p>Opis</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque, ad quod nobis cum rem eaque repudiandae, iste provident alias architecto consectetur natus eligendi maiores commodi assumenda, laborum quae non exercitationem.</p>
          </div>
          <div class="category">
            <p>Kategoria (waga)</p>
            <p>Praca klasowa (3)</p>
          </div>
          <div class="created">
            <p>Wystawiona</p>
            <p>Fajny Nauczyciel, 08.03.2021</p>
          </div>
        </div>
      </div>
      <div class="subjectItem">
        <h2>Matematyka</h2>
        <div class="detailedGradeItem">
          <div class="grade">
            <p>Ocena</p>
            <p>5</p>
          </div>
          <div class="description">
            <p>Opis</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque, ad quod nobis cum rem eaque repudiandae, iste provident alias architecto consectetur natus eligendi maiores commodi assumenda, laborum quae non exercitationem.</p>
          </div>
          <div class="category">
            <p>Kategoria (waga)</p>
            <p>Praca klasowa (3)</p>
          </div>
          <div class="created">
            <p>Wystawiona</p>
            <p>Fajny Nauczyciel, 08.03.2021</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>