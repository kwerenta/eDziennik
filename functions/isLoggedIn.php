<?php
if (!isset($_SESSION["user"]) || $_SESSION["user"]['rank'] !== 'student') {
  header('Location: /' . $_SESSION["user"]['rank']);
}
