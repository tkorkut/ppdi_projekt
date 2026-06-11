<?php
require_once 'inc/funkcije.php';
require_once 'inc/omdb.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lista'])) {
  if (!prijavljen()) {
    $_SESSION['flash'] = ['greska', 'Prijavi se da bi spremao filmove.'];
  } else {
    $film = [
      'imdbID' => $_POST['imdbID'] ?? '',
      'Title'  => $_POST['Title'] ?? '',
      'Year'   => $_POST['Year'] ?? '',
      'Type'   => $_POST['Type'] ?? '',
      'Poster' => $_POST['Poster'] ?? '',
    ];
    $lista = $_POST['lista'] === 'gledano' ? 'gledano' : 'zelim';
    dodaj_u_listu($lista, $film);
    $oznaka = $lista === 'gledano' ? 'Pogledano' : 'Želim gledati';
    $_SESSION['flash'] = ['uspjeh', '„' . $film['Title'] . '" dodano u ' . $oznaka . '.'];
  }
  header('Location: pretraga.php?s=' . urlencode($_POST['s'] ?? ''));
  exit;
}

$naslov = 'Pretraga';
include 'inc/zaglavlje.php';

$upit = trim($_GET['s'] ?? '');
$tip  = $_GET['tip'] ?? '';
$rezultati = $upit !== '' ? omdb_pretraga($upit, $tip) : null;
?>

  <h1>Pretraga filmova i serija</h1>

 <img src="img/searching.jpg" alt="Indy gleda idola" class="pretraga-slika">

  <?php if (isset($_SESSION['flash'])): ?>
    <div class="poruka <?php echo $_SESSION['flash'][0]; ?>"><?php echo h($_SESSION['flash'][1]); ?></div>
    <?php unset($_SESSION['flash']); ?>
  <?php endif; ?>

  <?php if (!ima_api_kljuc()): ?>
    <div class="poruka greska">
      Za pretragu je potreban besplatni OMDB ključ s
      <a href="https://www.omdbapi.com/apikey.aspx" target="_blank">omdbapi.com</a>.
      Upiši ga u <strong>inc/omdb.php</strong> umjesto <em>YOUR_API_KEY</em>.
    </div>
  <?php endif; ?>

  <form method="get" action="pretraga.php">
    <label for="s">Naziv filma ili serije</label>
    <input type="search" id="s" name="s" value="<?php echo h($upit); ?>" placeholder="npr. The Matrix, Friends, Dune">
    <label for="tip">Tip</label>
    <select id="tip" name="tip">
      <option value="">Sve</option>
      <option value="movie"  <?php echo $tip === 'movie' ? 'selected' : ''; ?>>Filmovi</option>
      <option value="series" <?php echo $tip === 'series' ? 'selected' : ''; ?>>Serije</option>
    </select>
    <input type="submit" value="Traži">
  </form>

<div style="clear: both"></div>

  <?php if ($upit !== '' && !$rezultati && ima_api_kljuc()): ?>
    <p>Nema rezultata za „<?php echo h($upit); ?>".</p>
  <?php endif; ?>

  <?php if ($rezultati): ?>
    <h2>Rezultati</h2>
    <div class="rezultati">
      <?php foreach ($rezultati as $f): ?>
        <div class="film">
          <?php if ($f['Poster'] !== 'N/A'): ?>
            <img src="<?php echo h($f['Poster']); ?>" alt="<?php echo h($f['Title']); ?>">
          <?php endif; ?>
          <h2><a href="detalji.php?id=<?php echo h($f['imdbID']); ?>"><?php echo h($f['Title']); ?></a></h2>
          <p class="meta"><?php echo h($f['Year']); ?> · <?php echo $f['Type'] === 'series' ? 'Serija' : 'Film'; ?></p>
          <form method="post" action="pretraga.php" style="margin:0">
            <input type="hidden" name="imdbID" value="<?php echo h($f['imdbID']); ?>">
            <input type="hidden" name="Title"  value="<?php echo h($f['Title']); ?>">
            <input type="hidden" name="Year"   value="<?php echo h($f['Year']); ?>">
            <input type="hidden" name="Type"   value="<?php echo h($f['Type']); ?>">
            <input type="hidden" name="Poster" value="<?php echo h($f['Poster']); ?>">
            <input type="hidden" name="s"      value="<?php echo h($upit); ?>">
            <button type="submit" name="lista" value="gledano" class="botun">Pogledano</button>
            <button type="submit" name="lista" value="zelim" class="botun sivi">Želim gledati</button>
            <a href="detalji.php?id=<?php echo h($f['imdbID']); ?>" class="botun crveni">Detalji</a>
          </form>
          <hr>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

<?php include 'inc/podnozje.php'; ?>
