USE my_citizenroom;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Structure de la table `citizenroom_subscription`
--

CREATE TABLE IF NOT EXISTS `citizenroom_subscription` (
  `room_id` int(10) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `creation_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `citizenroom_theme` (
  `room_id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `info` varchar(50) NOT NULL,
  `image` varchar(2048) NOT NULL,
  `bg_image` varchar(2048) NOT NULL,
  `bg_image_link` varchar(2048) NOT NULL,
  `bg_image_author` varchar(255) NOT NULL,
  `bg_image_author_link` varchar(2048) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
