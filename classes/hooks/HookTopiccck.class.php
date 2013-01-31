<?php

/*-------------------------------------------------------
*
*	Plugin "TOPICcck"
*	Author: Vladimir Yuriev (extravert)
*	Official site: lsmods.ru
*	Contact e-mail: support@lsmods.ru
*
---------------------------------------------------------
*/

class PluginTopiccck_HookTopiccck extends Hook {
	
	public function RegisterHook() {
		/*
		 * Вставляем ссылку в админки
		 */
		$this->AddHook('template_admin_action_item','insertadminlink',__CLASS__,1000); //native administration area
		$this->AddHook('template_menu_admin','insertadminlink',__CLASS__,1000); //aceadminpanel

		/*
		 * Вставляем поля в форму
		 */
		$this->AddHook('template_form_add_topic_topic_end', 'insertfields', __CLASS__,-1);
		$this->AddHook('template_form_add_topic_link_end', 'insertfields', __CLASS__,-1);
		$this->AddHook('template_form_add_topic_question_end', 'insertfields', __CLASS__,-1);
		$this->AddHook('template_form_add_topic_photoset_end', 'insertfields', __CLASS__,-1);

		$this->AddHook('topic_edit_show', 'TopicEdit', __CLASS__);

		/*
		 * Обрабатываем дополнительные поля при добавлении и редактировании
		 */
		$this->AddHook('topic_add_after', 'processfields', __CLASS__);
		$this->AddHook('topic_edit_after', 'processfields', __CLASS__);

		/*
		 * Показывавем поля при просмотре топика
		 */
		$this->AddHook('template_topic_content_end', 'showfields', __CLASS__,150);

		/*
		 * Выводим ссылки фильтров в меню главной
		 */
		if(!in_array('flow',$this->Plugin_GetActivePlugins())){
			$this->AddHook('template_content_begin', 'insertlinksindex', __CLASS__,PHP_INT_MAX);
		} else {
			$this->AddHook('template_flow_menu_blog_index_item', 'insertlinksindex', __CLASS__,-1);
		}

		/*
		 * Вставляем ссылку непрокомментированных топиков
		 */
		$this->AddHook('template_menu_blog_index_item', 'insertlinknocomments', __CLASS__,100);

		/*
		 * Выводим ссылки фильтров в меню блога
		 */
		$this->AddHook('template_menu_blog_blog_item', 'insertlinksblog', __CLASS__,-100);

		/*
		 * Role
		 */
		$this->AddHook('template_roles_user', 'RoleAdd');
		$this->AddHook('template_roles_role', 'RoleAdd');

		$this->AddHook('template_roles_role_show_end', 'RoleEdit');
		$this->AddHook('template_roles_role_user_show_end', 'RoleEdit');

	}

