-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 15 juil. 2020 à 15:14
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_chambre`
--

-- --------------------------------------------------------

--
-- Structure de la table `batiment`
--

CREATE TABLE `batiment` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `batiment`
--

INSERT INTO `batiment` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6);

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

CREATE TABLE `chambre` (
  `id` int(11) NOT NULL,
  `batiment_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`id`, `batiment_id`, `type`) VALUES
(1, 1, 'individuel'),
(2, 4, 'individuel'),
(3, 3, 'deux'),
(4, 4, 'deux'),
(5, 1, 'deux'),
(6, 2, 'individuel'),
(7, 2, 'individuel'),
(8, 4, 'deux'),
(9, 4, 'individuel'),
(10, 4, 'individuel'),
(11, 3, 'individuel'),
(12, 4, 'deux'),
(13, 3, 'deux'),
(14, 1, 'individuel'),
(15, 1, 'individuel'),
(16, 1, 'individuel'),
(17, 4, 'deux'),
(18, 1, 'individuel');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20200705203558', '2020-07-05 22:36:18', 2054);

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `id` int(11) NOT NULL,
  `num_chambre_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `matricule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bourse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`id`, `num_chambre_id`, `nom`, `prenom`, `email`, `telephone`, `date_naissance`, `matricule`, `adresse`, `bourse`) VALUES
(1, 1, 'DRAME', 'Abdoulaye', 'eldra.ad@gmail.com', '35408746', '2020-07-21', '2020yedr0001', NULL, 'Entiere'),
(2, 2, 'Fall', 'Ababacar', 'babs@sontael.sn', '776789808', '1996-06-17', '2020arfa0004', NULL, 'Non'),
(3, 3, 'Sene', 'Babacar', 'doudou@test.org', '770638048', '1998-08-02', '2020arse0009', NULL, 'Non'),
(4, 4, 'GAYE', 'Doudou', 'doudou@gaye.com', '773600029', '2002-03-16', '2020badr0005', NULL, 'Entiere'),
(5, 5, 'DRAME', 'Samba', 'sam@dr.com', '773682929', '2020-06-02', '2020badr0007', NULL, 'Demi'),
(6, 2, 'Seck', 'Serigne', 'sms@sontael.sn', '778040852', '1997-02-20', '2020ckse0008', NULL, 'Non'),
(8, NULL, 'DIENG', 'Ibrahima', 'seckdieng@gmail.com', '777066604', '1992-07-23', '2020dima0002', 'Yoff', 'Non'),
(10, NULL, 'Fall', 'Sakhir', 'sakhir@sontael.sn', '776736808', '1995-03-17', '2020irfa0006', 'Dakar', 'Non'),
(11, NULL, 'Ndiaye', 'saly', 'saly@nd.com', '767786890', '2000-06-10', '2020lynd0010', 'Kaolack', 'Demi'),
(12, NULL, 'Ndiaye', 'Moussa', 'mouss@nd.com', '763547890', '2020-06-10', '2020sand0013', 'Thies', 'Demi'),
(13, NULL, 'Laye', 'mbaye', 'mbaye@ghmi.co', '777777777', '2020-06-09', '2020yela0003', 'Louga', 'Non'),
(15, NULL, 'LEYE', 'Aida', 'aidy@aida.com', '7777777777', '2020-07-07', '2020dieng0202', 'Thies', 'Non'),
(21, NULL, 'Mbaye', 'Maty', 'jhhjv@kbjkj', '2345676', '2020-07-21', '2020tyMb0021', 'HFHV', 'Non');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `batiment`
--
ALTER TABLE `batiment`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C509E4FFD6F6891B` (`batiment_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_717E22E314003FDF` (`num_chambre_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `batiment`
--
ALTER TABLE `batiment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `chambre`
--
ALTER TABLE `chambre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD CONSTRAINT `FK_C509E4FFD6F6891B` FOREIGN KEY (`batiment_id`) REFERENCES `batiment` (`id`);

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `FK_717E22E314003FDF` FOREIGN KEY (`num_chambre_id`) REFERENCES `chambre` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
