CREATE TABLE `article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_source` int(11) NOT NULL,
  `title` text NOT NULL,
  `link` text NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1084 DEFAULT CHARSET=utf8;

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
	(5,'infobae - Hoy','http://www.infobae.com/rss/hoy.xml'),
	(6,'Diario Uno - Actualidad','http://www.diariouno.com.ar/servicios/rss/portada.xml')
;



select k2.value, k2.`id_article` from keyword k2,
  (select  k1.value, k1.`id_article` from keyword k1, keyword k2 
  where k1.`id_article` <> k2.`id_article` and k1.`value`= k2.value
  order by value) k1
where k1.`id_article` <> k2.`id_article` and k1.`value`= k2.value
;

select  k1.value, k1.`id_article` id_article_1, k2.`id_article` id_article_2  from keyword k1, keyword k2 
  where k1.`id_article` <> k2.`id_article` and k1.`value`= k2.value
  order by `id_article_1`, `id_article_2`;

select * from  
(select  count(k1.value) count, k1.`id_article` id_article_1, k2.`id_article` id_article_2 from keyword k1, keyword k2 
  where k1.`id_article` <> k2.`id_article` and k1.`value`= k2.value
  group by `id_article_1`, `id_article_2` order by count desc) kk
where COUNT > 2 order by `id_article_1`;

select * from  
(select count(`id_article`) count, value from keyword group by value) k
where COUNT > 1 order by count desc;

select * from `article` where id=41 or id=6;
  