<?php


define('OMDB_API_KEY', '3a29e6c8');
define('OMDB_URL', 'https://www.omdbapi.com/');

function ima_api_kljuc() {
  return OMDB_API_KEY !== 'YOUR_API_KEY' && OMDB_API_KEY !== '';
}


function omdb_pretraga($upit, $tip = '') {
  if (!ima_api_kljuc()) return null;
  $url = OMDB_URL . '?apikey=' . OMDB_API_KEY . '&s=' . urlencode($upit);
  if ($tip !== '') $url .= '&type=' . urlencode($tip);
  $odgovor = @file_get_contents($url);
  $podaci = $odgovor ? json_decode($odgovor, true) : null;
  return (isset($podaci['Response']) && $podaci['Response'] === 'True') ? $podaci['Search'] : null;
}


function omdb_detalji_xml($imdb_id) {
  if (!ima_api_kljuc()) return null;
  $url = OMDB_URL . '?apikey=' . OMDB_API_KEY . '&i=' . urlencode($imdb_id) . '&plot=full&r=xml';
  $odgovor = @file_get_contents($url);
  if (!$odgovor) return null;
  $xml = @simplexml_load_string($odgovor);
  return ($xml && isset($xml->movie)) ? $xml->movie : null;
}
