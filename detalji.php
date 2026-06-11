<?php
require_once 'inc/funkcije.php';
require_once 'inc/omdb.php';
$naslov = 'Detalji';
include 'inc/zaglavlje.php';

$id = $_GET['id'] ?? '';
$film = $id !== '' ? omdb_detalji_xml($id) : null;
?>

  <p><a href="javascript:history.back()">&laquo; Natrag</a></p>

  <?php if (!$film): ?>
    <p>Detalji nisu dostupni<?php echo !ima_api_kljuc() ? ' (potreban je OMDB API ključ).' : '.'; ?></p>
  <?php else: ?>
    <div class="film">
      <?php if ((string)$film['poster'] && (string)$film['poster'] !== 'N/A'): ?>
        <img src="<?php echo h($film['poster']); ?>" alt="<?php echo h($film['title']); ?>" style="width:200px">
      <?php endif; ?>
      <h1><?php echo h($film['title']); ?> (<?php echo h($film['year']); ?>)</h1>
      <p class="meta">
        <?php echo h($film['genre']); ?> · <?php echo h($film['runtime']); ?> ·
        IMDb: <?php echo h($film['imdbRating']); ?>/10
      </p>
      <hr>
      <p><strong>Radnja:</strong> <?php echo h($film['plot']); ?></p>
      <p><strong>Redatelj/ica:</strong> <?php echo h($film['director']); ?></p>
      <p><strong>Glumci:</strong> <?php echo h($film['actors']); ?></p>
      <p><strong>Jezik:</strong> <?php echo h($film['language']); ?></p>
    </div>
  <?php endif; ?>

<?php include 'inc/podnozje.php'; ?>
