<?php
/*-------------------------------------------------------
*
*	Plugin "TOPICcck"
*	Author: Vladimir Yuriev (extravert)
*	Site: lsmods.ru
*	Contact e-mail: support@lsmods.ru
*
---------------------------------------------------------
*/
class PluginTopiccck_ActionTopic extends PlugunTopiccck_Inherit_ActionTopic {

	protected $oType=null;

	public function Init() {
		parent::Init();

		$this->oType=$this->PluginTopiccck_Topiccck_GetTopicTypeByTypeUrl('topic');
		$this->Viewer_Assign('oType',$this->oType);
	}


	protected function EventAdd() {
		/*
		 * Запрещаем добавление этого типа топика, если он отключен в плагине cck
		 */
		if($this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes')){
			if(!in_array('topic', $this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes'))){
				return parent::EventNotFound();
			}
		}
		
		/*
		 * Проверяем права на добавление топика данного типа
		 */

		if(!$this->oUserCurrent->isAdministrator()){

			$bError=true;

			if($this->oType->getTypeAccess()=='1'){
				$bError=false;
			}

			if($this->oType->getTypeAccess()=='4' && $this->PluginTopiccck_Topiccck_ACLadd($this->oType,$this->oUserCurrent)){
				$bError=false;
			}

			if($bError){
				$this->Message_AddErrorSingle($this->Lang_Get('plugin.topiccck.error_noallow_type'),$this->Lang_Get('error'));
				return Router::Action('error');
			}
		}
		
		parent::EventAdd();

		if(in_array('dao', $this->Plugin_GetActivePlugins())){
			/*
			* Загружаем связи с объектами DAO
			*/
			$this->Viewer_Assign('aLinksItems',$this->PluginTopiccck_Topiccck_LoadLinks($this->oType->getFields()));
		}
	}

	protected function EventEdit() {

		parent::EventEdit();

		if(in_array('dao', $this->Plugin_GetActivePlugins())){
			/*
			* Загружаем связи с объектами DAO
			*/
			$this->Viewer_Assign('aLinksItems',$this->PluginTopiccck_Topiccck_LoadLinks($this->oType->getFields()));
		}

		if (!isset($_REQUEST['submit_topic_publish']) && !isset($_REQUEST['submit_topic_save'])) {
			if($this->Viewer_GetSmartyObject()->getTemplateVars('oTopicEdit')){
				$oTopic=$this->Viewer_GetSmartyObject()->getTemplateVars('oTopicEdit');
				//вставляем поля, если они прописаны для топика
				foreach($this->oType->getFields() as $oField){
					if($oTopic->getExtraValueCck($oField->getFieldId())){
						$_REQUEST['fields'][$oField->getFieldId()]=$oTopic->getExtraValueCck($oField->getFieldId());
					}
				}
			}
		}

	}

}
?>