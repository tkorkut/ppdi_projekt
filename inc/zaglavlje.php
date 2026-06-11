<?php

if (!isset($naslov)) $naslov = 'Filmoteka';
if (!isset($velik_hero)) $velik_hero = false;
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo h($naslov); ?> — Filmoteka</title>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
        <div class="hero-image">
      <div class="hero-tekst">
        <h1>VOLIM FILM!</h1>
        <p>Prati filmove i serije koje si gledao i koje želiš gledati</p>
      </div>
    </div>
    <?php include __DIR__ . '/menu.php'; ?>
  </header>

  <main>