	public function insertadminlink() {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'hook_insert_admin_link.tpl');
	}

	public function insertfields(){
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'inject.topic.fields.tpl');
	}
	public function insertlinksindex(){
		if(Router::GetAction()=='index' && Config::Get('plugin.topiccck.show_index_filter')){
			return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'inject.links.index.tpl');
		}
	}
	public function insertlinknocomments(){
		if(Router::GetAction()=='index' && Config::Get('plugin.topiccck.show_index_filter')){
			return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'inject.linknocomments.tpl');
		}
	}

	public function insertlinksblog(){
		if(Router::GetAction()=='blog' && Config::Get('plugin.topiccck.show_blog_filter')){
			//if($this->Viewer_GetSmartyObject()->getTemplateVars('oBlog')){
			//	$this->Viewer_Assign('oBlog',$this->Viewer_GetSmartyObject()->getTemplateVars('oBlog'));
				return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'inject.links.blog.tpl');
			//}
		}
	}

	public function processfields($aVars){
		$oTopic=$aVars['oTopic'];
		
		if($oType=$this->PluginTopiccck_Topiccck_GetTopicTypeByTypeUrl($oTopic->getType())){
			//получаем поля для данного типа
			if($aFields=$this->PluginTopiccck_Topiccck_GetItemsByFilter(array('type_id'=>$oType->getTypeId()),'PluginTopiccck_ModuleTopiccck_EntityTopicField')){
				foreach($aFields as $oField){
					if(isset($_REQUEST['fields'][$oField->getFieldId()]) || isset($_FILES['fields_'.$oField->getFieldId()])){

						//текстовые поля
						if(in_array($oField->getFieldType(),array('input','textarea','select'))){
							$sText=$this->Text_Parser($_REQUEST['fields'][$oField->getFieldId()]);
							$oTopic->setExtraValueCck($oField->getFieldId(),$sText);
						}
						//поле ссылки
						if($oField->getFieldType()=='link'){
							$oTopic->setExtraValueCck($oField->getFieldId(),$_REQUEST['fields'][$oField->getFieldId()]);
						}

						//поле карты
						if($oField->getFieldType()=='map') {
							if(isset($_REQUEST['fields'][$oField->getFieldId()][0]) && isset($_REQUEST['fields'][$oField->getFieldId()][1])){
								$lat=htmlspecialchars(strip_tags($_REQUEST['fields'][$oField->getFieldId()][1]));
								$lng=htmlspecialchars(strip_tags($_REQUEST['fields'][$oField->getFieldId()][0]));
								$oTopic->setExtraValueCck($oField->getFieldId(),array($lat,$lng));
							}

						}

						//поле даты
						if($oField->getFieldType()=='date') {
							if(isset($_REQUEST['fields'][$oField->getFieldId()])){

								if(func_check($_REQUEST['fields'][$oField->getFieldId()],'text',6,10) && substr_count($_REQUEST['fields'][$oField->getFieldId()],'.')==2) {
									list($d,$m,$y)=explode('.',$_REQUEST['fields'][$oField->getFieldId()]);
									if(@checkdate($m,$d,$y)) {
										$oTopic->setExtraValueCck($oField->getFieldId(),$_REQUEST['fields'][$oField->getFieldId()]);
									}
								}
								
							}

						}

						//поле связи с объектами DAO
						if($oField->getFieldType()=='daoobj'){
							//$oTopic->setExtraValueCck($oField->getFieldId(),array());
							if(isset($_REQUEST['fields'][$oField->getFieldId()])){
								$aSave=array();
								foreach($_REQUEST['fields'][$oField->getFieldId()] as $itemId){
									if(is_numeric($itemId)){
										$aSave[]=$itemId;
									}
								}
								$oTopic->setExtraValueCck($oField->getFieldId(),$aSave);
							}
						}
						
						//поле с файлом
						if($oField->getFieldType()=='file'){

							if(getRequest('topic_delete_file_'.$oField->getFieldId())){
								if($oTopic->getFile($oField->getFieldId())){
									@unlink(Config::Get('path.root.server').$oTopic->getFile($oField->getFieldId())->getFileUrl());
									$oTopic->setExtraValueCck($oField->getFieldId(),'');
								}
							}
							
							if (isset($_FILES['fields_'.$oField->getFieldId()]) and is_uploaded_file($_FILES['fields_'.$oField->getFieldId()]['tmp_name'])) {
								
								if (filesize($_FILES['fields_'.$oField->getFieldId()]['tmp_name'])<=Config::Get('plugin.topiccck.max_filesize_limit')) {
									$aPathInfo=pathinfo($_FILES['fields_'.$oField->getFieldId()]['name']);

									if (in_array(strtolower($aPathInfo['extension']),Config::Get('plugin.topiccck.upload_mime_types'))) {
										$sFileTmp=$_FILES['fields_'.$oField->getFieldId()]['tmp_name'];
										$sDirSave=Config::Get('path.uploads.root').'/files/'.$this->User_GetUserCurrent()->getId().'/'.func_generator(16);
										mkdir(Config::Get('path.root.server').$sDirSave,0777,true);
										if(is_dir(Config::Get('path.root.server').$sDirSave)){

											$sFile=$sDirSave.'/'.func_generator(10).'.'.strtolower($aPathInfo['extension']);
											$sFileFullPath=Config::Get('path.root.server').$sFile;
											if (copy($sFileTmp,$sFileFullPath)) {
												//удаляем старый файл
												if($oTopic->getFile($oField->getFieldId())){
													@unlink(Config::Get('path.root.server').$oTopic->getFile($oField->getFieldId())->getFileUrl());
												}

												$aFileObj=array();
												//$aFileObj=Engine::GetEntity('PluginTopiccck_ModuleTopiccck_EntityTopicFile');
												$aFileObj['file_hash']=func_generator(32);
												$aFileObj['file_name']=$this->Text_Parser($_FILES['fields_'.$oField->getFieldId()]['name']);
												$aFileObj['file_url']=$sFile;
												$aFileObj['file_size']=$_FILES['fields_'.$oField->getFieldId()]['size'];
												$aFileObj['file_extension']=$aPathInfo['extension'];
												$aFileObj['file_downloads']=0;
												$oTopic->setExtraValueCck($oField->getFieldId(),$aFileObj);

												@unlink($sFileTmp);
											}
										}
									}
								}


							}
							@unlink($_FILES['fields_'.$oField->getFieldId()]['tmp_name']);

						}
						
					} else{

						//фикс очистки поля, если оно не установлено
						if($oField->getFieldType()=='daoobj'){
							$oTopic->setExtraValueCck($oField->getFieldId(),array());
						}

					}
					
				}
				//меняем хеш, чтобы все обновилось корректно
				$oTopic->setTextHash(md5($oTopic->getTextSource().'extra'.$oTopic->getExtra()));
				//сохраняем
				$this->Topic_UpdateTopic($oTopic);

			}
		}
	}

	public function showfields($aVars){
		$oTopic=$aVars['topic'];
		$bTopicList=$aVars['bTopicList'];
		$sReturn='';
		if(!$bTopicList){
			//получаем данные о типе топика
			if($oType=$this->PluginTopiccck_Topiccck_GetTopicTypeByTypeUrl($oTopic->getType())){
				//получаем поля для данного типа
				if($aFields=$oType->getFields()){
					//вставляем поля, если они прописаны для топика
					foreach($aFields as $oField){
						if($oTopic->getExtraValueCck($oField->getFieldId()) || $oField->getFieldType()=='photoset'){
							$this->Viewer_Assign('oField',$oField);
							$this->Viewer_Assign('oTopic',$oTopic);
							$sReturn.=$this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'/forms/view_field_'.$oField->getFieldType().'.tpl');

						}
					}
				}
			}

		}
		return $sReturn;
	}

	public function TopicEdit($aVars) {
		$oTopic=$aVars['oTopic'];
		$this->Viewer_Assign('oTopicEdit',$oTopic);


		/*
		 * Интеграция с Topic access control
		 */
		if(in_array('tca', $this->Plugin_GetActivePlugins())){
			if (Router::GetParam(0) == 'edit') {
				$aParams = Router::GetParams();
				if (!empty($aParams['1'])) {
					if ($oTopic = $this->Topic_GetTopicById($aParams['1'])) {
						$_REQUEST['topic_close'] = $oTopic->getClose();
						$_REQUEST['topic_close_modes_friend'] = $oTopic->getCloseFriend();
						if ($oTopic->getClose18plus()) {
							$_REQUEST['topic_close_modes_18plus_check'] = 1;
							$_REQUEST['topic_close_modes_18plus'] = $oTopic->getClose18plus();
						}
						if ($oTopic->getClosePassword()) {
							$_REQUEST['topic_close_modes_password_check'] = 1;
							$_REQUEST['topic_close_modes_password'] = $oTopic->getClosePassword();
						}
					}
				}
			}
		}
	}

	public function RoleAdd() {
		if($this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes')){
			$this->Viewer_Assign('aTopicTypes', $this->PluginTopiccck_Topiccck_GetItemsByFilter(array('type_active'=>1,'#order'=>array('type_sort'=>'desc')),'PluginTopiccck_ModuleTopiccck_EntityTopicType'));
			return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'role.add.tpl');
		}
    }

    public function RoleEdit($aVar) {
		if($this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes')){
			$this->Viewer_Assign('sId', $aVar['id']);
			$this->Viewer_Assign('aRole', $aVar['role']);
			$this->Viewer_Assign('aTopicTypes', $this->PluginTopiccck_Topiccck_GetItemsByFilter(array('type_active'=>1,'#order'=>array('type_sort'=>'desc')),'PluginTopiccck_ModuleTopiccck_EntityTopicType'));
			return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'role.edit.tpl');
		}
    }

}
?>
