-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 03 Mars 2016 à 17:16
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `lokisalle`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE IF NOT EXISTS `avis` (
  `id_avis` int(5) NOT NULL AUTO_INCREMENT,
  `id_membre` int(5) NOT NULL,
  `id_salle` int(5) NOT NULL,
  `commentaire` text NOT NULL,
  `note` int(2) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_avis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(6) NOT NULL AUTO_INCREMENT,
  `montant` int(5) NOT NULL,
  `id_membre` int(5) NOT NULL,
  `date` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_commande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `details_commande`
--

CREATE TABLE IF NOT EXISTS `details_commande` (
  `id_details_commande` int(6) NOT NULL AUTO_INCREMENT,
  `id_commande` int(6) NOT NULL,
  `id_produit` int(5) NOT NULL,
  `Created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_details_commande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int(5) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(15) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `sexe` enum('m','f') NOT NULL,
  `ville` varchar(20) NOT NULL,
  `cp` int(5) NOT NULL,
  `adresse` varchar(30) NOT NULL,
  `statut` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_membre`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `sexe`, `ville`, `cp`, `adresse`, `statut`, `created_at`, `updated_at`) VALUES
(2, 'roby', '$2y$10$zeNTAQqW9x7/8IpqGXJm7evllxKLXMb/K.QOe2UWbXWtKxW/0fHwa', 'Baggio', 'Roberto', 'roby.baggio@mail.com', 'm', 'Footix', 10000, '10 rue d''un big boss', 1, '2016-03-03 10:25:01', '2016-03-03 10:35:16'),
(3, 'theBeast', '$2y$10$bFOjdhXUsml7LeINnfKrheFXuMJUjpjcTPi42gdP8WFb6mwzh2g2i', 'Lesnar', 'Brock', 'brock@lesnar.com', 'm', 'Mineapolis', 20000, 'Suplex city bitch', 0, '2016-03-03 11:00:29', '2016-03-03 11:00:29'),
(4, 'shabbaz', '$2y$10$jBY13VpFho59O2RZwLQNge.se.IoOBP4E6P0hTLtXt2HlS9VIjXI6', 'niane', 'hamidou', 'hamidou@free.fr', 'm', 'pomponne', 77400, '14 rue de marne', 1, '2016-03-03 10:33:36', '2016-03-03 10:35:14');

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id_newsletter` int(5) NOT NULL AUTO_INCREMENT,
  `id_membre` int(5) NOT NULL,
  PRIMARY KEY (`id_newsletter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int(5) NOT NULL AUTO_INCREMENT,
  `date_arrivee` datetime NOT NULL,
  `date_depart` datetime NOT NULL,
  `id_salle` int(5) NOT NULL,
  `id_promo` int(2) NOT NULL,
  `prix` int(5) NOT NULL,
  `etat` varchar(255) NOT NULL,
  PRIMARY KEY (`id_produit`),
  KEY `id_salle` (`id_salle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `date_arrivee`, `date_depart`, `id_salle`, `id_promo`, `prix`, `etat`) VALUES
(12, '2016-03-11 00:00:00', '2016-03-12 00:00:00', 3, 0, 150, 'disponible'),
(14, '2016-04-01 00:00:00', '2016-03-07 00:00:00', 1, 0, 20, 'dispo'),
(15, '2016-07-14 00:00:00', '2016-03-21 00:00:00', 5, 0, 75, 'dispo'),
(16, '2016-11-11 00:00:00', '2016-11-21 00:00:00', 6, 0, 200, 'dispo'),
(17, '2016-06-21 00:00:00', '2016-06-24 00:00:00', 4, 0, 1, 'dispo');

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE IF NOT EXISTS `promotion` (
  `id_promo` int(2) NOT NULL AUTO_INCREMENT,
  `code_promo` varchar(6) NOT NULL,
  `reduction` int(5) NOT NULL,
  `Created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_promo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE IF NOT EXISTS `salle` (
  `id_salle` int(5) NOT NULL AUTO_INCREMENT,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` text NOT NULL,
  `cp` varchar(5) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  `capacite` int(3) NOT NULL,
  `categorie` enum('business','fete') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_salle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `pays`, `ville`, `adresse`, `cp`, `titre`, `description`, `photo`, `capacite`, `categorie`, `created_at`, `updated_at`) VALUES
(1, 'France', 'Pomponne', '14 rue de marne', '77400', 'Salle Hamidou', 'Salle de fete', 'fete1.jpg', 150, 'fete', '2016-03-03 13:41:55', '2016-03-03 15:31:30'),
(3, 'France', 'Marseille', '14 rue du baron', '13000', 'Salle Baron', 'Salle des fetes rue baron', 'fete2.jpg', 150, 'fete', '2016-03-03 14:01:43', '2016-03-03 15:32:18'),
(4, 'France', 'Lagny', '14 rue de bardin', '77400', 'Salle Elena', 'Salle des fetes', 'fete3.jpg', 50, 'fete', '2016-03-03 14:02:28', '2016-03-03 16:04:38'),
(5, 'France', 'vierzon', '14 rue de baille', '18100', 'Salle Hatem', 'Salle de conference a baille', 'business1.jpg', 40, 'business', '2016-03-03 14:03:18', '2016-03-03 16:04:26'),
(6, 'France', 'Tours', '14 rue de la victoire', '37000', 'Salle Alice', 'Salle de reunion a tours', 'business2.jpg', 100, 'business', '2016-03-03 14:04:22', '2016-03-03 16:04:49');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
