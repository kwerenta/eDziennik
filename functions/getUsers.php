<?php
require '../functions/isLoggedIn.php';
function getUsers($amount = 0)
{
  require_once '../db.php';
  $conn = connectToDB();

  $limit = $amount > 0 ? "ORDER BY `id` DESC LIMIT {$amount}" : "";

  $sql = "SELECT `id`,`email`,`isActivated`,`rank` FROM users LEFT JOIN ranks ON users.`id`=ranks.`user_id` {$limit}";
  $query = mysqli_query($conn, $sql);
  while (($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) !== null) {
    $users[$row['id']] = $row;
  }

  // $limit = $amount > 0 ? "ORDER BY `user_id` DESC LIMIT {$amount}" : "";

  // $sql = "(SELECT `user_id`,`first_name`,`last_name`,`class` lastField FROM students) {$limit}
  // UNION ALL 
  // (SELECT `user_id`,`first_name`,`last_name`,`phone` lastField FROM teachers) {$limit}
  // UNION ALL 
  // (SELECT `user_id`,`first_name`,`last_name`,`phone` lastField FROM admins) {$limit}
  // {$limit}
  // ";

  foreach ($users as $index => $user) {
    switch ($user['rank']) {
      case '1':
        $rank['displayName'] = "Administrator";
        $rank['name'] = "admin";
        break;
      case '2':
        $rank['displayName'] = "Nauczyciel";
        $rank['name'] = "teacher";
        break;
      default:
        $rank['displayName'] = "Uczeń";
        $rank['name'] = "student";
    }
    $lastField = $rank['name'] === "student" ? "class" : "phone";
    $sql = "SELECT `first_name`,`last_name`, `id`, `{$lastField}` FROM {$rank['name']}s WHERE `user_id` = {$user['id']}";
    $query = mysqli_query($conn, $sql);
    $personalData = mysqli_fetch_array($query);

    $users[$index]['rank'] = $rank['displayName'];
    $users[$index]['first_name'] = $personalData['first_name'];
    $users[$index]['last_name'] = $personalData['last_name'];
    $users[$index]['type_id'] = $personalData['id'];
    $users[$index]['last_field'] = $personalData[$lastField];
  }
  if ($amount === 0) {
    $filter['students'] = array_filter($users, fn ($user) => $user['rank'] === "Uczeń");
    $filter['teachers'] = array_filter($users, fn ($user) => $user['rank'] === "Nauczyciel");
    $filter['admins'] = array_filter($users, fn ($user) => $user['rank'] === "Administrator");
    return $filter;
  }
  return $users;
}
