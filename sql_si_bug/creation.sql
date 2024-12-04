-- Création de la base de données (si elle n'existe pas déjà)
CREATE DATABASE IF NOT EXISTS alhambra;

USE alhambra;

-- Table 'utilisateur'
CREATE TABLE utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role INT NOT NULL DEFAULT 1, -- 1: User, 2: Admin
);

-- Table 'commission'
CREATE TABLE commission (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    date_creation DATETIME NOT NULL
);

-- Table 'message'
CREATE TABLE message (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    created_at DATETIME NOT NULL,
    sender_id INT NOT NULL,
    commission_id INT,
    FOREIGN KEY (sender_id) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (commission_id) REFERENCES commission(id) ON DELETE SET NULL
);

-- Table 'link_comm_user' (table de jointure pour lier les utilisateurs et les commissions)
CREATE TABLE link_comm_user (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Clé primaire unique
    commission_id INT NOT NULL,        -- Référence à la table 'commission'
    utilisateur_id INT NOT NULL,       -- Référence à la table 'utilisateur'
    FOREIGN KEY (commission_id) REFERENCES commission(id) ON DELETE CASCADE,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
);

-- Table 'notification'
CREATE TABLE `notification` (
  `utilisateur_id` int(11) NOT NULL,
  `commission_id` int(11) NOT NULL,
  `notifications_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `messages_rates` int(11) NOT NULL DEFAULT 0,
  `date_last_checked` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Index et contraintes (si nécessaire pour améliorer les performances ou l'intégrité des données)
CREATE INDEX idx_utilisateur_email ON utilisateur(email);
CREATE INDEX idx_commission_nom ON commission(nom);
ALTER TABLE `notification` ADD `messages_rates` INT NOT NULL DEFAULT '0' AFTER `notifications_enabled`;
ALTER TABLE `notification`
  ADD PRIMARY KEY (`utilisateur_id`,`commission_id`),
  ADD KEY `commission_id` (`commission_id`);
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`commission_id`) REFERENCES `commission` (`id`) ON DELETE CASCADE;
COMMIT;

