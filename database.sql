CREATE TABLE `article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_source` int(11) NOT NULL,
  `title` text NOT NULL,
  `link` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8;

CREATE TABLE `keyword` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `value` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unq_key_art_val` (`id_article`,`value`)
) ENGINE=InnoDB AUTO_INCREMENT=697 DEFAULT CHARSET=utf8;

CREATE TABLE `source` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


INSERT INTO `source` (`id`, `name`, `link`)
VALUES
	(1,'Clarin.com - HOME','http://clarin.feedsportal.com/c/33088/f/577681/index.rss'),
	(2,'La Nacion - Ultimas Noticias','http://lanacion.com.ar.feedsportal.com/ultimasnoticias'),
	(3,'Pagina 12 - Principal','http://www.pagina12.com.ar/diario/rss/principal.xml'),
	(4,'Pagina 12 - Ultimas Noticias','http://www.pagina12.com.ar/diario/rss/ultimas_noticias.xml'),
	(5,'infobae - Hoy','http://www.infobae.com/rss/hoy.xml');