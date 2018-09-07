CREATE TABLE `students` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstName` varchar(60) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `groupNum` varchar(5) NOT NULL,
  `email` varchar(120) NOT NULL,
  `points` int(3) NOT NULL,
  `year` year(4) NOT NULL,
  `residence` enum('resident','nonresident') NOT NULL,
  `token` varchar(64) NOT NULL COMMENT 'token for auth',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `students`
VALUES (1,'test','test','male','test','test@example.com',200,2000,'resident','4f0633b7cb2va6b0a743fbb50a220de2');
