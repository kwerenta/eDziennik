-- Wszyscy użytkownicy mają hasło 123
CREATE TABLE users (
  `id` int UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  `isActivated` bool DEFAULT false
);

CREATE TABLE admins (
  `id` int UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` char(9),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);


CREATE TABLE teachers (
  `id` int UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` char(9),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE students (
  `id` int UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `class` char(2) NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE ranks (
  `user_id` int UNSIGNED,
  `rank` tinyint,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE subjects (
  `id` int UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `shortcut` varchar(16) NOT NULL
);

CREATE TABLE categories (
  `id` smallint UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `weight` tinyint NOT NULL
);


CREATE TABLE notes (
  `id` int UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `student_id` int UNSIGNED NOT NULL,
  `teacher_id` int UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `description` text,
  `points` smallint,
  FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`)
);

CREATE TABLE grades (
  `id` int UNSIGNED  PRIMARY KEY AUTO_INCREMENT,
  `student_id` int UNSIGNED NOT NULL,
  `teacher_id` int UNSIGNED NOT NULL,
  `subject_id` int UNSIGNED NOT NULL,
  `category_id` smallint UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `description` text,
  `grade` tinyint NOT NULL,
  FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`),
  FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
);

CREATE TABLE timetables (
  `class_id` char(2) NOT NULL,
  `weekday` tinyint NOT NULL CHECK (`weekday` BETWEEN 1 AND 5),
  `timetable` json NOT NULL
);

CREATE TABLE lucky_number (
  `value` TINYINT UNSIGNED NOT NULL
);