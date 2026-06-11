<?php


session_start();

require_once __DIR__ . '/dbconn.php';

function h($t) {
  return htmlspecialchars($t ?? '', ENT_QUOTES, 'UTF-8');
}


function registriraj($ime, $email, $lozinka) {
  global $veza;
  $email = strtolower(trim($email));

  $ime = trim($ime);


  $stmt = $veza->prepare('SELECT id FROM korisnici WHERE email = ?');
  $stmt->bind_param('s', $email);

  $stmt->execute();
  if ($stmt->get_result()->num_rows > 0) {
    return 'Korisnik s tim e-mailom već postoji.';
  }

  $hash = password_hash($lozinka, PASSWORD_DEFAULT);
  $stmt = $veza->prepare('INSERT INTO korisnici (ime, email, lozinka) VALUES (?, ?, ?)');
  $stmt->bind_param('sss', $ime, $email, $hash);

  $stmt->execute();

  $_SESSION['korisnik'] = ['id' => $veza->insert_id, 'ime' => $ime, 'email' => $email, 'admin' => 0];
  return true;

}


function prijavi($email, $lozinka) {
  global $veza;
  $email = strtolower(trim($email));
  $stmt = $veza->prepare('SELECT id, ime, email, lozinka, admin FROM korisnici WHERE email = ?');
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $r = $stmt->get_result()->fetch_assoc();

  if ($r && password_verify($lozinka, $r['lozinka'])) {

    $_SESSION['korisnik'] = ['id' => $r['id'], 'ime' => $r['ime'], 'email' => $r['email'], 'admin' => (int)$r['admin']];
    return true;
  }
  return 'Neispravan e-mail ili lozinka.';

}

function odjavi()            { unset($_SESSION['korisnik']); }
function prijavljen()        { return isset($_SESSION['korisnik']); }

function trenutni_korisnik() { return $_SESSION['korisnik'] ?? null; }

function je_admin()          { return prijavljen() && !empty($_SESSION['korisnik']['admin']); }




function dodaj_u_listu($lista, $film) {
  global $veza;
  if (!prijavljen()) return;
  $kid = trenutni_korisnik()['id'];

  $lista = $lista === 'gledano' ? 'gledano' : 'zelim';
  $stmt = $veza->prepare(
    'INSERT INTO liste (korisnik_id, imdb_id, naslov, godina, tip, poster, lista)
     VALUES (?, ?, ?, ?, ?, ?, ?)
     ON DUPLICATE KEY UPDATE lista = VALUES(lista), naslov = VALUES(naslov),
       godina = VALUES(godina), tip = VALUES(tip), poster = VALUES(poster)'
  );

  $stmt->bind_param('issssss', $kid, $film['imdbID'], $film['Title'], $film['Year'], $film['Type'], $film['Poster'], $lista);
  $stmt->execute();
}

function ukloni_iz_liste($imdb_id) {
  global $veza;
  if (!prijavljen()) return;
  $kid = trenutni_korisnik()['id'];
  $stmt = $veza->prepare('DELETE FROM liste WHERE korisnik_id = ? AND imdb_id = ?');
  $stmt->bind_param('is', $kid, $imdb_id);

  $stmt->execute();
}

function premjesti_u($imdb_id, $nova_lista) {
  global $veza;
  if (!prijavljen()) return;
  $kid = trenutni_korisnik()['id'];
  $nova_lista = $nova_lista === 'gledano' ? 'gledano' : 'zelim';
  $stmt = $veza->prepare('UPDATE liste SET lista = ? WHERE korisnik_id = ? AND imdb_id = ?');
  $stmt->bind_param('sis', $nova_lista, $kid, $imdb_id);

  $stmt->execute();

}




function dohvati_listu($lista) {
  global $veza;
  if (!prijavljen()) return [];
  $kid = trenutni_korisnik()['id'];
  $lista = $lista === 'gledano' ? 'gledano' : 'zelim';
  $stmt = $veza->prepare('SELECT imdb_id, naslov, godina, tip, poster FROM liste WHERE korisnik_id = ? AND lista = ? ORDER BY dodano DESC');
  $stmt->bind_param('is', $kid, $lista);
  $stmt->execute();
  return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}



function spremi_poruku($ime, $email, $tema, $poruka) {
  global $veza;
  $stmt = $veza->prepare('INSERT INTO poruke (ime, email, tema, poruka) VALUES (?, ?, ?, ?)');
  $stmt->bind_param('ssss', $ime, $email, $tema, $poruka);
  $stmt->execute();

}

function dohvati_poruke() {
  global $veza;
  $res = $veza->query('SELECT ime, email, tema, poruka, vrijeme FROM poruke ORDER BY vrijeme DESC');
  return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];

}

function dohvati_sve_korisnike() {
  global $veza;
  $res = $veza->query('SELECT id, ime, email, admin, kreiran FROM korisnici ORDER BY id');
  return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  
}
