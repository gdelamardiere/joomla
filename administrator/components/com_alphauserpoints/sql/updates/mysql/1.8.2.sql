CREATE TABLE IF NOT EXISTS `#__alpha_userpoints_template_invite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(100) NOT NULL DEFAULT '',
  `category` int(11) NOT NULL DEFAULT '1',
  `emailsubject` varchar(255) NOT NULL DEFAULT '',
  `emailbody` text NOT NULL DEFAULT '',
  `emailformat` tinyint(1) NOT NULL DEFAULT '1',
  `bcc2admin` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;