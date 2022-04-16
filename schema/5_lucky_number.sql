INSERT INTO lucky_number VALUES 
(FLOOR(RAND()*(SELECT COUNT(1) amount FROM students GROUP BY `class` ORDER BY amount DESC LIMIT 1)+1));

-- Nie mam pewności czy event stworzy się poprawnie w dockerze
CREATE EVENT `lucky_number` 
  ON SCHEDULE EVERY 1 DAY STARTS '2021-03-28 00:00:00'
  DO 
  UPDATE lucky_number SET `value` = FLOOR(RAND()*(SELECT COUNT(1) amount FROM students GROUP BY `class` ORDER BY amount DESC LIMIT 1)+1);