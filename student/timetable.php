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

$sql = "SELECT `timetable`,`weekday` FROM timetables WHERE `class_id`='{$_SESSION['user']['class']}' ORDER BY `weekday`";
$query = mysqli_query($conn, $sql);
while (($row = mysqli_fetch_array($query)) !== null) {
  foreach (json_decode($row[0]) as $index => $lessons) {
    $timetable[$index][json_decode($row['weekday'])] = $lessons;
  }
}
?>

<main>
  <div class="studentContainer studentContainer--timetable">
    <h1 class="timetable__title">Class <?php echo $_SESSION['user']['class'] ?> Timetable</h1>
    <table class="timetable__table">
      <tr class="timetable__row">
        <th>No.</th>
        <th>Monday</th>
        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Saturday</th>
        <th>Friday</th>
      </tr>
      <?php
      foreach ($timetable as $index => $lessons) {
        $nr = $index + 1;
        echo <<<HTML
        <tr class="timetable__row">
        <td>{$nr}</td>
        HTML;
        foreach (range(1, 5) as $weekday) {
          echo isset($lessons[$weekday]) && $lessons[$weekday] !== 0 ? "<td>{$_SESSION['subjects'][$lessons[$weekday]]['shortcut']}</td>" : "<td></td>";
        }
        echo "</tr>";
      }
      ?>
    </table>
  </div>
</main>