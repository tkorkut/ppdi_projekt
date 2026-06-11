<?php
require_once 'inc/funkcije.php';
$greska = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? '';
  $lozinka = $_POST['lozinka'] ?? '';
  if ($email === '' || $lozinka === '') {
    $greska = 'Ispuni sva polja.';
  } else {
    $rez = prijavi($email, $lozinka);
    if ($rez === true) { header('Location: liste.php'); exit; }
    $greska = $rez;
  }
}

$naslov = 'Prijava';
include 'inc/zaglavlje.php';
?>

  <h1>Prijava</h1>

  <?php if ($greska): ?>
    <div class="poruka greska"><?php echo h($greska); ?></div>
  <?php endif; ?>

  <form method="post" action="prijava.php" id="contact">
    <label for="email">E-mail</label>
    <input type="email" id="email" name="email" required>

    <label for="lozinka">Lozinka</label>
    <input type="password" id="lozinka" name="lozinka" required>

    <input type="submit" value="Prijavi se">
  </form>

  <p>Nemaš račun? <a href="registracija.php">Registriraj se</a>.</p>

<?php include 'inc/podnozje.php'; ?>
