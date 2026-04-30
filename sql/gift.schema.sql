SET NAMES utf8mb4;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;

DROP TABLE IF EXISTS box2presta;
DROP TABLE IF EXISTS coffret2presta;
DROP TABLE IF EXISTS box;
DROP TABLE IF EXISTS prestation;
DROP TABLE IF EXISTS coffret_type;
DROP TABLE IF EXISTS coffret;
DROP TABLE IF EXISTS categorie;
DROP TABLE IF EXISTS theme;
DROP TABLE IF EXISTS user;

DROP TABLE IF EXISTS user;
CREATE TABLE user (
  id VARCHAR(40) NOT NULL,
  user_id VARCHAR(128) UNIQUE,
  password VARCHAR(256),
  role TINYINT,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS categorie;
CREATE TABLE categorie (
  id INT AUTO_INCREMENT,
  libelle VARCHAR(128) NOT NULL,
  description TEXT,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS theme;
CREATE TABLE theme (
  id INT AUTO_INCREMENT,
  libelle VARCHAR(128) NOT NULL,
  description TEXT,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS prestation;
CREATE TABLE prestation (
  id VARCHAR(128) NOT NULL,
  libelle VARCHAR(128) NOT NULL,
  description TEXT NOT NULL,
  url VARCHAR(256),
  unite VARCHAR(128),
  tarif DECIMAL(10,2) NOT NULL,
  img VARCHAR(128) NOT NULL,
  cat_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX idx_prestation_cat (cat_id),
  CONSTRAINT fk_prestation_categorie
    FOREIGN KEY (cat_id)
    REFERENCES categorie(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS coffret;
CREATE TABLE coffret (
  id INT AUTO_INCREMENT,
  libelle VARCHAR(128) NOT NULL,
  description TEXT,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 
DROP TABLE IF EXISTS coffret_type;
CREATE TABLE coffret_type (
  id INT AUTO_INCREMENT,
  libelle VARCHAR(128) NOT NULL,
  description TEXT NOT NULL,
  theme_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX idx_coffret_type_theme (theme_id),
  CONSTRAINT fk_coffret_type_theme
    FOREIGN KEY (theme_id)
    REFERENCES theme(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS box;
CREATE TABLE box (
  id VARCHAR(128) NOT NULL,
  token VARCHAR(64) NOT NULL,
  libelle VARCHAR(128) NOT NULL,
  description TEXT,
  montant DECIMAL(12,2) DEFAULT 0.00,
  kdo TINYINT NOT NULL DEFAULT 0,
  message_kdo TEXT,
  statut INT NOT NULL DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT NULL,
  createur_id VARCHAR(40),
  PRIMARY KEY (id),
  INDEX idx_box_createur (createur_id),
  CONSTRAINT fk_box_user
    FOREIGN KEY (createur_id)
    REFERENCES user(id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS box2presta;
CREATE TABLE box2presta (
  box_id VARCHAR(128) NOT NULL,
  presta_id VARCHAR(128) NOT NULL,
  quantite INT NOT NULL,
  PRIMARY KEY (box_id, presta_id),
  INDEX idx_b2p_presta (presta_id),
  CONSTRAINT fk_box2presta_box
    FOREIGN KEY (box_id)
    REFERENCES box(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_box2presta_presta
    FOREIGN KEY (presta_id)
    REFERENCES prestation(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS coffret2presta;
CREATE TABLE coffret2presta (
  coffret_id INT NOT NULL,
  presta_id VARCHAR(128) NOT NULL,
  PRIMARY KEY (coffret_id, presta_id),
  INDEX idx_c2p_presta (presta_id),
  CONSTRAINT fk_coffret2presta_coffret
    FOREIGN KEY (coffret_id)
    REFERENCES coffret(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_coffret2presta_presta
    FOREIGN KEY (presta_id)
    REFERENCES prestation(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET foreign_key_checks = 1;