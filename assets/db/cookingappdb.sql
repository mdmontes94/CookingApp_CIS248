-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 21, 2025 at 04:02 AM
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
-- Table structure for table `ca_favorites`
--

DROP TABLE IF EXISTS `ca_favorites`;
CREATE TABLE IF NOT EXISTS `ca_favorites` (
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `favorite_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`favorite_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `Ing_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Ing_Name` varchar(30) NOT NULL,
  `Ing_Allergy` int(11) NOT NULL,
  `Ing_category` int(11) NOT NULL,
  PRIMARY KEY (`Ing_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_ingredients`
--

INSERT INTO `ca_ingredients` (`Ing_ID`, `Ing_Name`, `Ing_Allergy`, `Ing_category`) VALUES
(1, 'Milk', 9, 2),
(2, 'Flour', 4, 0),
(3, 'Butter', 9, 6),
(4, 'Egg', 1, 5),
(5, 'Rice', 0, 0),
(6, 'Onion', 0, 3),
(7, 'Sugar', 0, 1),
(8, 'Salt', 0, 1),
(9, 'Tomato', 0, 4),
(10, 'Pepper', 0, 1),
(11, 'Lemon', 0, 4),
(12, 'Chicken Breast', 0, 5),
(13, 'Ground Beef', 0, 5),
(14, 'Sausage', 0, 5),
(15, 'White Rice', 0, 0),
(16, 'White Bread', 4, 0),
(17, 'Peanut Butter', 2, 5),
(18, 'Corn', 0, 3),
(19, 'Potato', 0, 3),
(20, 'Garlic', 0, 3),
(21, 'Beef Chuck', 0, 5),
(22, 'Yellow Onion', 0, 3),
(23, 'Carrot', 0, 3),
(24, 'Worcestershire Sauce', 0, 1),
(25, 'Tomato Paste', 0, 3),
(26, 'Chicken Broth', 0, 5),
(27, 'Pie Crust', 4, 0);

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
  `cook_time` varchar(30) NOT NULL,
  PRIMARY KEY (`recipe_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_recipes`
--

INSERT INTO `ca_recipes` (`recipe_id`, `name`, `ingredients`, `instructions`, `difficulty`, `cook_time`) VALUES
(1, 'Burgers', 0, 'Mix seasonings and raw beef and then form into patties.  Preheat skillet with oil and then place the patties onto it and cook until they\'re as done as you desire. Place them on the bun with toppings and serve.', 1, '15 Minutes'),
(2, 'Easy Beef Stew', 1, 'Preheat oven to 325° F.\r\n1. Chop carrots, potatoes, and onions\r\n2. Season the beef chunks with salt and pepper.  Sprinkle the flour over and toss the seasoned beef to coat it on all sides.\r\n3. Heat the olive oil in a skillet over medium heat.  Brown the beef on all sides for 3-4 minutes.\r\n4. Add the onions, garlic, and carrots over the beef.\r\n5. Cook everything for 2-3 or until lightly browned.\r\n6. add the potatoes, beef broth, tomato paste, bay leaf, thyme, and Worcestershire sauce to a pot.\r\n7. Bring the mixture to a simmer and return the beef to it.\r\n8. Cover the pot and place it into the oven.  Cook for 2-2.5 hours.  Taste and season with salt and pepper if needed.', 1, '2 Hours'),
(3, 'Chicken Pot Pie', 3, '1. Cook and shred the chicken.  Press your pie crust into the bottom of a pie plate.\r\n2.  Melt butter in a saucepan over medium heat.  Add chopped onion and cook until it\'s translucent.  Whisk in flour, salt, and pepper until thick then gradually add in broth and milk while stirring until thick.\r\n3. Stir in the chicken and vegetables.  Pour into the pie crust and then cover the top with another crust.  Pinch the edges together and cut vents in the top.\r\n4. Bake at 425 for 30-40 minutes or until the crust is golden brown.  Let stand for 5 minutes.', 3, '1 hour 5 Minutes');

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
(2, 10, 1, 'tbsp'),
(2, 8, 1, 'tbsp'),
(2, 21, 1, 'Pound'),
(1, 24, 1, 'tbsp'),
(1, 6, 0.5, 'Cups'),
(1, 8, 1, 'tsp'),
(1, 10, 1, 'tsp'),
(1, 20, 1, 'Clove'),
(1, 13, 1, 'Pound'),
(2, 2, 1, 'Cup'),
(2, 22, 1, 'Cup'),
(2, 23, 1, 'Cup'),
(2, 19, 1, 'cup'),
(2, 24, 1, 'tbsp'),
(2, 25, 2, 'Cups'),
(3, 27, 1, 'Box'),
(3, 3, 0.75, 'Cup'),
(3, 6, 0.75, 'Cup'),
(3, 2, 0.75, 'Cup'),
(3, 8, 0.5, 'tsp'),
(3, 10, 0.25, 'tsp'),
(3, 26, 1.75, 'Cup'),
(3, 1, 0.5, 'Cup'),
(3, 12, 2.5, 'Cups'),
(3, 6, 0.5, 'Cup'),
(3, 20, 0.5, 'tbsp'),
(3, 18, 0.5, 'Cup'),
(3, 10, 0.25, 'Cup');

-- --------------------------------------------------------

--
-- Table structure for table `ca_users`
--

DROP TABLE IF EXISTS `ca_users`;
CREATE TABLE IF NOT EXISTS `ca_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL,
  `password_hash` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_users`
--

INSERT INTO `ca_users` (`user_id`, `username`, `email`, `password_hash`, `created_date`) VALUES
(1, 'Remnel', 'jacob.jorgensen92@gmail.com', '$2y$10$Lb3HJjMCso4.GJE14TTvZO2FzfDvxX/lenEmuINfYsrgeDUGm5aWq', '2025-07-19 03:06:40');

-- --------------------------------------------------------

--
-- Table structure for table `ca_user_pantry`
--

DROP TABLE IF EXISTS `ca_user_pantry`;
CREATE TABLE IF NOT EXISTS `ca_user_pantry` (
  `entry_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  PRIMARY KEY (`entry_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
