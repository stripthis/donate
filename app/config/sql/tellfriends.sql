
DROP TABLE IF EXISTS `tellfriends`;
CREATE TABLE `tellfriends` (
  `id` int(255) NOT NULL auto_increment,
  `user_id` char(36) NOT NULL,
  `receiver` text NOT NULL,
  `content` text NOT NULL,
  `ip` varchar(255) NOT NULL,
  `time_sent` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `sent` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;


--
-- Table structure for table `invited_friends`
--

DROP TABLE IF EXISTS `invited_friends`;
CREATE TABLE `invited_friends` (
  `id` int(34) NOT NULL auto_increment,
  `tellfriend_id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `registered` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;