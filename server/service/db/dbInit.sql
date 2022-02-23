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
  `serial` varchar(255) NOT NULL DEFAULT 'PUBLIC',
  `creation_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `citizenroom_subscription`
--
ALTER TABLE `citizenroom_subscription`
 ADD PRIMARY KEY (`room_id`,`nickname`,`serial`);
 
 
-- --------------------------------------------------------
--
-- Structure de la table `citizenroom_user`
--
CREATE TABLE IF NOT EXISTS `citizenroom_user` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `mail` VARCHAR(255) NOT NULL,
  `password` VARCHAR(60),
  `serial` VARCHAR(6),
  `name` VARCHAR(120) NOT NULL,
  `surname` VARCHAR(120) NOT NULL,
  `stream_key` VARCHAR(255) NULL,
  `channel_id` VARCHAR(255) NULL,
  `room_mail_notif` INT(1) NOT NULL DEFAULT '0',
  `room_telegram_notif` VARCHAR(255) NULL,
  `creation_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` DATETIME NULL,
  `enabled` INT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Structure de la table `citizenroom_subscription`
--

CREATE TABLE IF NOT EXISTS `citizenroom_business_room` (
  `room_id` int(10) NOT NULL,
  `serial` VARCHAR(6) NOT NULL,
  `title` VARCHAR(255) NULL,
  `logo` VARCHAR(255) NULL,
  `password` varchar(255),
  `withTicket` INT NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour la table `citizenroom_subscription`
--
ALTER TABLE `citizenroom_business_room`
 ADD PRIMARY KEY (`room_id`,`serial`);
 

 --
-- Structure de la table `citizenroom_business_room_ticket`
--
CREATE TABLE IF NOT EXISTS `citizenroom_business_room_ticket` (
  `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `room_id` BIGINT NOT NULL,
  `serial` VARCHAR(6) NOT NULL,
  `nickname` VARCHAR(255) NULL,
  `used` INT NOT NULL DEFAULT '0',
  `hash` VARCHAR(255) NULL,
  `previousHash` VARCHAR(255) NULL,
  `UUID` VARCHAR(255) NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;