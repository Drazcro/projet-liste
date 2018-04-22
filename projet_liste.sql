-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 22 avr. 2018 à 17:30
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_liste`
--

-- --------------------------------------------------------

--
-- Structure de la table `appliauth`
--

DROP TABLE IF EXISTS `appliauth`;
CREATE TABLE IF NOT EXISTS `appliauth` (
  `idappauth` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`idappauth`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `appliauth`
--

INSERT INTO `appliauth` (`idappauth`, `name`, `password`) VALUES
(1, 'monapp', '2118c37356b669d52c22510c0287642551fcdc1b9b27517999e040ad56d1ad678cb71496eb4da19832143ae14ef1ceabf1824349bd608176a91f22f7088a5427');

-- --------------------------------------------------------

--
-- Structure de la table `element`
--

DROP TABLE IF EXISTS `element`;
CREATE TABLE IF NOT EXISTS `element` (
  `idelements` int(11) NOT NULL AUTO_INCREMENT,
  `date_creation` date NOT NULL,
  `date_modif` date NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  `idListe` int(11) NOT NULL,
  PRIMARY KEY (`idelements`),
  KEY `idListe` (`idListe`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `etiquette`
--

DROP TABLE IF EXISTS `etiquette`;
CREATE TABLE IF NOT EXISTS `etiquette` (
  `idetiquette` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(200) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idetiquette`),
  KEY `idUseret` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `identifie`
--

DROP TABLE IF EXISTS `identifie`;
CREATE TABLE IF NOT EXISTS `identifie` (
  `element_idelements` int(11) NOT NULL,
  `etiquette_idetiquette` int(11) NOT NULL,
  PRIMARY KEY (`element_idelements`,`etiquette_idetiquette`),
  KEY `fk_element_has_etiquette_etiquette1_idx` (`etiquette_idetiquette`),
  KEY `fk_element_has_etiquette_element1_idx` (`element_idelements`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `liste`
--

DROP TABLE IF EXISTS `liste`;
CREATE TABLE IF NOT EXISTS `liste` (
  `idliste` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text,
  `visibility` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idliste`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `partage`
--

DROP TABLE IF EXISTS `partage`;
CREATE TABLE IF NOT EXISTS `partage` (
  `utilisateur_idUser` int(11) NOT NULL,
  `liste_idliste` int(11) NOT NULL,
  `autorisation` int(11) NOT NULL,
  PRIMARY KEY (`utilisateur_idUser`,`liste_idliste`),
  KEY `fk_utilisateur_has_liste_liste1_idx` (`liste_idliste`),
  KEY `fk_utilisateur_has_liste_utilisateur1_idx` (`utilisateur_idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `posseder`
--

DROP TABLE IF EXISTS `posseder`;
CREATE TABLE IF NOT EXISTS `posseder` (
  `liste_idliste` int(11) NOT NULL,
  `liste_idliste1` int(11) NOT NULL,
  PRIMARY KEY (`liste_idliste`,`liste_idliste1`),
  KEY `fk_liste_has_liste_liste2_idx` (`liste_idliste1`),
  KEY `fk_liste_has_liste_liste1_idx` (`liste_idliste`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `permission` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `pseudo_UNIQUE` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `element`
--
ALTER TABLE `element`
  ADD CONSTRAINT `idListe` FOREIGN KEY (`idListe`) REFERENCES `liste` (`idliste`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `etiquette`
--
ALTER TABLE `etiquette`
  ADD CONSTRAINT `idUseret` FOREIGN KEY (`idUser`) REFERENCES `utilisateur` (`idUser`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `identifie`
--
ALTER TABLE `identifie`
  ADD CONSTRAINT `fk_element_has_etiquette_element1` FOREIGN KEY (`element_idelements`) REFERENCES `element` (`idelements`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_element_has_etiquette_etiquette1` FOREIGN KEY (`etiquette_idetiquette`) REFERENCES `etiquette` (`idetiquette`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `liste`
--
ALTER TABLE `liste`
  ADD CONSTRAINT `idUser` FOREIGN KEY (`idUser`) REFERENCES `utilisateur` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `partage`
--
ALTER TABLE `partage`
  ADD CONSTRAINT `fk_utilisateur_has_liste_liste1` FOREIGN KEY (`liste_idliste`) REFERENCES `liste` (`idliste`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utilisateur_has_liste_utilisateur1` FOREIGN KEY (`utilisateur_idUser`) REFERENCES `utilisateur` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `posseder`
--
ALTER TABLE `posseder`
  ADD CONSTRAINT `fk_liste_has_liste_liste1` FOREIGN KEY (`liste_idliste`) REFERENCES `liste` (`idliste`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_liste_has_liste_liste2` FOREIGN KEY (`liste_idliste1`) REFERENCES `liste` (`idliste`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
