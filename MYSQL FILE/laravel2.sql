-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2014 at 05:38 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `laravel2`
--

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE IF NOT EXISTS `days` (
  `iddays` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`iddays`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`iddays`, `name`) VALUES
(1, 'Monday'),
(2, 'Tuesday'),
(3, 'Wednesday'),
(4, 'Thursday'),
(5, 'Friday'),
(6, 'Saturday'),
(7, 'Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `loc_id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_name` varchar(50) NOT NULL,
  PRIMARY KEY (`loc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`loc_id`, `loc_name`) VALUES
(1, 'East Village'),
(2, 'Williamsburg'),
(3, 'Midtown');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_11_18_112433_create-users-table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `idoffers` int(11) NOT NULL AUTO_INCREMENT,
  `offer_content` text,
  `offername` varchar(100) NOT NULL,
  PRIMARY KEY (`idoffers`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`idoffers`, `offer_content`, `offername`) VALUES
(1, 'this offer proveides you item1, item2, item3 and item4 as well', 'offer no:1'),
(2, 'this offer proveides you item5, item2, item3 and item6 as well', 'offer no:2'),
(3, 'this offer proveides you item7, item8, item9 with item4 as complimentthis offer proveides you item7, item8, item9 with item4 as compliment', 'offer no:3'),
(4, 'this offer proveides you item5, item10, item3 and item6 as well', 'offer no:4'),
(5, 'this offer proveides you item15, item10, item13 and item6 as well', 'offer no:5'),
(6, 'this offer proveides you item15, item11, item13 and item12 as well', 'offer no:6'),
(7, 'this offer proveides you item10, item1, item13 and item12 as well', 'offer no:7'),
(8, 'this offer proveides you item1, item14, item16 and item2 as well', 'offer no:8'),
(9, 'this offer proveides you item6, item14, item16 and item8 as well', 'offer no:9'),
(10, 'this offer proveides you item6, item10, item16 and item5 as well', 'offer no:10');

-- --------------------------------------------------------

--
-- Table structure for table `offers_taken`
--

CREATE TABLE IF NOT EXISTS `offers_taken` (
  `ot_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `offer_id` int(11) NOT NULL,
  `starting_at` datetime NOT NULL,
  `ending_at` datetime NOT NULL,
  `taken_at` datetime NOT NULL,
  PRIMARY KEY (`ot_id`),
  KEY `user_id` (`user_id`),
  KEY `offers_taken_ibfk_2` (`offer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `offers_taken`
--

INSERT INTO `offers_taken` (`ot_id`, `user_id`, `offer_id`, `starting_at`, `ending_at`, `taken_at`) VALUES
(5, 3, 2, '2014-11-24 11:00:00', '2014-11-24 16:00:00', '2014-11-20 16:44:16'),
(7, 5, 2, '2014-11-24 11:00:00', '2014-11-24 16:00:00', '2014-11-20 16:57:47');

-- --------------------------------------------------------

--
-- Table structure for table `rel_days_resurantoffers`
--

CREATE TABLE IF NOT EXISTS `rel_days_resurantoffers` (
  `idrel_days_resurantoffers` int(11) NOT NULL AUTO_INCREMENT,
  `resurant_offers_id` int(11) DEFAULT NULL,
  `days_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`idrel_days_resurantoffers`),
  KEY `fk_rel_days_resurantoffers_1_idx` (`resurant_offers_id`),
  KEY `fk_rel_days_resurantoffers_2_idx` (`days_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `rel_days_resurantoffers`
--

INSERT INTO `rel_days_resurantoffers` (`idrel_days_resurantoffers`, `resurant_offers_id`, `days_id`) VALUES
(1, 2, 1),
(2, 2, 4),
(3, 3, 2),
(4, 3, 7),
(5, 4, 1),
(6, 4, 3),
(7, 8, 4),
(8, 8, 6),
(9, 9, 6);

-- --------------------------------------------------------

--
-- Table structure for table `resturants`
--

CREATE TABLE IF NOT EXISTS `resturants` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_name` varchar(50) NOT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `resturants`
--

INSERT INTO `resturants` (`r_id`, `r_name`) VALUES
(1, 'Back Forty'),
(2, 'Momofuku Milk Bar East Village'),
(3, 'Momofuku Noodle Bar'),
(4, 'Downtown Bakery '),
(5, 'Dirt Candy'),
(6, 'Back Forty'),
(7, 'Northern Spy Food Co. '),
(8, 'Peels'),
(9, 'A Chef''s Kitchen'),
(10, 'Fat Canary'),
(11, 'Food For Thought'),
(12, 'Sno-To-Go'),
(13, 'Tony''s Di Napoli'),
(14, 'Junior''s Restaurant ');

-- --------------------------------------------------------

--
-- Table structure for table `resturants_offers`
--

CREATE TABLE IF NOT EXISTS `resturants_offers` (
  `idresturants_offers` int(11) NOT NULL AUTO_INCREMENT,
  `offer_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `resturant_id` int(11) DEFAULT NULL,
  `price` varchar(20) DEFAULT NULL,
  `max_guests` int(11) DEFAULT NULL,
  `min_guests` int(11) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `validity_in_hours` time DEFAULT NULL,
  `active` enum('1','0') DEFAULT NULL COMMENT '1:active, 0:disabled',
  PRIMARY KEY (`idresturants_offers`),
  KEY `fk_resturants_offers_1_idx` (`offer_id`),
  KEY `fk_resturants_offers_2_idx` (`location_id`),
  KEY `fk_resturants_offers_3_idx` (`resturant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `resturants_offers`
--

INSERT INTO `resturants_offers` (`idresturants_offers`, `offer_id`, `location_id`, `resturant_id`, `price`, `max_guests`, `min_guests`, `time`, `validity_in_hours`, `active`) VALUES
(2, 1, 1, 1, '10', 10, 1, '11:00:00', '05:00:00', '1'),
(3, 2, 1, 2, '15', 5, 1, '11:00:00', '09:30:00', '1'),
(4, 3, 2, 8, '13.25', 6, 1, '12:00:00', '03:00:00', '1'),
(5, 4, 2, 9, '15.55', 13, 1, '13:30:00', '01:00:00', '1'),
(6, 5, 3, 13, '25', 5, 1, '22:10:00', '10:00:00', '1'),
(7, 6, 3, 14, '35.26', 8, 1, '11:45:00', '03:00:00', '1'),
(8, 8, 1, 1, '13', 10, 1, '11:00:00', '05:00:00', '1'),
(9, 9, 1, 1, '13', 10, 1, '11:00:00', '05:00:00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `time_of_meal` time NOT NULL,
  `budget` float NOT NULL,
  `location_id` int(11) NOT NULL,
  `no_of_guests` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `time_of_meal`, `budget`, `location_id`, `no_of_guests`, `created_at`, `updated_at`, `remember_token`) VALUES
(3, 'Baljeet', 'Bhinder', 'baljeet.techarays@gmail.com', '$2y$10$kESNsFLPtNOBpdNeIZvDSO9YEYUL6y20MxJt3uPMWmw00GXApdDEe', '11:00:00', 25, 1, 2, '2014-11-19 01:15:00', '2014-11-20 05:48:46', 'bdGX2qi1d05105J6sNNC50kcakOkb8OFemqIj0fUmXBNhUOtpdj8EjoRUMml'),
(4, 'Amritpal', 'Singh', 'amit@singh.com', '$2y$10$kESNsFLPtNOBpdNeIZvDSO9YEYUL6y20MxJt3uPMWmw00GXApdDEe', '11:00:00', 50, 2, 2, '2014-11-19 04:37:29', '2014-11-19 07:28:52', '8tbZIGZKNgZXsrSTiZu4eCm3qWnJu4Cy6V0jWDwXItEPVcNm31WQzXGdM8Bt'),
(5, 'Gagan', 'Chabbra', 'gagan@chabbra.com', '$2y$10$PzdL6HnXDhCmHkqVonjVQenK9jWmhYRR1HbGeoEamDFeedLBgm9tC', '11:00:00', 25, 1, 2, '2014-11-20 05:49:16', '2014-11-20 05:49:16', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `offers_taken`
--
ALTER TABLE `offers_taken`
  ADD CONSTRAINT `offers_taken_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `offers_taken_ibfk_2` FOREIGN KEY (`offer_id`) REFERENCES `resturants_offers` (`idresturants_offers`);

--
-- Constraints for table `rel_days_resurantoffers`
--
ALTER TABLE `rel_days_resurantoffers`
  ADD CONSTRAINT `fk_rel_days_resurantoffers_1` FOREIGN KEY (`resurant_offers_id`) REFERENCES `resturants_offers` (`idresturants_offers`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rel_days_resurantoffers_2` FOREIGN KEY (`days_id`) REFERENCES `days` (`iddays`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `resturants_offers`
--
ALTER TABLE `resturants_offers`
  ADD CONSTRAINT `fk_resturants_offers_1` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`idoffers`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_resturants_offers_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`loc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_resturants_offers_3` FOREIGN KEY (`resturant_id`) REFERENCES `resturants` (`r_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
