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

class PluginTopiccck_ModuleTopiccck_EntityTopicDaoobj extends Entity {

	protected $oCatalog=null;
	protected $aExtra=null;

	protected $sPrimaryKey = 'field_id';

	public function getItems($aIds){
		if(isset($aIds) && count($aIds)){
			return $this->PluginTopiccck_Topiccck_LoadToItem($aIds,$this->getCatalog(),$this->getLinkShowType());
		}
		return array();
	}

	public function getCatalog(){
		if($this->getCatalogId()){
			if(!is_null($this->oCatalog)){
				return $this->oCatalog;
			}
			return $this->PluginDao_Catalog_GetCatalogTypeByCatalogId($this->getCatalogId());
		}
		return null;
	}
	
}

?>
