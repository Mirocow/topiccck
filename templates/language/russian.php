<?php
/**
 * Русский языковой файл плагина
 */
return array(
    'topiccck' => '',
	'admin'=>'Типы топиков TOPICcck admin',
	'menu'=>'TOPICcck admin',
	'add'=>'Добавить новый',
	'add_title'=>'Добавление нового типа топика',
	'edit_title'=>'Редактирование типа топика',
	'add_field_title'=>'Добавление нового поля',
	'edit_field_title'=>'Редактирование поля',
	'types_list'=>'Список типов топиков',

	'title'=>'Название',
	'title_notice'=>'Например, <b>Обзор</b>',
	'title_decl'=>'Название во множественном числе',
	'title_decl_notice'=>'Например, <b>Обзоры</b>',
	'type_access'=>'Доступ на создание',
	'type_access_all'=>'Всем',
	'type_access_admin'=>'Только администратору',
	'type_access_role'=>'Только выбранным ролям(редактируются в плагине role)',
	'type_access_notice'=>'Выберите тип доступа на добавление к этому типу топика',
	'url'=>'Служебный идентификатор',
	'url_notice'=>'Только латиница и подчеркивание. Например, <b>review</b>',


	/*
	 * Поля
	 */
	'field'=>'Поле',
	'fields'=>'Поля',
	'fields_added'=>'Добавленные поля',
	'add_field'=>'+ Добавить поле',
	'name'=>'Название',
	'description'=>'Описание',
	'type'=>'Тип',
	'values'=>'Значения (по одному на каждой строке)',

	'required'=>'Обязательное',
	'required_notice'=>'Обязательное для заполнения поле',

	'field_input'=>'Строковое поле',
	'field_textarea'=>'Текстовое поле ',
	'field_file'=>'Файл',
	'field_photoset'=>'Блок загрузки фото',
	'field_link'=>'Ссылка',
	'field_select'=>'Выпадающий список',
	'field_date'=>'Дата(календарь)',
	'field_map'=>'Карта',
	'field_daoobj'=>'Объекты каталогов DAO',
	'field_litepoll'=>'Блок опросов плагина LitePoll',
	'field_gallery'=>'Блок вставки альбомов плагина LsGallery',

	'field_input_notice'=>'Однострочное поле',
	'field_textarea_notice'=>'Многострочное поле с редактором ',
	'field_file_notice'=>'Поле для загрузки файла',
	'field_photoset_notice'=>'Подключится пакетный загрузчик фото(как в фотосете)',
	'field_link_notice'=>'URL',
	'field_select_notice'=>'Выпадающий список',
	'field_date_notice'=>'Дата(календарь)',
	'field_map_notice'=>'Карта',
	'field_daoobj_notice'=>'Объекты каталогов DAO',
	'field_litepoll_notice'=>'Блок опросов плагина LitePoll',
	'field_gallery_notice'=>'Блок вставки альбомов плагина LsGallery',

	'count_downloads'=>'Скачиваний',

	'delete_file'=>'Удалить файл',
	'file_rewrite'=>'будет перезаписан',
	'field_detele_confirm'=>'Вы действительно хотите удалить это поле?',


	/*
	 * Администрирование
	 */
	'actions'=>'Действия',

	'status'=>'Состояние',
	'on'=>'активен',
	'off'=>'отключен',
	'turn_on'=>'включить',
	'turn_off'=>'выключить',

	'submit'=>'Сохранить',
	'save'=>'Сохранить',
	'edit'=>'Редактирование',
	'delete'=>'удалить',
	'standart'=>'стандартный',
	'for'=>'для',

	'by_type'=>'Топики по типу',
	'nocomments'=>'Нет комментариев',

	'topic_edit'=>'Редактирование топика',

	'add_prefix'=>'Добавить',
	'afteradd'=>'Добавление дополнительных полей станет доступно после добавления нового типа',


	//ошибки
	'error_noallow_type'=>'Вам запрещено добавлять топики данного типа',
	'type_title_error'=>'Поле название может быть от 2 до 200 символов',
	'type_title_decl_error'=>'Поле название(множ числа) может быть от 2 до 200 символов',
	'type_url_error'=>'Поле служебного названия (URL) может быть от 2 до 50 символов, только латиница, без пробелов. Также адрес не может совпадать с существующими адресами экшенов',

	'field_name_error'=>'Название поля должно быть от 2 до 100 символов',
	'field_description_error'=>'Описание поля должно быть от 2 до 200 символов',
	'field_type_error'=>'Неверный тип поля',
	'field_daoobj_error'=>'Ошибка в данных связи с объектом DAO',
	'download_file_error'=>'Ошибка при скачивании файла',


	//'text_length_error'=>'Поле %%name%% может быть длиной от '.Config::Get('plugin.topiccck.text_length_min').' до '.Config::Get('plugin.topiccck.text_length_max').' символов',



	'save_sort_success'=>'Сортировка сохранена',
	'success'=>'Новый тип успешно добавлен',
	'success_edit'=>'Успешно отредактировано',
	'success_fieldadd'=>'Поле добавлено',
	'success_fieldedit'=>'Поле успешно отредактировано',
	'success_fielddelete'=>'Поле успешно удалено',

	'dao_link_view_type'=>'Тип вывода при просмотре топика',
	'dao_link_view_type_link'=>'Ссылками',
	'dao_link_view_type_obj'=>'Списком объектов в оформлении DAO',

	'role_topiccck'=>'Добавление топиков',

	'buydao'=>'Приобретите плагины <a href="http://livestreetcms.com/profile/extravert/addons/">линейки DAO</a> и у вас появится возможность прикреплять к топикам объекты из разделов, созданных DAO, такие как видео, аудио, места, объекты каталогов и т.п.',
);

?>
