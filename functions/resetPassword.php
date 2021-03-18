<?php
require "../db.php";
$conn = connectToDB();

header("Location: http://{$_SERVER['HTTP_HOST']}/");
