CREATE TABLE IF NOT EXISTS `prefix_topiccck_topic_type` (
  `type_id` int(11) unsigned NOT NULL AUTO_INCREMENT ,
  `type_title` varchar(200) NOT NULL,
  `type_title_decl` varchar(200) NOT NULL,
  `type_sort` int(11) NOT NULL DEFAULT '0',
  `type_url` varchar(50) NOT NULL,
  `type_active` tinyint(1) NOT NULL DEFAULT '1',
  `type_candelete` tinyint(1) NOT NULL DEFAULT '0',
  `type_access` tinyint(1) NOT NULL DEFAULT '1',
  `date_add` datetime DEFAULT NULL,
  `type_config` text DEFAULT NULL,
  PRIMARY KEY `type_id` (`type_id`),
  KEY ( `type_url` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `prefix_topiccck_topic_type` (`type_id`, `type_title`, `type_title_decl`, `type_sort`, `type_url`, `type_active`, `type_candelete`) VALUES
(1, 'Обычный топик','Топики','1',  'topic', '1', '0'),
(2, 'Опрос', 'Опросы','2',  'question', '1', '0'),
(3, 'Ссылка', 'Ссылки','3',  'link', '1', '0'),
(4, 'Фотосет', 'Фотоотчеты','4',  'photoset', '1', '0');

CREATE TABLE IF NOT EXISTS `prefix_topiccck_topic_field` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT ,
  `type_id` int(11) NOT NULL,
  `field_sort` int(11) NOT NULL DEFAULT '0',
  `field_type` enum('input','textarea','photoset','link','select','date','map','daoobj','object','user','file','litepoll','gallery') NOT NULL DEFAULT 'input',
  `field_name` varchar(50) NOT NULL,
  `field_description` varchar(200) NOT NULL,
  `field_options` text DEFAULT NULL ,
  `field_required` tinyint(1) NOT NULL DEFAULT '0',
  `field_postfix` text DEFAULT NULL,
  PRIMARY KEY `field_id` ( `field_id` ),
  KEY ( `type_id` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;