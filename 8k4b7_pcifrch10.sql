-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 06 juil. 2018 à 07:46
-- Version du serveur :  5.7.21
-- Version de PHP :  7.0.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `8k4b7_pcifrch10`
--
CREATE DATABASE IF NOT EXISTS `8k4b7_pcifrch10` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `8k4b7_pcifrch10`;

-- --------------------------------------------------------

--
-- Structure de la table `chantier`
--

DROP TABLE IF EXISTS `chantier`;
CREATE TABLE IF NOT EXISTS `chantier` (
  `idChantier` int(11) NOT NULL AUTO_INCREMENT,
  `nomChantier` varchar(150) NOT NULL,
  PRIMARY KEY (`idChantier`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `chauffeurcours`
--

DROP TABLE IF EXISTS `chauffeurcours`;
CREATE TABLE IF NOT EXISTS `chauffeurcours` (
  `idChauffeurCours` int(11) NOT NULL AUTO_INCREMENT,
  `avsChauffeur` varchar(20) NOT NULL,
  `idCours` bigint(20) NOT NULL,
  PRIMARY KEY (`idChauffeurCours`),
  KEY `idCours` (`idCours`),
  KEY `avsChauffeur` (`avsChauffeur`)
) ENGINE=InnoDB AUTO_INCREMENT=2377 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `chantier` varchar(200) NOT NULL,
  `timestampDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statut` varchar(100) NOT NULL,
  `data` json NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `idCours` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  PRIMARY KEY (`idCours`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `formulaire_evaluation`
--

DROP TABLE IF EXISTS `formulaire_evaluation`;
CREATE TABLE IF NOT EXISTS `formulaire_evaluation` (
  `id_formulaire_evaluation` int(30) NOT NULL,
  `avs` char(20) NOT NULL,
  `efb_comportement` int(10) NOT NULL,
  `efb_motivation` int(10) NOT NULL,
  `efb_connaissance_technique` int(10) NOT NULL,
  `efb_faculte_expression` int(10) NOT NULL,
  `efb_aptitude_fonction` int(10) NOT NULL,
  `efb_appreciation_globale` int(10) NOT NULL,
  `cadre_capacite_appreciation_situation` int(10) NOT NULL,
  `cadre_capacite_decision` int(10) NOT NULL,
  `cadre_capacite_instruire` int(10) NOT NULL,
  `cadre_aptitude_conduite` int(10) NOT NULL,
  `cadre_aptitude_fonction` int(10) NOT NULL,
  `cadre_appreciation_globale` int(10) NOT NULL,
  `remarque_chef` varchar(1000) NOT NULL,
  `date_entree` date NOT NULL,
  `date_licenciement` date NOT NULL,
  `qualification` varchar(100) NOT NULL,
  `genre_cours` varchar(100) NOT NULL,
  `provenance` varchar(50) NOT NULL,
  `incorporation` varchar(50) NOT NULL,
  PRIMARY KEY (`id_formulaire_evaluation`,`avs`),
  KEY `avs` (`avs`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `grade`
--

DROP TABLE IF EXISTS `grade`;
CREATE TABLE IF NOT EXISTS `grade` (
  `idGrade` int(2) NOT NULL,
  `grade` varchar(50) NOT NULL,
  `gradeAbr` varchar(6) NOT NULL,
  PRIMARY KEY (`idGrade`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
CREATE TABLE IF NOT EXISTS `groupe` (
  `idGroupe` bigint(20) NOT NULL AUTO_INCREMENT,
  `idSection` bigint(20) NOT NULL,
  `nomGroupe` varchar(255) NOT NULL,
  `gChef` char(20) DEFAULT NULL,
  `gRempl` char(20) DEFAULT NULL,
  `chauffeur` char(20) DEFAULT NULL,
  PRIMARY KEY (`idGroupe`),
  KEY `gChef` (`gChef`),
  KEY `gRempl` (`gRempl`),
  KEY `chauffeur` (`chauffeur`),
  KEY `idSection` (`idSection`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `historiquetransport`
--

DROP TABLE IF EXISTS `historiquetransport`;
CREATE TABLE IF NOT EXISTS `historiquetransport` (
  `idHistoriqueTransport` bigint(11) NOT NULL AUTO_INCREMENT,
  `idCours` bigint(11) NOT NULL,
  `idVehicule` bigint(11) NOT NULL,
  `idChauffeurCours` int(11) NOT NULL,
  `heureDepart` datetime NOT NULL,
  `delai` datetime NOT NULL,
  `lieuDepart` text NOT NULL,
  `lieuDestination` text NOT NULL,
  `butTransport` text NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`idHistoriqueTransport`),
  KEY `idVehicule` (`idVehicule`),
  KEY `idCours` (`idCours`),
  KEY `idChauffeurCours` (`idChauffeurCours`)
) ENGINE=InnoDB AUTO_INCREMENT=571 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

DROP TABLE IF EXISTS `personne`;
CREATE TABLE IF NOT EXISTS `personne` (
  `avs` char(20) NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8 NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8 NOT NULL,
  `date_naissance` date NOT NULL,
  `idGrade` int(2) NOT NULL,
  `affectation` varchar(50) NOT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `npa` int(4) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `profession` varchar(50) DEFAULT NULL,
  `employeur` varchar(50) DEFAULT NULL,
  `tel_privee` varchar(13) DEFAULT NULL,
  `tel_mobile` varchar(13) DEFAULT NULL,
  `tel_prof` varchar(13) DEFAULT NULL,
  `fax` varchar(13) DEFAULT NULL,
  `email_prive` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `est_dans_organigramme` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `actif` tinyint(1) UNSIGNED DEFAULT '1',
  `disponibilite` tinyint(1) UNSIGNED DEFAULT '1',
  `ne_plus_convoquer` tinyint(1) UNSIGNED DEFAULT '0',
  `incorporation` varchar(50) DEFAULT NULL,
  `est_dans_liste` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`avs`),
  KEY `idGrade` (`idGrade`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `section`
--

DROP TABLE IF EXISTS `section`;
CREATE TABLE IF NOT EXISTS `section` (
  `idSection` bigint(20) NOT NULL AUTO_INCREMENT,
  `nomSection` varchar(255) NOT NULL,
  `sChef` char(20) DEFAULT NULL,
  `sRempl` char(20) DEFAULT NULL,
  `idCours` bigint(20) NOT NULL,
  PRIMARY KEY (`idSection`),
  KEY `sChef` (`sChef`),
  KEY `sRempl` (`sRempl`),
  KEY `idCours` (`idCours`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `sousgroupe`
--

DROP TABLE IF EXISTS `sousgroupe`;
CREATE TABLE IF NOT EXISTS `sousgroupe` (
  `idSousGroupe` bigint(20) NOT NULL AUTO_INCREMENT,
  `idGroupe` bigint(20) NOT NULL,
  `nomSousGroupe` varchar(255) NOT NULL,
  `sgChef` char(20) DEFAULT NULL,
  `sgRempl` char(20) DEFAULT NULL,
  PRIMARY KEY (`idSousGroupe`),
  KEY `sgChef` (`sgChef`),
  KEY `sgRempl` (`sgRempl`),
  KEY `idGroupe` (`idGroupe`)
) ENGINE=InnoDB AUTO_INCREMENT=259 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `sousgroupeeffectif`
--

DROP TABLE IF EXISTS `sousgroupeeffectif`;
CREATE TABLE IF NOT EXISTS `sousgroupeeffectif` (
  `idSousGroupe` bigint(20) NOT NULL,
  `avs` char(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`avs`,`idSousGroupe`),
  KEY `idSousGroupe` (`idSousGroupe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `login` varchar(50) NOT NULL,
  `motdepasse` varchar(50) NOT NULL,
  `droits` int(12) NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateursformulaires`
--

DROP TABLE IF EXISTS `utilisateursformulaires`;
CREATE TABLE IF NOT EXISTS `utilisateursformulaires` (
  `login` varchar(20) NOT NULL,
  `motdepasse` varchar(40) NOT NULL,
  `email` varchar(200) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

DROP TABLE IF EXISTS `vehicule`;
CREATE TABLE IF NOT EXISTS `vehicule` (
  `idVehicule` bigint(20) NOT NULL AUTO_INCREMENT,
  `numPlaque` varchar(20) NOT NULL,
  `modeleVehicule` varchar(200) NOT NULL,
  `nbrPlace` int(11) NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`idVehicule`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `vehiculecours`
--

DROP TABLE IF EXISTS `vehiculecours`;
CREATE TABLE IF NOT EXISTS `vehiculecours` (
  `idVehiculeCours` bigint(20) NOT NULL AUTO_INCREMENT,
  `idVehicule` bigint(20) NOT NULL,
  `idCours` bigint(20) NOT NULL,
  PRIMARY KEY (`idVehiculeCours`),
  KEY `idVehicule` (`idVehicule`),
  KEY `idCours` (`idCours`)
) ENGINE=InnoDB AUTO_INCREMENT=1669 DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chauffeurcours`
--
ALTER TABLE `chauffeurcours`
  ADD CONSTRAINT `chauffeurcours_ibfk_1` FOREIGN KEY (`avsChauffeur`) REFERENCES `personne` (`avs`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chauffeurcours_ibfk_2` FOREIGN KEY (`idCours`) REFERENCES `cours` (`idCours`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `formulaire_evaluation`
--
ALTER TABLE `formulaire_evaluation`
  ADD CONSTRAINT `formulaire_evaluation_ibfk_2` FOREIGN KEY (`avs`) REFERENCES `personne` (`avs`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD CONSTRAINT `groupe_ibfk_10` FOREIGN KEY (`chauffeur`) REFERENCES `personne` (`avs`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `groupe_ibfk_4` FOREIGN KEY (`idSection`) REFERENCES `section` (`idSection`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groupe_ibfk_8` FOREIGN KEY (`gChef`) REFERENCES `personne` (`avs`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `groupe_ibfk_9` FOREIGN KEY (`gRempl`) REFERENCES `personne` (`avs`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `historiquetransport`
--
ALTER TABLE `historiquetransport`
  ADD CONSTRAINT `historiquetransport_ibfk_1` FOREIGN KEY (`idChauffeurCours`) REFERENCES `chauffeurcours` (`idChauffeurCours`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historiquetransport_ibfk_2` FOREIGN KEY (`idVehicule`) REFERENCES `vehicule` (`idVehicule`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historiquetransport_ibfk_3` FOREIGN KEY (`idCours`) REFERENCES `cours` (`idCours`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `personne`
--
ALTER TABLE `personne`
  ADD CONSTRAINT `personne_ibfk_1` FOREIGN KEY (`idGrade`) REFERENCES `grade` (`idGrade`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_3` FOREIGN KEY (`idCours`) REFERENCES `cours` (`idCours`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `section_ibfk_6` FOREIGN KEY (`sChef`) REFERENCES `personne` (`avs`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `section_ibfk_7` FOREIGN KEY (`sRempl`) REFERENCES `personne` (`avs`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `sousgroupe`
--
ALTER TABLE `sousgroupe`
  ADD CONSTRAINT `sousgroupe_ibfk_1` FOREIGN KEY (`idGroupe`) REFERENCES `groupe` (`idGroupe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sousgroupe_ibfk_6` FOREIGN KEY (`sgChef`) REFERENCES `personne` (`avs`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sousgroupe_ibfk_7` FOREIGN KEY (`sgRempl`) REFERENCES `personne` (`avs`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `sousgroupeeffectif`
--
ALTER TABLE `sousgroupeeffectif`
  ADD CONSTRAINT `sousgroupeeffectif_ibfk_2` FOREIGN KEY (`idSousGroupe`) REFERENCES `sousgroupe` (`idSousGroupe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sousgroupeeffectif_ibfk_3` FOREIGN KEY (`avs`) REFERENCES `personne` (`avs`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `vehiculecours`
--
ALTER TABLE `vehiculecours`
  ADD CONSTRAINT `vehiculecours_ibfk_2` FOREIGN KEY (`idCours`) REFERENCES `cours` (`idCours`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vehiculecours_ibfk_3` FOREIGN KEY (`idVehicule`) REFERENCES `vehicule` (`idVehicule`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
