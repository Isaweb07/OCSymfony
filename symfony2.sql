-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 29 mars 2018 à 16:09
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `symfony2`
--

-- --------------------------------------------------------

--
-- Structure de la table `oc_advert`
--

DROP TABLE IF EXISTS `oc_advert`;
CREATE TABLE IF NOT EXISTS `oc_advert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nb_applications` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B193175989D9B62` (`slug`),
  UNIQUE KEY `UNIQ_B1931753DA5256D` (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `oc_advert`
--

INSERT INTO `oc_advert` (`id`, `image_id`, `date`, `title`, `author`, `content`, `published`, `updated_at`, `nb_applications`, `slug`) VALUES
(1, 4, '2018-03-07 19:49:42', 'Recherche un développeur full stack', 'John', 'Le profil que nous recherchons est exceptionnel', 1, NULL, 1, 'recherche-un-developpeur-full-stack'),
(2, 5, '2018-03-02 19:49:42', 'Recherche un intégrateur web', 'John', 'Vous avez toujours rêvé de développer vos talents, alors nous pouvons vous offrir cela', 1, NULL, 0, 'recherche-un-integrateur-web'),
(3, 3, '2018-03-03 19:49:42', 'Recherche notre lead développeur', 'Alexandre', 'Notre startup est en pleine campagne mais à la pointe de la technologie', 1, NULL, 1, 'recherche-notre-lead-developpeur'),
(4, 2, '2018-03-04 19:49:42', 'Recherche un super référenceur', 'Sandrine', 'Notre startup est en pleine campagne mais à la pointe de la technologie', 1, NULL, 0, 'recherche-un-super-referenceur'),
(5, 1, '2018-03-15 19:49:42', 'Recherche un développeur Symfony', 'John', 'Vous avez toujours rêvé de développer vos talents, alors nous pouvons vous offrir cela', 1, NULL, 1, 'recherche-un-developpeur-symfony'),
(6, 6, '2018-03-17 19:49:42', 'Recherche un développeur PHP confirmé', 'Stéphanie', 'Notre startup est en pleine campagne mais à la pointe de la technologie', 1, NULL, 1, 'recherche-un-developpeur-php-confirme'),
(7, 8, '2018-03-19 19:49:42', 'Recherche un webmaster de génie', 'Josette', 'Notre startup est en pleine campagne mais à la pointe de la technologie', 1, NULL, 1, 'recherche-un-webmaster-de-genie'),
(8, 7, '2018-03-19 19:49:42', 'Recherche un développeur Android', 'Pierre', 'Dans notre entreprise vous vous sentirez comme un poisson dans l\\eau', 1, NULL, 0, 'recherche-un-developpeur-android'),
(9, 9, '2018-03-28 19:49:42', 'Recherche le développeur web de l\'année', 'Sandrine', 'Nous avons une mission pour vous', 1, NULL, 2, 'recherche-le-developpeur-web-de-lannee'),
(10, 10, '2018-03-24 19:49:42', 'Recherche un cuisinier du web', 'Josette', 'Vous avez toujours rêvé de développer vos talents, alors nous pouvons vous offrir cela', 1, NULL, 0, 'recherche-un-cuisinier-du-web');

-- --------------------------------------------------------

--
-- Structure de la table `oc_advert_category`
--

DROP TABLE IF EXISTS `oc_advert_category`;
CREATE TABLE IF NOT EXISTS `oc_advert_category` (
  `advert_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`advert_id`,`category_id`),
  KEY `IDX_435EA006D07ECCB6` (`advert_id`),
  KEY `IDX_435EA00612469DE2` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `oc_advert_category`
--

INSERT INTO `oc_advert_category` (`advert_id`, `category_id`) VALUES
(1, 6),
(1, 8),
(2, 8),
(2, 9),
(3, 6),
(4, 10),
(5, 6),
(5, 8),
(9, 6),
(10, 6);

-- --------------------------------------------------------

--
-- Structure de la table `oc_advert_skill`
--

DROP TABLE IF EXISTS `oc_advert_skill`;
CREATE TABLE IF NOT EXISTS `oc_advert_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `advert_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `level` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_32EFF25BD07ECCB6` (`advert_id`),
  KEY `IDX_32EFF25B5585C142` (`skill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `oc_advert_skill`
--

INSERT INTO `oc_advert_skill` (`id`, `advert_id`, `skill_id`, `level`) VALUES
(1, 1, 8, 'Expert'),
(2, 2, 12, 'Débutant'),
(3, 3, 12, 'Expert'),
(4, 4, 9, 'Confirmé'),
(5, 5, 8, 'Débutant'),
(6, 6, 8, 'Expert'),
(7, 7, 12, 'Intermédiaire'),
(8, 8, 11, 'Débutant'),
(9, 9, 9, 'Expert'),
(10, 10, 8, 'Confirmé');

-- --------------------------------------------------------

--
-- Structure de la table `oc_application`
--

