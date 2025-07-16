-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 16, 2025 at 04:26 PM
-- Server version: 5.7.40
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cookingappdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ca_allergies`
--

DROP TABLE IF EXISTS `ca_allergies`;
CREATE TABLE IF NOT EXISTS `ca_allergies` (
  `allergy_ID` int(11) NOT NULL,
  `allergy_name` varchar(40) NOT NULL,
  PRIMARY KEY (`allergy_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_allergies`
--

INSERT INTO `ca_allergies` (`allergy_ID`, `allergy_name`) VALUES
(9, 'Milk'),
(1, 'Egg'),
(2, 'Peanut'),
(3, 'Soy'),
(4, 'Wheat'),
(5, 'Tree Nut'),
(6, 'Shellfish'),
(7, 'Fish'),
(8, 'Sesame'),
(0, 'None');

-- --------------------------------------------------------

--
-- Table structure for table `ca_ingcategory`
--

DROP TABLE IF EXISTS `ca_ingcategory`;
CREATE TABLE IF NOT EXISTS `ca_ingcategory` (
  `ing_cat_id` int(11) NOT NULL,
  `ing_cat_name` varchar(30) NOT NULL,
  PRIMARY KEY (`ing_cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_ingcategory`
--

INSERT INTO `ca_ingcategory` (`ing_cat_id`, `ing_cat_name`) VALUES
(0, 'Grain'),
(1, 'Seasoning'),
(2, 'Dairy'),
(3, 'Vegetable'),
(4, 'Fruit'),
(5, 'Protein'),
(6, 'Fat');

-- --------------------------------------------------------

--
-- Table structure for table `ca_ingredients`
--

DROP TABLE IF EXISTS `ca_ingredients`;
CREATE TABLE IF NOT EXISTS `ca_ingredients` (
  `Ing_ID` int(11) NOT NULL,
  `Ing_Name` varchar(30) NOT NULL,
  `Ing_Allergy` int(11) NOT NULL,
  `Ing_category` int(11) NOT NULL,
  PRIMARY KEY (`Ing_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_ingredients`
--

INSERT INTO `ca_ingredients` (`Ing_ID`, `Ing_Name`, `Ing_Allergy`, `Ing_category`) VALUES
(0, 'Milk', 9, 2),
(1, 'Flour', 4, 0),
(2, 'Butter', 9, 6),
(3, 'Egg', 1, 5),
(4, 'Rice', 0, 0),
(5, 'Onion', 0, 3),
(6, 'Sugar', 0, 1),
(7, 'Salt', 0, 1),
(8, 'Tomato', 0, 4),
(9, 'Pepper', 0, 1),
(10, 'Lemon', 0, 4),
(11, 'Chicken Breast', 0, 5),
(12, 'Ground Beef', 0, 5),
(13, 'Sausage', 0, 5),
(14, 'White Rice', 0, 0),
(15, 'White Bread', 4, 0),
(16, 'Peanut Butter', 2, 5),
(17, 'Corn', 0, 3),
(18, 'Potato', 0, 3),
(19, 'Garlic', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `ca_recipes`
--

DROP TABLE IF EXISTS `ca_recipes`;
CREATE TABLE IF NOT EXISTS `ca_recipes` (
  `recipe_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `ingredients` int(11) NOT NULL COMMENT 'FK to recipe_ingredients',
  `instructions` varchar(2000) NOT NULL,
  `difficulty` int(11) NOT NULL,
  `cook_time` int(11) NOT NULL,
  PRIMARY KEY (`recipe_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_recipes`
--

INSERT INTO `ca_recipes` (`recipe_id`, `name`, `ingredients`, `instructions`, `difficulty`, `cook_time`) VALUES
(1, 'Burgers', 0, 'Mix seasonings and raw beef and then form into patties.  Preheat skillet with oil and then place the patties onto it and cook until they\'re as done as you desire. Place them on the bun with toppings and serve.', 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `ca_recipe_ingredients`
--

DROP TABLE IF EXISTS `ca_recipe_ingredients`;
CREATE TABLE IF NOT EXISTS `ca_recipe_ingredients` (
  `recipe_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `unit` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_recipe_ingredients`
--

INSERT INTO `ca_recipe_ingredients` (`recipe_id`, `ingredient_id`, `quantity`, `unit`) VALUES
(1, 19, 1, 'tbsp'),
(1, 12, 1, 'Pound');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
