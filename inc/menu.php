<?php



$aktivna = basename($_SERVER['PHP_SELF']);
function akt($s) { global $aktivna; return $aktivna === $s ? 'aktivno' : ''; }
?>

<ul class="nav">
  <li><a href="index.php" class="<?php echo akt('index.php'); ?>">Naslovna</a></li>

  <li><a href="pretraga.php" class="<?php echo akt('pretraga.php'); ?>">Pretraga</a></li>
  <li><a href="liste.php" class="<?php echo akt('liste.php'); ?>">Moje liste</a></li>
  <li><a href="kontakt.php" class="<?php echo akt('kontakt.php'); ?>">Kontakt</a></li>
  <?php if (je_admin()): ?>
    <li><a href="admin.php" class="<?php echo akt('admin.php'); ?>">Admin</a></li>
  <?php endif; ?>


  
  <?php if (prijavljen()): ?>
    <li class="desno"><a href="odjava.php">Odjava (<?php echo h(trenutni_korisnik()['ime']); ?>)</a></li>
  <?php else: ?>
    <li class="desno"><a href="registracija.php" class="<?php echo akt('registracija.php'); ?>">Registracija</a></li>
    <li class="desno"><a href="prijava.php" class="<?php echo akt('prijava.php'); ?>">Prijava</a></li>
  <?php endif; ?>
</ul>