DROP TABLE IF EXISTS `oc_application`;
CREATE TABLE IF NOT EXISTS `oc_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `advert_id` int(11) NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_39F85DD8D07ECCB6` (`advert_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `oc_application`
--

INSERT INTO `oc_application` (`id`, `advert_id`, `author`, `content`, `date`) VALUES
(1, 9, 'Charles', 'J\'ai toujours voulu travailler chez vous', '2018-03-28 13:00:00'),
(2, 9, 'Thomas', 'Je suis la personne qu\'il vous faut', '2018-03-28 07:25:00'),
(3, 1, 'Laurent', 'Ne cherchez plus je suis la personne que vous souhaitez', '2018-03-28 13:09:23'),
(4, 3, 'Léa', 'Je suis fan des technos que vous utilisez', '2018-03-28 05:38:08'),
(5, 6, 'Marine', 'J\'adore ce que vous faites', '2018-03-28 08:11:00'),
(6, 5, 'Elise', 'J\'ai toutes les compétences', '2018-03-28 02:26:00'),
(7, 7, 'Thomas', 'Je suis super motivé', '2018-03-28 10:04:00');

-- --------------------------------------------------------

--
-- Structure de la table `oc_category`
--

DROP TABLE IF EXISTS `oc_category`;
CREATE TABLE IF NOT EXISTS `oc_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `oc_category`
--

INSERT INTO `oc_category` (`id`, `name`) VALUES
(6, 'Développement web'),
(7, 'Développement mobile'),
(8, 'Graphisme'),
(9, 'Intégration'),
(10, 'Réseau');

-- --------------------------------------------------------

--
-- Structure de la table `oc_image`
--

DROP TABLE IF EXISTS `oc_image`;
CREATE TABLE IF NOT EXISTS `oc_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `oc_image`
--

INSERT INTO `oc_image` (`id`, `url`, `alt`) VALUES
(1, 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Creative-Tail-Animal-cat.svg/128px-Creative-Tail-Animal-cat.svg.png', 'chat'),
(2, 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fc/Creative-Tail-Animal-panda.svg/128px-Creative-Tail-Animal-panda.svg.png', 'panda'),
(3, 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d7/Creative-Tail-Animal-shark.svg/128px-Creative-Tail-Animal-shark.svg.png', 'requin'),
(4, 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Creative-Tail-Animal-dog.svg/128px-Creative-Tail-Animal-dog.svg.png', 'chien'),
(5, 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/Creative-Tail-Animal-turtle.svg/128px-Creative-Tail-Animal-turtle.svg.png', 'tortue'),
(6, 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/75/Creative-Tail-Animal-elephant.svg/128px-Creative-Tail-Animal-elephant.svg.png', 'éléphant'),
(7, 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/Creative-Tail-Animal-turtle.svg/128px-Creative-Tail-Animal-turtle.svg.png', 'tortue'),
(8, 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d7/Creative-Tail-Animal-shark.svg/128px-Creative-Tail-Animal-shark.svg.png', 'requin'),
(9, 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fc/Creative-Tail-Animal-panda.svg/128px-Creative-Tail-Animal-panda.svg.png', 'panda'),
(10, 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Creative-Tail-Animal-cat.svg/128px-Creative-Tail-Animal-cat.svg.png', 'chat');

-- --------------------------------------------------------

--
-- Structure de la table `oc_skill`
--

DROP TABLE IF EXISTS `oc_skill`;
CREATE TABLE IF NOT EXISTS `oc_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `oc_skill`
--

INSERT INTO `oc_skill` (`id`, `name`) VALUES
(8, 'PHP'),
(9, 'Symfony'),
(10, 'C++'),
(11, 'Java'),
(12, 'Photoshop'),
(13, 'Blender'),
(14, 'Bloc-note');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `oc_advert`
--
ALTER TABLE `oc_advert`
  ADD CONSTRAINT `FK_B1931753DA5256D` FOREIGN KEY (`image_id`) REFERENCES `oc_image` (`id`);

--
-- Contraintes pour la table `oc_advert_category`
--
ALTER TABLE `oc_advert_category`
  ADD CONSTRAINT `FK_435EA00612469DE2` FOREIGN KEY (`category_id`) REFERENCES `oc_category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_435EA006D07ECCB6` FOREIGN KEY (`advert_id`) REFERENCES `oc_advert` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `oc_advert_skill`
--
ALTER TABLE `oc_advert_skill`
  ADD CONSTRAINT `FK_32EFF25B5585C142` FOREIGN KEY (`skill_id`) REFERENCES `oc_skill` (`id`),
  ADD CONSTRAINT `FK_32EFF25BD07ECCB6` FOREIGN KEY (`advert_id`) REFERENCES `oc_advert` (`id`);

--
-- Contraintes pour la table `oc_application`
--
ALTER TABLE `oc_application`
  ADD CONSTRAINT `FK_39F85DD8D07ECCB6` FOREIGN KEY (`advert_id`) REFERENCES `oc_advert` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
