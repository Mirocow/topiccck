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

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
    die('Hacking attemp!');
}

class PluginTopiccck extends Plugin {

    protected $aDelegates=array(
		'template' => array(
            'menu.create.content.tpl','menu.create.tpl'=>'_/menu.create.content.tpl',
			'topic.tpl','topic_list.tpl','topic_part_header.tpl',
			'topic_cck.tpl'
        ),
	);

    // Объявление переопределений (модули, мапперы и сущности)
    protected $aInherits=array(
       'action' => array(
			'ActionAjax','ActionIndex','ActionBlog',
			'ActionTopic','ActionQuestion','ActionPhotoset','ActionLink'
        ),
		'module' => array(
			'ModuleTopic'
        ),
		'entity' => array('ModuleTopic_EntityTopic'),
		'mapper' => array('ModuleTopic_MapperTopic'),
    );

    // Активация плагина
    public function Activate() {
        
        if (!$this->isTableExists('prefix_topiccck_topic_type') && !$this->isTableExists('prefix_topiccck_topic_field')) {
            $this->ExportSQL(dirname(__FILE__).'/install.sql');
        }
		$this->ExportSQL(dirname(__FILE__).'/updates/to_1.2.sql');
        
        return true;
    }

    // Деактивация плагина
    public function Deactivate(){
		return true;
    }


    // Инициализация плагина
    public function Init() {
        $this->Viewer_AppendStyle(Plugin::GetTemplatePath(__CLASS__)."css/style.css");
        $this->Viewer_AppendScript(Plugin::GetTemplatePath(__CLASS__)."js/script.js");
		$this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__).'js/jquery.ui.sortable.js',array('name'=>'jquery.ui.sortable.js'));
		$this->Viewer_AddMenu('topiccck',Plugin::GetTemplatePath(__CLASS__).'/menu.topiccck.tpl');

		$aActiveTopicTypes=$this->PluginTopiccck_Topiccck_GetItemsByFilter(array('type_active'=>1,'#order'=>array('type_sort'=>'desc')),'PluginTopiccck_ModuleTopiccck_EntityTopicType');
		$aTopicTypes=$aTopicTypesNew=array();
		foreach ($aActiveTopicTypes as $oType) {
			$aTopicTypes[]=$oType->getTypeUrl();
			$this->Topic_AddTopicType($oType->getTypeUrl());
			if($oType->getTypeCandelete()=='1'){
				$aTopicTypesNew[]=$oType->getTypeUrl();
			}
		}
		$this->Viewer_Assign('aActiveTopicTypes',$aActiveTopicTypes);
		$this->Viewer_Assign('aTopicTypes',$aTopicTypes);
		$this->Viewer_Assign('aTopicTypesNew',$aTopicTypesNew);
    }
}
?>
