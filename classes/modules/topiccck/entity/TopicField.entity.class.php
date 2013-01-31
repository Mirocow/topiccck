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

class PluginTopiccck_ModuleTopiccck_EntityTopicField extends EntityORM {

	protected $aExtra=null;

	protected $sPrimaryKey = 'field_id';

	protected $aRelations=array(

	);

	public function getCoord($value,$index){
		if(isset($value[$index])){
			return $value[$index];
		}
		return null;
	}

	public function getFieldValues(){
		if ($this->getOptionValue('select')) {
			return $this->getOptionValue('select');
		}
		return '';
	}

	public function getSelectVal(){
		if($this->getOptionValue('select')) {
			$nl=nl2br($this->getOptionValue('select'));
			return explode('<br />',$nl);
		}
		return array();
	}

	public function getDaoobj(){
		if ($this->getFieldType()=='daoobj' && $this->getOptionValue('daoobj')) {
			return Engine::GetEntity('PluginTopiccck_ModuleTopiccck_EntityTopicDaoobj',$this->getOptionValue('daoobj'));
		}
		return null;
	}

	protected function extractOptions() {
		if (is_null($this->aExtra)) {
			$this->aExtra=@unserialize($this->getOptions());
		}
	}

	public function getOptions() {
		return $this->_getDataOne('field_options') ? $this->_getDataOne('field_options') : serialize('');
	}

	public function setOptions($data) {
		$this->_aData['field_options']=serialize($data);
	}

	public function setOptionValue($sName,$data) {
		$this->extractOptions();
		$this->aExtra[$sName]=$data;
		$this->setOptions($this->aExtra);
	}

	public function getOptionValue($sName) {
		$this->extractOptions();
		if (isset($this->aExtra[$sName])) {
			return $this->aExtra[$sName];
		}
		return null;
	}
	
}

?>
