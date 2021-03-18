<?php
function getUsers($amount = 0)
{
  require_once '../db.php';
  $conn = connectToDB();

  if ($amount > 0) $amount = "ORDER BY `id` DESC LIMIT {$amount}";
  else $amount = "";

  $sql = "SELECT `id`,`email` FROM users {$amount}";
  $query = mysqli_query($conn, $sql);
  while (($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) !== null) {
    $users[] = $row;
  }
  foreach ($users as $index => $user) {
    $sql = "SELECT `rank` FROM ranks WHERE `user_id` = {$user['id']}";
    $query = mysqli_query($conn, $sql);
    $rank = mysqli_fetch_array($query);
    if (isset($rank['rank'])) {
      switch ($rank['rank']) {
        case '1':
          $rank['displayName'] = "Administrator";
          $rank['name'] = "admin";
          break;
        case '2':
          $rank['displayName'] = "Nauczyciel";
          $rank['name'] = "teacher";
          break;
      }
    } else {
      $rank['displayName'] = "Uczeń";
      $rank['name'] = "student";
    }
    $sql = "SELECT `first_name`,`last_name`, `id` FROM {$rank['name']}s WHERE `user_id` = {$user['id']}";
    $query = mysqli_query($conn, $sql);
    $personalData = mysqli_fetch_array($query);

    $users[$index]['rank'] = $rank['displayName'];
    $users[$index]['first_name'] = $personalData['first_name'];
    $users[$index]['last_name'] = $personalData['last_name'];
    $users[$index]['type_id'] = $personalData['id'];
  }
  if ($amount === '') {
    $filter['students'] = array_filter($users, fn ($user) => $user['rank'] === "Uczeń");
    $filter['teachers'] = array_filter($users, fn ($user) => $user['rank'] === "Nauczyciel");
    $filter['admins'] = array_filter($users, fn ($user) => $user['rank'] === "Administrator");
    return $filter;
  }
  return $users;
}
