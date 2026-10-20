-- Base de données du projet "Réseau social"
-- Importer ce fichier dans phpMyAdmin (onglet Importer) si la base n'existe pas encore.
-- Si ta base existe déjà et fonctionne, tu n'as PAS besoin de ce fichier.

CREATE DATABASE IF NOT EXISTS reseau_social CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE reseau_social;

CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    motDePasse VARCHAR(255) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS amis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur1_id INT NOT NULL,
    utilisateur2_id INT NOT NULL,
    dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_amis (utilisateur1_id, utilisateur2_id),
    FOREIGN KEY (utilisateur1_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (utilisateur2_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS demande_amis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    demandeur_id INT NOT NULL,
    recepteur_id INT NOT NULL,
    statut ENUM('EN_ATTENTE','ACCEPTEE','REJETEE') NOT NULL DEFAULT 'EN_ATTENTE',
    dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (demandeur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (recepteur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    reference_id INT DEFAULT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
) ENGINE=InnoDB;
