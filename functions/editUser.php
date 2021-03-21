<?php
require '../functions/isLoggedIn.php';
require "../db.php";
$conn = connectToDB();

die("też działa");


header("Location: http://{$_SERVER['HTTP_HOST']}/admin/users.php");
