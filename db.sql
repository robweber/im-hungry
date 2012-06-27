-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306

-- Generation Time: Jun 27, 2012 at 09:32 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `imhungry`
--

-- --------------------------------------------------------

--
-- Table structure for table `food_item`
--

CREATE TABLE `food_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `food_item`
--

INSERT INTO `food_item` (`id`, `name`, `quantity`, `location_id`) VALUES
(1, 'Ketchup', 1, 10),
(2, 'Milk', 1, 10),
(3, 'Plain Chips', 5, 10),
(4, 'Pizza', 1, 10),
(5, 'Pizza Dough', 1, 2),
(6, 'Pizza Sauce', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `recipe_id`, `quantity`, `name`) VALUES
(1, 1, 1, 'Duck'),
(2, 1, 1, 'Pizza'),
(3, 1, 2, 'Ketchup'),
(4, 2, 1, 'Pizza Sauce'),
(6, 2, 1, 'Pizza Dough');

-- --------------------------------------------------------

--
-- Table structure for table `pantry_locations`
--

CREATE TABLE `pantry_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `pantry_locations`
--

INSERT INTO `pantry_locations` (`id`, `name`) VALUES
(1, 'Cupboard'),
(2, 'Refridgerator'),
(10, 'Freezer');

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`id`, `name`, `type_id`) VALUES
(1, 'Roasted Duck', 3),
(2, 'Homemade Pizza', 3);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_types`
--

CREATE TABLE `recipe_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `recipe_types`
--

INSERT INTO `recipe_types` (`id`, `name`) VALUES
(1, 'Breakfast'),
(2, 'Lunch'),
(3, 'Dinner');