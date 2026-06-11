<?php
require_once 'inc/funkcije.php';
$poruka_html = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $ime = trim($_POST['ime'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $tema = $_POST['tema'] ?? '';
  $tekst = trim($_POST['poruka'] ?? '');

  if ($ime === '' || $email === '' || $tekst === '') {
    $poruka_html = '<div class="poruka greska">Ispuni ime, e-mail i poruku.</div>';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $poruka_html = '<div class="poruka greska">Unesi ispravan e-mail.</div>';
  } elseif (strlen($tekst) < 10) {
    $poruka_html = '<div class="poruka greska">Poruka je prekratka (min. 10 znakova).</div>';
  } else {
    spremi_poruku($ime, $email, $tema, $tekst);
    $poruka_html = '<div class="poruka uspjeh">Hvala, ' . h($ime) . '! Poruka je zaprimljena.</div>';
    $_POST = [];
  }
}

$naslov = 'Kontakt';
include 'inc/zaglavlje.php';
?>

  <h1>Kontakt</h1>
  <img src="img/contact_us.jpg" alt="phone booth poster" class="kontakt-slika">
  <p>Pitanja, prijedlozi ili greška u aplikaciji? Pošalji nam poruku.</p>

  <?php echo $poruka_html; ?>

  <form method="post" action="kontakt.php" id="contact">
    <label for="ime">Ime i prezime</label>
    <input type="text" id="ime" name="ime" value="<?php echo h($_POST['ime'] ?? ''); ?>" required>

    <label for="email">E-mail</label>
    <input type="email" id="email" name="email" value="<?php echo h($_POST['email'] ?? ''); ?>" required>

    <label for="tema">Tema</label>
    <select id="tema" name="tema">
      <option>Opće pitanje</option>
      <option>Prijava greške</option>
      <option>Prijedlog</option>
    </select>

    <label for="poruka">Poruka</label>
    <textarea id="poruka" name="poruka" rows="6" required></textarea>

    <input type="submit" value="Pošalji poruku">
  </form>

<?php include 'inc/podnozje.php'; ?>
