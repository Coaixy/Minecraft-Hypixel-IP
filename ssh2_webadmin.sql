-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.7.28 - MySQL Community Server (GPL)
-- 服务器OS:                        Win64
-- HeidiSQL 版本:                  10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for ssh2_webadmin
CREATE DATABASE IF NOT EXISTS `ssh2_webadmin` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `ssh2_webadmin`;

-- Dumping structure for table ssh2_webadmin.my
CREATE TABLE IF NOT EXISTS `my` (
  `mm` varchar(40) NOT NULL DEFAULT '',
  `dateD` varchar(40) DEFAULT NULL,
  `groupD` varchar(255) DEFAULT NULL,
  `Pr` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mm`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table ssh2_webadmin.user
CREATE TABLE IF NOT EXISTS `user` (
  `usr` varchar(11) NOT NULL DEFAULT '',
  `pwd` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `dateD` date DEFAULT NULL,
  `levelD` varchar(255) DEFAULT NULL,
  `QQ` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `h` varchar(8000) DEFAULT NULL,
  `L` varchar(400) DEFAULT NULL,
  `D` int(1) NOT NULL DEFAULT '0',
  `Pr` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usr`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
