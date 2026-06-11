
CREATE DATABASE IF NOT EXISTS filmoteka
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE filmoteka;


DROP TABLE IF EXISTS korisnici;
CREATE TABLE korisnici (
  id        INT AUTO_INCREMENT PRIMARY KEY,
  ime       VARCHAR(100) NOT NULL,
  email     VARCHAR(150) NOT NULL UNIQUE,
  lozinka   VARCHAR(255) NOT NULL,
  admin     TINYINT(1) NOT NULL DEFAULT 0,
  kreiran   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- administrator:  e-mail: admin@filmoteka.hr   lozinka: admin123
INSERT INTO korisnici (ime, email, lozinka, admin) VALUES
  ('Administrator', 'admin@filmoteka.hr', '$2y$10$yS1P15Ts5Ld89lvNqVNLReslLzDD/Fi9jXIZp8I09/AQYFQGcYh92', 1);


DROP TABLE IF EXISTS liste;
CREATE TABLE liste (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  korisnik_id INT NOT NULL,
  imdb_id     VARCHAR(20) NOT NULL,
  naslov      VARCHAR(255) NOT NULL,
  godina      VARCHAR(20),
  tip         VARCHAR(20),
  poster      VARCHAR(500),
  lista       ENUM('gledano','zelim') NOT NULL,
  dodano      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY jedinstveno (korisnik_id, imdb_id),
  FOREIGN KEY (korisnik_id) REFERENCES korisnici(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS poruke;
CREATE TABLE poruke (
  id      INT AUTO_INCREMENT PRIMARY KEY,
  ime     VARCHAR(100) NOT NULL,
  email   VARCHAR(150) NOT NULL,
  tema    VARCHAR(100),
  poruka  TEXT NOT NULL,
  vrijeme TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
