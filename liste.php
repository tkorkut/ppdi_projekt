<?php
require_once 'inc/funkcije.php';

if (!prijavljen()) {
  header('Location: prijava.php');
  exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $imdb_id = $_POST['imdbID'] ?? '';
  if (($_POST['akcija'] ?? '') === 'ukloni') {
    ukloni_iz_liste($imdb_id);
  } elseif (($_POST['akcija'] ?? '') === 'premjesti') {
    premjesti_u($imdb_id, $_POST['cilj'] ?? 'zelim');
  }
  header('Location: liste.php');
  exit;
}

$naslov = 'Moje liste';
include 'inc/zaglavlje.php';

$gledano = dohvati_listu('gledano');
$zelim   = dohvati_listu('zelim');

function ispisi_listu($stavke, $lista) {
  if (!$stavke) {
    echo '<p>Lista je prazna. Dodaj filmove na <a href="pretraga.php">pretrazi</a>.</p>';
    return;
  }
  $cilj = $lista === 'gledano' ? 'zelim' : 'gledano';
  $oznaka = $lista === 'gledano' ? 'u Želim gledati' : 'u Pogledano';
  foreach ($stavke as $f) {
    echo '<div class="film">';
    if ($f['poster'] && $f['poster'] !== 'N/A') {
      echo '<img src="' . h($f['poster']) . '" alt="' . h($f['naslov']) . '">';
    }
    echo '<h2>' . h($f['naslov']) . '</h2>';
    echo '<p class="meta">' . h($f['godina']) . ' · ' . ($f['tip'] === 'series' ? 'Serija' : 'Film') . '</p>';
    echo '<form method="post" action="liste.php" style="margin:0">';
    echo '<input type="hidden" name="imdbID" value="' . h($f['imdb_id']) . '">';
    echo '<input type="hidden" name="cilj" value="' . $cilj . '">';
    echo '<button type="submit" name="akcija" value="premjesti" class="botun sivi">Premjesti ' . $oznaka . '</button>';
    echo '<button type="submit" name="akcija" value="ukloni" class="botun crveni">Ukloni</button>';
    echo '</form><hr>';
  }
}
?>

  <h1>Moje liste</h1>

  <h2>Pogledano (<?php echo count($gledano); ?>)</h2>
  <div class="rezultati"><?php ispisi_listu($gledano, 'gledano'); ?></div>

  <h2>Želim gledati (<?php echo count($zelim); ?>)</h2>
  <div class="rezultati"><?php ispisi_listu($zelim, 'zelim'); ?></div>

<?php include 'inc/podnozje.php'; ?>
