<?php
require_once 'inc/funkcije.php';
$greska = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $ime = trim($_POST['ime'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $lozinka = $_POST['lozinka'] ?? '';
  $lozinka2 = $_POST['lozinka2'] ?? '';

  if ($ime === '' || $email === '' || $lozinka === '') {
    $greska = 'Ispuni sva polja.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $greska = 'Unesi ispravan e-mail.';
  } elseif (strlen($lozinka) < 6) {
    $greska = 'Lozinka mora imati barem 6 znakova.';
  } elseif ($lozinka !== $lozinka2) {
    $greska = 'Lozinke se ne podudaraju.';
  } else {
    $rez = registriraj($ime, $email, $lozinka);
    if ($rez === true) { header('Location: liste.php'); exit; }
    $greska = $rez;
  }
}

$naslov = 'Registracija';
include 'inc/zaglavlje.php';
?>

  <h1>Registracija</h1>

  <?php if ($greska): ?>
    <div class="poruka greska"><?php echo h($greska); ?></div>
  <?php endif; ?>

  <form method="post" action="registracija.php" id="contact">
    <label for="ime">Ime</label>
    <input type="text" id="ime" name="ime" value="<?php echo h($_POST['ime'] ?? ''); ?>" required>

    <label for="email">E-mail</label>
    <input type="email" id="email" name="email" value="<?php echo h($_POST['email'] ?? ''); ?>" required>

    <label for="lozinka">Lozinka (min. 6 znakova)</label>
    <input type="password" id="lozinka" name="lozinka" required>

    <label for="lozinka2">Ponovi lozinku</label>
    <input type="password" id="lozinka2" name="lozinka2" required>

    <input type="submit" value="Registriraj se">
  </form>

  <p>Već imaš račun? <a href="prijava.php">Prijavi se</a>.</p>

<?php include 'inc/podnozje.php'; ?>
