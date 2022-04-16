<?php
$usersValues = [];
$teachersValues = [];
$studentsValues = [];
$ranksValues = [];
$gradesValues = [];
$notesValues = [];

$teachersCount = 1;
$studentsCount = 1;

$teachersId = [];
$studentsId = [];

$descriptions = ["Lorem ipsum dolor sit amet", "Proin vel lobortis ipsum", "Pellentesque vel ex scelerisque", "Donec maximus lectus sed ex gravida eleifend", "Donec a erat quis nibh faucibus rutrum"];

$JSONNames = file_get_contents('names.json');
$names = json_decode($JSONNames, true);

$password = password_hash('123', PASSWORD_BCRYPT);

$classArray = [];
$letters = ['A', 'B', 'C', 'D'];
$numbers = ['1', '2', '3', '4'];
foreach ($numbers as $number) {
  foreach ($letters as $letter) {
    $classArray[] = $number . $letter;
  }
}

function polishCharacters($text)
{
  $new = strtolower($text);
  $new = str_replace(" ", "-", $new);
  $new = str_replace(array('ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż'), array('a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z'), $new);
  return $new;
}

foreach ($names as $index => $name) {
  $id = $index + 1;
  $email = strtolower(polishCharacters($name['first_name'][0]) . polishCharacters($name['last_name'])) . "@test.pl";
  $rand = rand(1, 51);
  $isActivated = ($rand % 4) ? 1 : 0;
  $usersValues[] = "($id,\"$email\",\"$password\",$isActivated)";

  $rand =  rand(1, 5);
  if ($rand % 2 && $teachersCount < 19) {
    $phone = "";
    for ($i = 1; $i < 10; $i++) {
      $phone .= rand(0, 9);
    }
    $teachersId[] = $teachersCount;

    $teachersValues[] = "($teachersCount,$id,\"{$name['first_name']}\",\"{$name['last_name']}\",\"$phone\")";
    $ranksValues[] = "($id,2)";
    $teachersCount++;
  } else {
    do {
      $repeat = false;
      $class = $classArray[rand(0, (count($classArray) - 1))];
      $studentsId[$class][] = $studentsCount;
      if (count($studentsId[$class]) > 14) {
        $repeat = true;
        array_pop($studentsId[$class]);
      }
    } while ($repeat);

    $studentsValues[] = "($studentsCount,$id,\"{$name['first_name']}\",\"{$name['last_name']}\",\"$class\")";
    $studentsCount++;
  }
}
foreach ($teachersId as $teacher) {
  foreach ($classArray as $class) {
    foreach ($studentsId[$class] as $student) {
      $rand = rand(0, 8);
      foreach (range(1, $rand) as $number) {
        $grade = rand(1, 6);
        $category = rand(1, 7);
        $description = "";
        if (rand(1, 2) % 2) {
          $description = "{$descriptions[rand(0, count($descriptions) - 1)]}";
        }
        $gradesValues[] = "($student, $teacher, $teacher, $category,$grade,\"$description\",NOW() - INTERVAL FLOOR(RAND() * 150) DAY - INTERVAL FLOOR(RAND() * 540) MINUTE)";
      }
      if (!(rand(1, 10) % 3)) {
        $rand = rand(0, 2);
        foreach (range(1, $rand) as $number) {
          $points = rand(-150, 150);
          $description = "";
          if (rand(1, 2) % 2) {
            $description = "{$descriptions[rand(0, count($descriptions) - 1)]}";
          }
          $notesValues[] = "($student, $teacher, $points,\"$description\",NOW() - INTERVAL FLOOR(RAND() * 150) DAY - INTERVAL FLOOR(RAND() * 540) MINUTE)";
        }
      }
    }
  }
}

$usersSql = "INSERT INTO users VALUES " . implode(',', $usersValues);
$teachersSql = "INSERT INTO teachers VALUES " . implode(',', $teachersValues);
$studentsSql = "INSERT INTO students VALUES " . implode(',', $studentsValues);
$ranksSql = "INSERT INTO ranks VALUES " . implode(',', $ranksValues);
$gradesSql = "INSERT INTO grades(`student_id`,`teacher_id`,`subject_id`,`category_id`,`grade`,`description`,`date`) VALUES " . implode(',', $gradesValues);
$notesSql = "INSERT INTO notes(`student_id`,`teacher_id`,`points`,`description`,`date`) VALUES " . implode(',', $notesValues);

// die(var_dump($usersSql));
// die(var_dump($teachersSql));
// die(var_dump($studentsSql));
// die(var_dump($ranksSql));
// die(var_dump($notesSql));
// die(var_dump($gradesSql));
// die(var_dump($usersSql, $teachersSql, $studentsSql, $ranksSql, $gradesSql));

// $var_str = var_export($usersSql, true);
// file_put_contents('users.sql', $var_str);

// $var_str = var_export($teachersSql, true);
// file_put_contents('teachers.sql', $var_str);

// $var_str = var_export($studentsSql, true);
// file_put_contents('students.sql', $var_str);

// $var_str = var_export($ranksSql, true);
// file_put_contents('ranks.sql', $var_str);

// $var_str = var_export($notesSql, true);
// file_put_contents('notes.sql', $var_str);

// $var_str = var_export($gradesSql, true);
// file_put_contents('grades.sql', $var_str);

// require 'db.php';
// $conn = connectToDB();

//mysqli_query($conn, $usersSql);
//mysqli_query($conn, $teachersSql);
//mysqli_query($conn, $studentsSql);
//mysqli_query($conn, $ranksSql);

// die(var_dump($query));
