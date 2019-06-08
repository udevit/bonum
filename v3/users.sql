CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `lastname` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--(1) - 17
--(2) - 18
INSERT INTO `users` (`id`, `name`, `lastname`, `email`, `password`) VALUES
(1, 'Olegario', 'Castellanos G', 'oleg@gmail.com', '$2y$10$9Cc7oV/uxTQorQWEkIT2SOVSlIV8p.7dR6TyEvceQ6CEf2H0Jc3C.'),
(2, 'Maria', 'Juarez J', 'marij@gmail.com', '$2y$10$IurHITPJKXnBcGUNxgPH0uhHuTisuxYl/yDjjImPtAbS9zCVg/Kqa');
