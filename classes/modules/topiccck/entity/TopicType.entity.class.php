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

class PluginTopiccck_ModuleTopiccck_EntityTopicType extends EntityORM {

	protected $oPhotoset=null;
	protected $oPoll=null;
	protected $sPrimaryKey = 'type_id';

	protected $aRelations=array(
		//'fields' => array(self::RELATION_TYPE_HAS_MANY,'PluginTopiccck_ModuleTopiccck_EntityTopicField','type_id'),
	);

	public function getFields(){
		$aFilter=array();
		$aFilter['type_id']=$this->getTypeId();
		$aFilter['#order']['field_sort']='desc';
		return $this->PluginTopiccck_Topiccck_GetItemsByFilter($aFilter,'PluginTopiccck_ModuleTopiccck_EntityTopicField');
	}

	protected function searchPhotoset() {
		if (is_null($this->oPhotoset)) {
			$this->oPhotoset=$this->PluginTopiccck_Topiccck_GetByFilter(array('field_type'=>'photoset','type_id'=>$this->getTypeId()),'PluginTopiccck_ModuleTopiccck_EntityTopicField');
		}
	}

	protected function searchLitepoll() {
		if (is_null($this->oPoll)) {
			$this->oPoll=$this->PluginTopiccck_Topiccck_GetByFilter(array('field_type'=>'litepoll','type_id'=>$this->getTypeId()),'PluginTopiccck_ModuleTopiccck_EntityTopicField');
		}
	}

	public function isPhotosetEnable(){
		$this->searchPhotoset();
		if (isset($this->oPhotoset)) {
			return true;
		}
		return false;
	}

	public function isLitepollEnable(){
		$this->searchLitepoll();
		if (isset($this->oPoll)) {
			return true;
		}
		return false;
	}

}
?>