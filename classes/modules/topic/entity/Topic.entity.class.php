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
class PluginTopiccck_ModuleTopic_EntityTopic extends PluginTopiccck_Inherit_ModuleTopic_EntityTopic {

	protected $aTypesNew=null;
	protected $oType=null;

	/**
	 * Добавляем правила валидации
	 */
	public function Init() {
		parent::Init();
		if($this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypesNew')){
			$this->aTypesNew=$this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypesNew');
		}
		$this->aValidateRules[]=array('topic_title','string','max'=>200,'min'=>2,'allowEmpty'=>false,'label'=>$this->Lang_Get('topic_create_title'),'on'=>$this->aTypesNew);
		$this->aValidateRules[]=array('topic_text_source','string','max'=>Config::Get('module.topic.max_length'),'min'=>2,'allowEmpty'=>false,'label'=>$this->Lang_Get('topic_create_text'),'on'=>$this->aTypesNew);
		$this->aValidateRules[]=array('topic_tags','tags','count'=>15,'label'=>$this->Lang_Get('topic_create_tags'),'allowEmpty'=>Config::Get('module.topic.allow_empty_tags'),'on'=>$this->aTypesNew);
		$this->aValidateRules[]=array('blog_id','blog_id','on'=>$this->aTypesNew);
		$this->aValidateRules[]=array('topic_text_source','topic_unique','on'=>$this->aTypesNew);
		$this->aValidateRules[]=array('topic_type','topic_type','on'=>$this->aTypesNew);
	}

	public function getExtraValueCck($id){
		return $this->getExtraValue('field_'.$id);
	}
	public function setExtraValueCck($id,$data){
		$this->setExtraValue('field_'.$id, $data);
	}
	public function getFuncType(){
		if(in_array($this->getType(),$this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypesNew'))){
			if($oType=$this->getTypeObj()){
				if($oType->isPhotosetEnable()){
					return 'photoset';
				}
			}
		}
		return $this->getType();
	}

	protected function extractType() {
		if (is_null($this->oType)) {
			$this->oType=$this->PluginTopiccck_Topiccck_GetTopicTypeByTypeUrl($this->getType());
		}
	}

	public function getTypeObj(){
		$this->extractType();
		if (isset($this->oType)) {
			return $this->oType;
		}
		return null;
	}
	public function getPhotosetMainPhotoCck() {
		if($this->getPhotosetMainPhotoId()){
			$aPhotosetMainPhotos=$this->Topic_GetTopicPhotosByArrayId(array($this->getPhotosetMainPhotoId()));
			if (isset($aPhotosetMainPhotos[$this->getPhotosetMainPhotoId()])) {
				return $aPhotosetMainPhotos[$this->getPhotosetMainPhotoId()];
			} else {
				return null;
			}
		}
	}

	public function getFile($id){
		if($this->getExtraValueCck($id)){
			return Engine::GetEntity('PluginTopiccck_ModuleTopic_EntityTopicFile',$this->getExtraValueCck($id));
		}
		return null;
	}

	public function getLink($id,$bHtml=false) {
    	if($this->getExtraValueCck($id)){
			if ($bHtml) {
				if (strpos($this->getExtraValueCck($id),'http://')!==0) {
					return 'http://'.$this->getExtraValueCck($id);
				}
			}
			return $this->getExtraValueCck($id);
		}
		return null;
    }

}
?>