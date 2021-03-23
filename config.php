<?php

/*
 * Przed Tobą konfiguracja bazy danych. Odbywa się ona przez wykorzystanie
 * definicji stałych. Zostaw pobieranie danych ze zmiennych środowiskowych
 * ($_ENV) i modyfikuj dowolnie to co jest za null coalescing operator, czyli
 * stringa z danymi do Twojej bazy danych.
 *
 * Pamiętaj, żeby niniejszy plik załączyć przed wywołaniem podłączenia do bazy.
 *
 * Przykładowe połączenie z bazą będzie wyglądało następująco:
 *   $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_SCHEMA);
 */
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_USER', $_ENV['DB_USER'] ?? 'dziennik');
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '123'); // Tu zmień hasło jeżeli nie jest puste
define('DB_SCHEMA', $_ENV['DB_SCHEMA'] ?? 'gradebook'); // Tu podaj nazwę bazy danych

define('GSAP', "https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js");

/*
 * Jeżeli chcesz zdefiniować inne ustawienia, zrób to pod poniższym komentarzem
 */