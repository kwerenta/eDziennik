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

  foreach (["admins", "teachers", "students"] as $rank) {
    $displayRank = $rank === "admins" ? "Administrator" : ($rank === "teachers" ? "Nauczyciel" : "Uczeń");
    $lastField = $rank === "students" ? "class" : "phone";

    $sql = "SELECT `first_name`, `last_name`, `id`,`user_id`, `{$lastField}` FROM {$rank} {$limit}";
    $query = mysqli_query($conn, $sql);
    while (($row = mysqli_fetch_array($query)) !== null) {
      if ($users[$row['user_id']]) {
        $users[$row['user_id']]['rank'] = $displayRank;
        $users[$row['user_id']]['first_name'] = $row['first_name'];
        $users[$row['user_id']]['last_name'] = $row['last_name'];
        $users[$row['user_id']]['type_id'] = $row['id'];
        $users[$row['user_id']]['last_field'] = $row[$lastField];
      }
    }
  }

  if ($amount === 0) {
    $filter['students'] = array_filter($users, fn ($user) => $user['rank'] === "Uczeń");
    $filter['teachers'] = array_filter($users, fn ($user) => $user['rank'] === "Nauczyciel");
    $filter['admins'] = array_filter($users, fn ($user) => $user['rank'] === "Administrator");
    return $filter;
  }
  return $users;
}
