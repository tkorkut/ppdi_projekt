<?php
require_once 'inc/funkcije.php';


if (!je_admin()) {
  $naslov = 'Admin';
  include 'inc/zaglavlje.php';
  echo '<h1>Administracija</h1><p>Nemaš pristup ovoj stranici. Prijavi se kao administrator.</p>';
  include 'inc/podnozje.php';
  exit;
}

$naslov = 'Admin';
include 'inc/zaglavlje.php';
$poruke = dohvati_poruke();
$korisnici = dohvati_sve_korisnike();
?>

  <h1>Administracija</h1>

  <h2>Poruke iz kontakt forme (<?php echo count($poruke); ?>)</h2>
  <?php if (!$poruke): ?>
    <p>Nema poruka.</p>
  <?php else: ?>
    <table>
      <tr><th>Vrijeme</th><th>Ime</th><th>E-mail</th><th>Tema</th><th>Poruka</th></tr>
      <?php foreach ($poruke as $p): ?>
        <tr>
          <td><?php echo h($p['vrijeme']); ?></td>
          <td><?php echo h($p['ime']); ?></td>
          <td><?php echo h($p['email']); ?></td>
          <td><?php echo h($p['tema']); ?></td>
          <td><?php echo h($p['poruka']); ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>

  <h2>Registrirani korisnici (<?php echo count($korisnici); ?>)</h2>
  <table>
    <tr><th>ID</th><th>Ime</th><th>E-mail</th><th>Admin</th><th>Kreiran</th></tr>
    <?php foreach ($korisnici as $k): ?>
      <tr>
        <td><?php echo h($k['id']); ?></td>
        <td><?php echo h($k['ime']); ?></td>
        <td><?php echo h($k['email']); ?></td>
        <td><?php echo $k['admin'] ? 'Da' : 'Ne'; ?></td>
        <td><?php echo h($k['kreiran']); ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

<?php include 'inc/podnozje.php'; ?>
