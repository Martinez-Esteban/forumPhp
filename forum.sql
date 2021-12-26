-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 26 déc. 2021 à 09:30
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `forum`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `articleId` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(70) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`articleId`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`articleId`, `title`, `description`, `date`, `userId`) VALUES
(10, 'je suis demo', 'et je suis id 4\r\net je suis le meilleur', '2021-12-21', 4),
(14, 'Nouveau', 'Salut je suis nouveau sur le forum ! Faites un tour sur mon profil !\r\n\r\n(ftg fdp -> le modo)', '2021-12-21', 17),
(19, 'test55', 'test affichage aller', '2021-12-24', 22),
(18, 'test2', '2eme article', '2021-12-24', 22),
(25, 'test admin', 'test admin ', '2021-12-26', 16),
(22, 'On va finir ce truc', 'Aller giroud vraiment !', '2021-12-25', 4),
(23, 'aller', 'je ne vois rien deux', '2021-12-25', 4),
(24, 'Jostophe', 'un mix entre joel et christophe !', '2021-12-25', 22),
(26, 'aller', 'test non admin', '2021-12-26', 22),
(27, 'exemple 23', 'je suis exemple 23', '2021-12-26', 25);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(80) NOT NULL,
  `creationDate` date NOT NULL,
  `pp` varchar(2083) NOT NULL DEFAULT 'https://www.cournondanseattitude.fr/wp-content/uploads/2019/07/blank-profile-picture-973460_640.png',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `creationDate`, `pp`, `admin`) VALUES
(16, 'test', '$2y$10$mtjAoABwSDyTcJG7vODs6OMsM9rWEcfivrg1dFTfki8r7ssZlphWq', 'test@test.test', '2021-12-20', 'https://www.cournondanseattitude.fr/wp-content/uploads/2019/07/blank-profile-picture-973460_640.png', 1),
(4, 'Demo', '$2y$10$/k4dAENE8FRcrGZGRBCQwuOVtbhXBmCSgfvTyl83pjPdGnw8cnGWm', 'kevinlebot2@gmail.com', '2021-12-20', './images/forum/4/DSC03023.jpg', 1),
(17, 'esteban', '$2y$10$fn4Igml7AB.dD9difshsoOIQwubHXnsA5rE6oORadDpA3k8vdKX3y', 'esteban.martinez@ynov.com', '2021-12-21', 'https://cdn.discordapp.com/attachments/879049599371870228/923193135679537232/pp.jpeg', 0),
(20, 'toto', '$2y$10$09GNbGTMk5VKQ4NKYSQJXudf18HzHquicgChFikbcgYgdipRL5I1e', 'toto@toto', '2021-12-22', 'https://cdn.discordapp.com/attachments/879049599371870228/923193135679537232/pp.jpeg', 0),
(22, 'benji', '$2y$10$BEdq/A8REpjKL3llHOzGgewKeWfnvSC9XKVMNwFnzfNAhscQcxGHy', 'benji.alors@fezhddj.fr', '2021-12-22', './images/forum/22/jostophe.PNG', 0),
(25, 'exemple23', '$2y$10$Z3LJscdqAOV6SzRFVPCgbu4bKgptEXFhztDEInl/r.OiWZpouepSK', 'kevinlebot23@gmail.com', '2021-12-26', 'https://www.cournondanseattitude.fr/wp-content/uploads/2019/07/blank-profile-picture-973460_640.png', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
