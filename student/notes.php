<?php
session_start();
require '../functions/isLoggedIn.php';
require '../view.php';
$header = new View('header');
$header->allocate('styles', ['navbar', 'studentNotes']);
$header->allocate('scripts', ['clock']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

require '../db.php';
$conn = connectToDB();

$sql = "SELECT * FROM students WHERE `id` = {$_SESSION['user']['id']}";
$query = mysqli_query($conn, $sql);
