<?php
require_once 'inc/funkcije.php';
$naslov = 'Naslovna';
$velik_hero = true;
include 'inc/zaglavlje.php';

$preporuke = @simplexml_load_file(__DIR__ . '/data/preporuke.xml');
?>

  <h1>Dobrodošli</h1>
  <p>
    Moj projekt je aplikacija u kojoj pretražuješ filmove i serije preko OMDB
    API-ja te ih spremaš na svoje liste: <strong>Pogledano</strong> i
    <strong>Želim gledati</strong>. Kreni na <a href="pretraga.php">pretragu</a>
    ili <a href="registracija.php">otvori račun</a>.
  </p>

  <h2>Naše preporuke za vas</h2>
  <div class="rezultati">
    <?php if ($preporuke === false): ?>
      <p>Preporuke trenutno nisu dostupne.</p>
    <?php else: foreach ($preporuke->film as $film): ?>
      <div class="film">
        <?php if ((string)$film->poster && (string)$film->poster !== 'N/A'): ?>
          <img src="<?php echo h($film->poster); ?>" alt="<?php echo h($film->naslov); ?>">
        <?php endif; ?>
        <h2><?php echo h($film->naslov); ?></h2>
        <p class="meta">
          <?php echo h($film->godina); ?> ·
          <?php echo h($film->zanr); ?> ·
          <?php echo (string)$film->tip === 'series' ? 'Serija' : 'Film'; ?>
        </p>
        <hr>
      </div>
    <?php endforeach; endif; ?>
  </div>

<?php include 'inc/podnozje.php'; ?>
