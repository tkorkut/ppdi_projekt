<?php

$host = 'localhost';

$user = 'root';

$pass = '';

$baza = 'filmoteka';


$veza = new mysqli($host, $user, $pass, $baza);

if ($veza->connect_error) {
  die('Greška pri spajanju na bazu: ' . $veza->connect_error
    . '<br>Provjeri je li MySQL pokrenut i je li uvezena datoteka filmoteka.sql.');

    
}
$veza->set_charset('utf8mb4');
