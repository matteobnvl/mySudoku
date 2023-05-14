-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : database:3306
-- Généré le : sam. 13 mai 2023 à 16:23
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `my_sudoku`
--

-- --------------------------------------------------------

--
-- Structure de la table `Amis`
--

CREATE TABLE `Amis` (
  `id` int NOT NULL,
  `id_amis` int NOT NULL,
  `id_amis_1` int NOT NULL,
  `statut` tinyint(1) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Duel`
--

CREATE TABLE `Duel` (
  `id_duel` int NOT NULL,
  `vie` int NOT NULL DEFAULT '5',
  `vainqueur` tinyint(1) NOT NULL DEFAULT '0',
  `score` int DEFAULT NULL,
  `statut` int NOT NULL DEFAULT '1',
  `id_joueur` int NOT NULL,
  `id_multi` int NOT NULL,
  `id_sudoku` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Joueur`
--

CREATE TABLE `Joueur` (
  `id_joueur` int NOT NULL,
  `pseudo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `mot_de_passe` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `score` int DEFAULT NULL,
  `date_recovery_password` datetime DEFAULT NULL,
  `token_recovery_password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Multijoueur`
--

CREATE TABLE `Multijoueur` (
  `id_multi` int NOT NULL,
  `complet` tinyint(1) NOT NULL,
  `date_start` datetime NOT NULL,
  `termine` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Niveau`
--

CREATE TABLE `Niveau` (
  `id_niveau` int NOT NULL,
  `difficulte` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `score` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Niveau`
--

INSERT INTO `Niveau` (`id_niveau`, `difficulte`, `score`) VALUES
(1, 'easy', 10),
(2, 'medium', 30),
(3, 'hard', 50);

-- --------------------------------------------------------

--
-- Structure de la table `Partie`
--

CREATE TABLE `Partie` (
  `id_partie` int NOT NULL,
  `date_partie` date DEFAULT NULL,
  `vie` int NOT NULL DEFAULT '5',
  `score` int DEFAULT NULL,
  `statut` int NOT NULL,
  `id_joueur` int DEFAULT NULL,
  `id_niveau` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Sudoku`
--

CREATE TABLE `Sudoku` (
  `id_sudoku` int NOT NULL,
  `tableau` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `solution` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `id_partie` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Amis`
--
ALTER TABLE `Amis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_amis` (`id_amis`),
  ADD KEY `id_amis_1` (`id_amis_1`);

--
-- Index pour la table `Duel`
--
ALTER TABLE `Duel`
  ADD PRIMARY KEY (`id_duel`),
  ADD KEY `id_joueur` (`id_joueur`),
  ADD KEY `id_sudoku` (`id_sudoku`),
  ADD KEY `id_multi` (`id_multi`);

--
-- Index pour la table `Joueur`
--
ALTER TABLE `Joueur`
  ADD PRIMARY KEY (`id_joueur`);

--
-- Index pour la table `Multijoueur`
--
ALTER TABLE `Multijoueur`
  ADD PRIMARY KEY (`id_multi`);

--
-- Index pour la table `Niveau`
--
ALTER TABLE `Niveau`
  ADD PRIMARY KEY (`id_niveau`);

--
-- Index pour la table `Partie`
--
ALTER TABLE `Partie`
  ADD PRIMARY KEY (`id_partie`),
  ADD KEY `id_statut` (`statut`),
  ADD KEY `id_joueur` (`id_joueur`),
  ADD KEY `id_niveau` (`id_niveau`);

--
-- Index pour la table `Sudoku`
--
ALTER TABLE `Sudoku`
  ADD PRIMARY KEY (`id_sudoku`),
  ADD KEY `id_partie` (`id_partie`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Amis`
--
ALTER TABLE `Amis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `Duel`
--
ALTER TABLE `Duel`
  MODIFY `id_duel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pour la table `Joueur`
--
ALTER TABLE `Joueur`
  MODIFY `id_joueur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `Multijoueur`
--
ALTER TABLE `Multijoueur`
  MODIFY `id_multi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `Niveau`
--
ALTER TABLE `Niveau`
  MODIFY `id_niveau` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Partie`
--
ALTER TABLE `Partie`
  MODIFY `id_partie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT pour la table `Sudoku`
--
ALTER TABLE `Sudoku`
  MODIFY `id_sudoku` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Amis`
--
ALTER TABLE `Amis`
  ADD CONSTRAINT `amis_ibfk_1` FOREIGN KEY (`id_amis`) REFERENCES `Joueur` (`id_joueur`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `amis_ibfk_2` FOREIGN KEY (`id_amis_1`) REFERENCES `Joueur` (`id_joueur`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `Duel`
--
ALTER TABLE `Duel`
  ADD CONSTRAINT `duel_ibfk_1` FOREIGN KEY (`id_joueur`) REFERENCES `Joueur` (`id_joueur`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `duel_ibfk_2` FOREIGN KEY (`id_sudoku`) REFERENCES `Sudoku` (`id_sudoku`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `duel_ibfk_3` FOREIGN KEY (`id_multi`) REFERENCES `Multijoueur` (`id_multi`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `Partie`
--
ALTER TABLE `Partie`
  ADD CONSTRAINT `partie_ibfk_2` FOREIGN KEY (`id_joueur`) REFERENCES `Joueur` (`id_joueur`),
  ADD CONSTRAINT `partie_ibfk_3` FOREIGN KEY (`id_niveau`) REFERENCES `Niveau` (`id_niveau`);

--
-- Contraintes pour la table `Sudoku`
--
ALTER TABLE `Sudoku`
  ADD CONSTRAINT `sudoku_ibfk_1` FOREIGN KEY (`id_partie`) REFERENCES `Partie` (`id_partie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
