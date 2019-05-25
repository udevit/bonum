CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `age` int(11) NOT NULL,
  `salary` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

INSERT INTO `employees` (`id`, `name`, `age`, `salary`) VALUES
(1, 'Gary', 30, 100),
(2, 'Pepe', 45, 20),
(3, 'Marcos', 55, 30),
(5, 'Ximena', 14, 10),
(6, 'Tania', 34, 90),
(7, 'Rosa', 29, 45);