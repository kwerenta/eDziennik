<?php
session_start();
require '../functions/isLoggedIn.php';
require_once '../db.php';
require '../functions/getUsers.php';
require '../view.php';
$header = new View('header');
$header->allocate('scripts', ['clock']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

$conn = connectToDB();

$countNames = ['users', 'grades', 'notes'];

foreach ($countNames as $name) {
  $sql = "SELECT COUNT(1) FROM {$name}";
  $query = mysqli_query($conn, $sql);
  $count[$name] = mysqli_fetch_array($query)[0];
}
$latestUsers = getUsers(7);
?>
<main class="adminDashboard">
  <div class="adminDashboard__panel adminDashboard__panel--top">
    <div class="adminDashboard__tile">
      <h2>Number of users</h2>
      <h1><?php echo $count['users'] ?></h1>
    </div>
    <div class="adminDashboard__tile">
      <h2>Number of grades</h2>
      <h1><?php echo $count['grades'] ?></h1>
    </div>
    <div class="adminDashboard__tile">
      <h2>Number of notes</h2>
      <h1><?php echo $count['notes'] ?></h1>
    </div>
  </div>
  <div class="adminDashboard__panel adminDashboard__panel--bottom">
    <h2>Latest users</h2>
    <div class="adminDashboard__latestUsersItem">
      <h2>E-Mail</h2>
      <h2>First Name</h2>
      <h2>Last Name</h2>
      <h2>Rank</h2>
    </div>
    <?php
    foreach ($latestUsers as $user) {
      echo <<<HTML
          <div class="adminDashboard__latestUsersItem">
            <h3>{$user['email']}</h3>
            <p>{$user['first_name']}</p>
            <p>{$user['last_name']}</p>
            <h4>{$user['rank']}</h4>
          </div>
          HTML;
    }
    ?>
  </div>
</main>