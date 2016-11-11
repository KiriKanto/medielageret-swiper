-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Vært: 127.0.0.1
-- Genereringstid: 22. 08 2016 kl. 10:10:39
-- Serverversion: 5.6.16
-- PHP-version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `medielageret`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat__Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat__Name` varchar(100) COLLATE utf8_danish_ci NOT NULL,
  PRIMARY KEY (`cat__Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=6 ;

--
-- Data dump for tabellen `categories`
--

INSERT INTO `categories` (`cat__Id`, `cat__Name`) VALUES
(1, 'Action'),
(2, 'Thriller'),
(3, 'Romance'),
(4, 'Drama'),
(5, 'Comedy');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `cat__prod`
--

CREATE TABLE IF NOT EXISTS `cat__prod` (
  `cat__Prod__Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk__Categories__Id` int(10) unsigned NOT NULL,
  `fk__Product__Id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cat__Prod__Id`),
  KEY `fk__Categories__Id` (`fk__Categories__Id`,`fk__Product__Id`),
  KEY `fk__Product__Id` (`fk__Product__Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=19 ;

--
-- Data dump for tabellen `cat__prod`
--

INSERT INTO `cat__prod` (`cat__Prod__Id`, `fk__Categories__Id`, `fk__Product__Id`) VALUES
(2, 1, 1),
(3, 1, 3),
(5, 1, 5),
(1, 2, 1),
(18, 2, 2),
(7, 2, 7),
(8, 2, 8),
(14, 2, 14),
(16, 2, 16),
(4, 3, 4),
(11, 3, 11),
(6, 4, 6),
(12, 4, 12),
(13, 4, 13),
(9, 5, 9),
(10, 5, 10),
(15, 5, 15),
(17, 5, 17);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `genre`
--

CREATE TABLE IF NOT EXISTS `genre` (
  `genre__Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `genre__Name` varchar(100) COLLATE utf8_danish_ci NOT NULL,
  PRIMARY KEY (`genre__Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=6 ;

--
-- Data dump for tabellen `genre`
--

INSERT INTO `genre` (`genre__Id`, `genre__Name`) VALUES
(1, 'Action'),
(2, 'Drama'),
(3, 'Romance'),
(4, 'Crime'),
(5, 'Comedy');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `genre__prod`
--

CREATE TABLE IF NOT EXISTS `genre__prod` (
  `genre__Prod__Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk__Genre__Id` int(10) unsigned NOT NULL,
  `fk__Product__Id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`genre__Prod__Id`),
  KEY `fk__Genre__Id` (`fk__Genre__Id`,`fk__Product__Id`),
  KEY `fk__Product__Id` (`fk__Product__Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `img__Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img__Name` varchar(150) COLLATE utf8_danish_ci NOT NULL,
  `img__Status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = active 0 =not active',
  PRIMARY KEY (`img__Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order__Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order__Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order__Total` float unsigned NOT NULL,
  `order__Vat` float unsigned NOT NULL,
  `fk__User__Id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`order__Id`),
  KEY `fk__User__Id` (`fk__User__Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `producer`
--

CREATE TABLE IF NOT EXISTS `producer` (
  `producer__Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `producer__Name` varchar(100) COLLATE utf8_danish_ci NOT NULL,
  PRIMARY KEY (`producer__Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=3 ;

--
-- Data dump for tabellen `producer`
--

INSERT INTO `producer` (`producer__Id`, `producer__Name`) VALUES
(1, 'Paramount'),
(2, 'Universal');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product__Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product__Status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1= active 0= not active',
  `product__Img` varchar(100) COLLATE utf8_danish_ci NOT NULL,
  `product__Name` varchar(100) COLLATE utf8_danish_ci NOT NULL,
  `product__Price` int(10) unsigned NOT NULL,
  `product__Desc` text COLLATE utf8_danish_ci NOT NULL,
  `product__Stock` int(10) unsigned NOT NULL,
  `fk__Producer__Id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`product__Id`),
  KEY `fk__Producer__Id` (`fk__Producer__Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=18 ;

--
-- Data dump for tabellen `products`
--

INSERT INTO `products` (`product__Id`, `product__Status`, `product__Img`, `product__Name`, `product__Price`, `product__Desc`, `product__Stock`, `fk__Producer__Id`) VALUES
(1, 1, 'abraham-lincoln-vampire-hunter.jpg', 'Abraham Lincoln Vampire Hunter', 82, 'orem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 100, 2),
(2, 1, 'alienmassacre.jpg', 'Naked Alien Massacre', 50, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 50, 1),
(3, 1, 'american_ultra.jpg', 'American Ultra', 200, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 150, 2),
(4, 1, 'breakfastclub.jpg', 'Breakfast Club', 45, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 20, 1),
(5, 1, 'crank.jpg', 'Crank', 500, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 10, 2),
(6, 1, 'Criminal.jpg', 'Criminal', 120, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 44, 1),
(7, 1, 'daybreakers.jpg', 'Daybreakers', 666, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 66, 1),
(8, 1, 'Dirty_Grandpa.jpg', 'Dirty Grandpa', 55, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 42, 2),
(9, 1, 'end-of-watch.jpg', 'End of Watch', 90, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 33, 2),
(10, 1, 'grey-movie-poster.jpg', 'The Grey', 230, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 54, 2),
(11, 1, 'j-edgar.jpg', 'J.Edgar', 250, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 50, 2),
(12, 1, 'last_stand.jpg', 'Last Stand', 500, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 400, 2),
(13, 1, 'Lost-in-Translation.jpg', 'Lost in translation', 554, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 32, 1),
(14, 1, 'the-american.jpg', 'The American', 77, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 56, 1),
(15, 1, 'the-judge.jpg', 'The Judge', 45, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 44, 1),
(16, 1, 'watchmen.jpg', 'Watchmen', 888, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 500, 2),
(17, 1, 'wtf_india.jpg', 'Man in cardigan', 1, '	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.Aenean vulputate eleifend tellus.Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.', 1111, 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `product__images`
--

CREATE TABLE IF NOT EXISTS `product__images` (
  `prod__Img__Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk__Prod__Id` int(10) unsigned NOT NULL,
  `fk__Img__Id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`prod__Img__Id`),
  KEY `fk__Prod__Id` (`fk__Prod__Id`,`fk__Img__Id`),
  KEY `fk__Img__Id` (`fk__Img__Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `prod__orders`
--

CREATE TABLE IF NOT EXISTS `prod__orders` (
  `prod__Order__Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prod__Order__Quantity` int(10) unsigned NOT NULL,
  `prod__Current__Price` int(10) unsigned NOT NULL,
  `fk__Order__Id` int(10) unsigned NOT NULL,
  `fk__Product__Id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`prod__Order__Id`),
  KEY `fk__Order__Id` (`fk__Order__Id`,`fk__Product__Id`),
  KEY `fk__Product__Id` (`fk__Product__Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `prod__variant`
--

CREATE TABLE IF NOT EXISTS `prod__variant` (
  `prod__Variant__Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk__Prod__Id` int(10) unsigned NOT NULL,
  `fk__Variant__Id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`prod__Variant__Id`),
  KEY `fk__Prod__Id` (`fk__Prod__Id`,`fk__Variant__Id`),
  KEY `fk__Variant__Id` (`fk__Variant__Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=36 ;

--
-- Data dump for tabellen `prod__variant`
--

INSERT INTO `prod__variant` (`prod__Variant__Id`, `fk__Prod__Id`, `fk__Variant__Id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 1),
(5, 2, 2),
(6, 2, 3),
(7, 3, 1),
(8, 3, 2),
(9, 3, 3),
(10, 4, 2),
(11, 4, 3),
(12, 5, 1),
(13, 5, 2),
(14, 6, 1),
(15, 6, 2),
(16, 6, 3),
(17, 7, 3),
(18, 8, 3),
(19, 9, 1),
(20, 9, 2),
(21, 9, 3),
(22, 10, 1),
(23, 10, 2),
(24, 10, 3),
(25, 11, 3),
(27, 12, 1),
(26, 12, 2),
(28, 12, 3),
(29, 13, 1),
(30, 13, 2),
(31, 14, 2),
(32, 14, 3),
(33, 15, 1),
(34, 16, 1),
(35, 17, 3);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `role__Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role__Lvl` int(10) unsigned NOT NULL,
  `role__Name` varchar(50) COLLATE utf8_danish_ci NOT NULL,
  PRIMARY KEY (`role__Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user__Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user__Mail` varchar(70) COLLATE utf8_danish_ci NOT NULL,
  `user__Hash` varchar(64) COLLATE utf8_danish_ci NOT NULL,
  `user__Salt` varchar(16) COLLATE utf8_danish_ci NOT NULL,
  `user__Adress` varchar(50) COLLATE utf8_danish_ci NOT NULL,
  `user__Phone` varchar(11) COLLATE utf8_danish_ci NOT NULL,
  `user__Zip` int(4) unsigned NOT NULL,
  `user__City` varchar(50) COLLATE utf8_danish_ci NOT NULL,
  `user__Country` varchar(50) COLLATE utf8_danish_ci NOT NULL,
  `fk__Role__Id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user__Id`),
  KEY `fk__Role__Id` (`fk__Role__Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `variants`
--

CREATE TABLE IF NOT EXISTS `variants` (
  `variant__Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `variant__Name` varchar(100) COLLATE utf8_danish_ci NOT NULL,
  PRIMARY KEY (`variant__Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=4 ;

--
-- Data dump for tabellen `variants`
--

INSERT INTO `variants` (`variant__Id`, `variant__Name`) VALUES
(1, 'Blu-Ray'),
(2, 'DVD'),
(3, 'Digital Download');

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `cat__prod`
--
ALTER TABLE `cat__prod`
  ADD CONSTRAINT `cat__prod_ibfk_1` FOREIGN KEY (`fk__Product__Id`) REFERENCES `products` (`product__Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cat__prod_ibfk_2` FOREIGN KEY (`fk__Categories__Id`) REFERENCES `categories` (`cat__Id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `genre__prod`
--
ALTER TABLE `genre__prod`
  ADD CONSTRAINT `genre__prod_ibfk_1` FOREIGN KEY (`fk__Genre__Id`) REFERENCES `genre` (`genre__Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `genre__prod_ibfk_2` FOREIGN KEY (`fk__Product__Id`) REFERENCES `products` (`product__Id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`fk__User__Id`) REFERENCES `users` (`user__Id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`fk__Producer__Id`) REFERENCES `producer` (`producer__Id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `product__images`
--
ALTER TABLE `product__images`
  ADD CONSTRAINT `product__images_ibfk_1` FOREIGN KEY (`fk__Img__Id`) REFERENCES `images` (`img__Id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `product__images_ibfk_2` FOREIGN KEY (`fk__Prod__Id`) REFERENCES `products` (`product__Id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `prod__orders`
--
ALTER TABLE `prod__orders`
  ADD CONSTRAINT `prod__orders_ibfk_1` FOREIGN KEY (`fk__Product__Id`) REFERENCES `products` (`product__Id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `prod__orders_ibfk_2` FOREIGN KEY (`fk__Order__Id`) REFERENCES `orders` (`order__Id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `prod__variant`
--
ALTER TABLE `prod__variant`
  ADD CONSTRAINT `prod__variant_ibfk_1` FOREIGN KEY (`fk__Variant__Id`) REFERENCES `variants` (`variant__Id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `prod__variant_ibfk_2` FOREIGN KEY (`fk__Prod__Id`) REFERENCES `products` (`product__Id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`fk__Role__Id`) REFERENCES `role` (`role__Id`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
