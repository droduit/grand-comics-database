--
-- Structure de la table `story_type`
--

CREATE TABLE IF NOT EXISTS `story_type` (
`id` int(11) NOT NULL,
  `name` varchar(240) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `story_type`
--

INSERT INTO `story_type` (`id`, `name`) VALUES
(1, 'activity'),
(2, 'advertisement'),
(4, 'biography (nonfictional)'),
(5, 'cartoon'),
(6, 'cover'),
(7, 'cover reprint (on interior page)'),
(8, 'credits title page'),
(9, 'filler'),
(10, 'foreword introduction preface afterword'),
(11, 'insert or dust jacket'),
(12, 'letters page'),
(13, 'photo story'),
(14, 'illustration'),
(15, 'character profile'),
(16, 'promo (ad from the publisher)'),
(17, 'public service announcement'),
(18, 'recap'),
(19, 'comic story'),
(20, 'text article'),
(21, 'text story'),
(22, 'statement of ownership'),
(23, '(unknown)'),
(24, 'blank page(s)'),
(25, 'table of contents');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `story_type`
--
ALTER TABLE `story_type`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `story_type`
--
ALTER TABLE `story_type`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
