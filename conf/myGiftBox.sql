-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mar. 06 nov. 2018 à 09:57
-- Version du serveur :  10.1.36-MariaDB
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `fierrolo1u`
--

-- --------------------------------------------------------

--
-- Structure de la table `MGB_body`
--

CREATE TABLE `MGB_body` (
  `id` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL,
  `idCart` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MGB_cart`
--

CREATE TABLE `MGB_cart` (
  `id` int(11) NOT NULL,
  `dateCreation` date NOT NULL,
  `dateDisponible` date NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MGB_categorie`
--

CREATE TABLE `MGB_categorie` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `MGB_categorie`
--

INSERT INTO `MGB_categorie` (`id`, `nom`) VALUES
(1, 'Attention'),
(2, 'Activité'),
(3, 'Restauration'),
(4, 'Hébergement');

-- --------------------------------------------------------

--
-- Structure de la table `MGB_order`
--

CREATE TABLE `MGB_order` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idCart` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MGB_prestation`
--

CREATE TABLE `MGB_prestation` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `descr` text NOT NULL,
  `cat_id` int(11) NOT NULL,
  `img` text NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `prix` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `MGB_prestation`
--

INSERT INTO `MGB_prestation` (`id`, `nom`, `descr`, `cat_id`, `img`, `state`, `prix`) VALUES
(1, 'Champagne', 'Bouteille de champagne + flutes + jeux à gratter', 1, 'champagne.jpg', 1, '20.00'),
(2, 'Musique', 'Partitions de piano à 4 mains', 1, 'musique.jpg', 1, '25.00'),
(3, 'Exposition', 'Visite guidée de l’exposition ‘REGARDER’ à la galerie Poirel', 2, 'poirelregarder.jpg', 1, '14.00'),
(4, 'Goûter', 'Goûter au FIFNL', 3, 'gouter.jpg', 1, '20.00'),
(5, 'Projection', 'Projection courts-métrages au FIFNL', 2, 'film.jpg', 1, '10.00'),
(6, 'Bouquet', 'Bouquet de roses et Mots de Marion Renaud', 1, 'rose.jpg', 1, '16.00'),
(7, 'Diner Stanislas', 'Diner à La Table du Bon Roi Stanislas (Apéritif /Entrée / Plat / Vin / Dessert / Café / Digestif)', 3, 'bonroi.jpg', 1, '60.00'),
(8, 'Origami', 'Baguettes magiques en Origami en buvant un thé', 3, 'origami.jpg', 1, '12.00'),
(9, 'Livres', 'Livre bricolage avec petits-enfants + Roman', 1, 'bricolage.jpg', 1, '24.00'),
(10, 'Diner  Grand Rue ', 'Diner au Grand’Ru(e) (Apéritif / Entrée / Plat / Vin / Dessert / Café)', 3, 'grandrue.jpg', 1, '59.00'),
(11, 'Visite guidée', 'Visite guidée personnalisée de Saint-Epvre jusqu’à Stanislas', 2, 'place.jpg', 1, '11.00'),
(12, 'Bijoux', 'Bijoux de manteau + Sous-verre pochette de disque + Lait après-soleil', 1, 'bijoux.jpg', 1, '29.00'),
(13, 'Opéra', 'Concert commenté à l’Opéra', 2, 'opera.jpg', 1, '15.00'),
(14, 'Thé Hotel de la reine', 'Thé de debriefing au bar de l’Hotel de la reine', 3, 'hotelreine.gif', 1, '5.00'),
(15, 'Jeu connaissance', 'Jeu pour faire connaissance', 2, 'connaissance.jpg', 1, '6.00'),
(16, 'Diner', 'Diner (Apéritif / Plat / Vin / Dessert / Café)', 3, 'diner.jpg', 1, '40.00'),
(17, 'Cadeaux individuels', 'Cadeaux individuels sur le thème de la soirée', 1, 'cadeaux.jpg', 1, '13.00'),
(18, 'Animation', 'Activité animée par un intervenant extérieur', 2, 'animateur.jpg', 1, '9.00'),
(19, 'Jeu contacts', 'Jeu pour échange de contacts', 2, 'contact.png', 1, '5.00'),
(20, 'Cocktail', 'Cocktail de fin de soirée', 3, 'cocktail.jpg', 1, '12.00'),
(21, 'Star Wars', 'Star Wars - Le Réveil de la Force. Séance cinéma 3D', 2, 'starwars.jpg', 1, '12.00'),
(22, 'Concert', 'Un concert à Nancy', 2, 'concert.jpg', 1, '17.00'),
(23, 'Appart Hotel', 'Appart’hôtel Coeur de Ville, en plein centre-ville', 4, 'apparthotel.jpg', 1, '56.00'),
(24, 'Hôtel d\'Haussonville', 'Hôtel d\'Haussonville, au coeur de la Vieille ville à deux pas de la place Stanislas', 4, 'hotel_haussonville_logo.jpg', 1, '169.00'),
(25, 'Boite de nuit', 'Discothèque, Boîte tendance avec des soirées à thème & DJ invités', 2, 'boitedenuit.jpg', 1, '32.00'),
(26, 'Planètes Laser', 'Laser game : Gilet électronique et pistolet laser comme matériel, vous voilà équipé.', 2, 'laser.jpg', 1, '15.00'),
(27, 'Fort Aventure', 'Découvrez Fort Aventure à Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut à l\'élastique inversé, Toboggan géant... et bien plus encore.', 2, 'fort.jpg', 1, '25.00');

-- --------------------------------------------------------

--
-- Structure de la table `MGB_user`
--

CREATE TABLE `MGB_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `typeUser` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `MGB_user`
--

INSERT INTO `MGB_user` (`id`, `username`, `password`, `name`, `lastName`, `email`, `typeUser`) VALUES
(1, 'ruben96', '123456789', 'Ruben', 'Conde', 'ruben@mail.com', 0),
(2, 'pauline94', '123456789', 'Pauline', 'Monteil', 'pauline@mail.com', 1),
(3, 'jalil98', '123456789', 'Jalil', 'Fierro', 'jalil@mail.com', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `MGB_body`
--
ALTER TABLE `MGB_body`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPrestation` (`idPrestation`,`idCart`),
  ADD KEY `idCart` (`idCart`);

--
-- Index pour la table `MGB_cart`
--
ALTER TABLE `MGB_cart`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `MGB_categorie`
--
ALTER TABLE `MGB_categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `MGB_order`
--
ALTER TABLE `MGB_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`,`idCart`),
  ADD KEY `idCart` (`idCart`);

--
-- Index pour la table `MGB_prestation`
--
ALTER TABLE `MGB_prestation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Index pour la table `MGB_user`
--
ALTER TABLE `MGB_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `MGB_body`
--
ALTER TABLE `MGB_body`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `MGB_cart`
--
ALTER TABLE `MGB_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `MGB_categorie`
--
ALTER TABLE `MGB_categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `MGB_order`
--
ALTER TABLE `MGB_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `MGB_prestation`
--
ALTER TABLE `MGB_prestation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `MGB_user`
--
ALTER TABLE `MGB_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `MGB_body`
--
ALTER TABLE `MGB_body`
  ADD CONSTRAINT `MGB_body_ibfk_1` FOREIGN KEY (`idPrestation`) REFERENCES `MGB_prestation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MGB_body_ibfk_2` FOREIGN KEY (`idCart`) REFERENCES `MGB_cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `MGB_order`
--
ALTER TABLE `MGB_order`
  ADD CONSTRAINT `MGB_order_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `MGB_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MGB_order_ibfk_2` FOREIGN KEY (`idCart`) REFERENCES `MGB_cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `MGB_prestation`
--
ALTER TABLE `MGB_prestation`
  ADD CONSTRAINT `MGB_prestation_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `MGB_categorie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
