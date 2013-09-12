-- --------------------------------------------------------

--
-- Structure de la table `concours`
--

DROP TABLE IF EXISTS `#__concours`;
CREATE TABLE IF NOT EXISTS `#__concours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(256) NOT NULL,
  `date_fin` datetime NOT NULL,
  `date_debut` datetime DEFAULT NULL,
  `nb_gagnant` int(11) NOT NULL,
  `type_email` enum('-1','0','1') NOT NULL DEFAULT '0',
  `tirage` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `gagnant`
--
DROP TABLE IF EXISTS `#__gagnant`;
CREATE TABLE IF NOT EXISTS `#__gagnant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_concours` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `classement` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gain_concours`
--
DROP TABLE IF EXISTS `#__gain_concours`;
CREATE TABLE IF NOT EXISTS `#__gain_concours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_concours` int(11) NOT NULL,
  `place` int(11) NOT NULL,
  `lot` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--
DROP TABLE IF EXISTS `#__participant`;
CREATE TABLE IF NOT EXISTS `#__participant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_concours` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nb_ligne` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

