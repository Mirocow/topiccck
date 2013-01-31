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

class PluginTopiccck_ActionAjax extends PluginTopiccck_Inherit_ActionAjax {

	protected function RegisterEvent() {
		parent::RegisterEvent();
		$this->AddEvent('ajaxtopiccckchangeordertypes','EventAjaxCckChangeOrderTypes');
		$this->AddEvent('ajaxtopiccckchangeorderfields','EventAjaxCckChangeOrderFields');
	}


	public function EventAjaxCckChangeOrderTypes(){


		if (!$this->User_IsAuthorization()) {
				$this->Message_AddErrorSingle($this->Lang_Get('need_authorization'),$this->Lang_Get('error'));
				return;
		}
		if (!$this->oUserCurrent->isAdministrator()) {
				$this->Message_AddErrorSingle($this->Lang_Get('need_authorization'),$this->Lang_Get('error'));
				return;
		}
		if (!getRequest('order')) {
				$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
				return;
		}


		if(is_array(getRequest('order'))){

			foreach(getRequest('order') as $oOrder){

				if(is_numeric($oOrder['order']) && is_numeric($oOrder['id']) && $oType=$this->PluginTopiccck_Topiccck_GetTopicTypeByTypeId($oOrder['id'])){
					$oType->setTypeSort($oOrder['order']);
					$oType->Update();
				}
			}

			$this->Message_AddNoticeSingle($this->Lang_Get('plugin.topiccck.save_sort_success'));
			return;
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
			return;
		}

	}

	public function EventAjaxCckChangeOrderFields(){


		if (!$this->User_IsAuthorization()) {
				$this->Message_AddErrorSingle($this->Lang_Get('need_authorization'),$this->Lang_Get('error'));
				return;
		}
		if (!$this->oUserCurrent->isAdministrator()) {
				$this->Message_AddErrorSingle($this->Lang_Get('need_authorization'),$this->Lang_Get('error'));
				return;
		}
		if (!getRequest('order')) {
				$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
				return;
		}


		if(is_array(getRequest('order'))){

			foreach(getRequest('order') as $oOrder){

				if(is_numeric($oOrder['order']) && is_numeric($oOrder['id']) && $oField=$this->PluginTopiccck_Topiccck_GetTopicFieldByFieldId($oOrder['id'])){
					$oField->setFieldSort($oOrder['order']);
					$oField->Update();
				}
			}

			$this->Message_AddNoticeSingle($this->Lang_Get('plugin.topiccck.save_sort_success'));
			return;
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
			return;
		}

	}

}
?>