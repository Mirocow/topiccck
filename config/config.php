<?php

$config = array();

/*
 * Настройки
 */
$config['show_index_filter']=true;//разрешить ли сортировать топики на главной по типу топика (будет выводиться подменю)
$config['show_blog_filter']=true;//разрешить ли сортировать топики в профиле блога по типу топика (будет выводиться подменю)

/*
 * Карта
 */
$config['map_type']='yandex'; //yandex или google
$config['map_width']='600px';
$config['map_height']='400px';
$config['map_center']='55.75703,37.61614';
$config['map_zoom']='15';
$config['map_enablescrollzoom']= '1';
$config['map_showtoolbar']= '1';
$config['map_showtypecontrol']='1';
$config['map_showzoom']='1';
$config['map_showsearchcontrol']= '1';
$config['map_showsearch']='1';


/*
 * Ограничения
 */
$config['text_length_min']=2;//минимальная длина дополнительных текстовых полей
$config['text_length_max']=1000;//максимальная длина дополнительных текстовых полей

/*
 * Файлы
 */
$config['anonim_download'] = true; //Разрешить незарегистрированным пользователям скачивать файлы
$config['max_filesize_limit'] = 20*1024*1024; //максимальный размер загружаемого файла в байтах (по умолчанию 20мб)
$config['upload_mime_types'] = array('zip','rar','gz','mp3','png', 'doc', 'docx', 'pdf','djv','djvu'); //расширения файлов, которые можно прикреплять к топикам



/*
 * Блоки
 */

Config::Set('block.rule_cckblocks',array(
		'action'  => array(
			'type'
		),
		'blocks'  => array( 'right' => array('blocks/block.blogInfo.tpl') ),
	)
);

/*
 * ВСЕ ЧТО НИЖЕ ТРОГАТЬ НЕ РЕКОМЕНДУЕТСЯ
 */

//для определения
$config['developer_based']=array('developer','social');

Config::Set('router.page.type', 'PluginTopiccck_ActionType');
Config::Set('router.page.cckadmin', 'PluginTopiccck_ActionCckadmin');

return $config;