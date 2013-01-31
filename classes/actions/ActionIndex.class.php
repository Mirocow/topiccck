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

class PluginTopiccck_ActionIndex extends PluginTopiccck_Inherit_ActionIndex {

	protected $oType=null;
	
	protected function RegisterEvent() {
		parent::RegisterEvent();
		$this->AddEventPreg('/^type$/i','/^[\w\-\_]+$/i','/^(page([1-9]\d{0,5}))?$/i','EventType');
		$this->AddEventPreg('/^nocomments/i','/^(page([1-9]\d{0,5}))?$/i','EventNocomments');

		$this->AddEventPreg('/^type$/i','/^[\w\-\_]+$/i','/^newall$/i','/^(page([1-9]\d{0,5}))?$/i','EventTypeNewall');
		$this->AddEventPreg('/^type$/i','/^[\w\-\_]+$/i','/^discussed$/i','/^(page([1-9]\d{0,5}))?$/i','EventTypeDiscussed');
		$this->AddEventPreg('/^type$/i','/^[\w\-\_]+$/i','/^top$/i','/^(page([1-9]\d{0,5}))?$/i','EventTypeTop');
		$this->AddEventPreg('/^type$/i','/^[\w\-\_]+$/i','/^nocomments$/i','/^(page([1-9]\d{0,5}))?$/i','EventTypeNocomments');

	}

	/**
	 * Вывод новых топиков по типам
	 */
	protected function EventType() {

		if(!Config::Get('plugin.topiccck.show_index_filter')){
			return parent::EventNotFound();
		}

		/**
		 * Меню
		 */
		$this->sMenuSubItemSelect='type';
		/*
		 * Проверяем есть ли такой тип и активен ли он
		 */
		if(!$this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes')  ||
			!in_array(Router::GetParam(0), $this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes'))){

			return parent::EventNotFound();
		}
		if(!$this->oType=$this->PluginTopiccck_Topiccck_GetTopicTypeByTypeUrl(Router::GetParam(0))){
			return parent::EventNotFound();
		}
		/**
		 * Передан ли номер страницы
		 */
		$iPage=$this->GetParamEventMatch(1,2) ? $this->GetParamEventMatch(1,2) : 1;
		/**
		 * Получаем список топиков
		 */
		$aResult=$this->Topic_GetTopicsByType($iPage,Config::Get('module.topic.per_page'),$this->oType->getTypeUrl());
		$aTopics=$aResult['collection'];
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('topics_list_show',array('aTopics'=>$aTopics));
		/**
		 * Формируем постраничность
		 */
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.topic.per_page'),Config::Get('pagination.pages.count'),Router::GetPath('index').'type/'.$this->oType->getTypeUrl().'/');
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aTopics',$aTopics);
		$this->Viewer_Assign('aPaging',$aPaging);
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('index');
	}

	/**
	 * Вывод новых топиков по типам
	 */
	protected function EventNocomments() {

		if(!Config::Get('plugin.topiccck.show_index_filter')){
			return parent::EventNotFound();
		}

		/**
		 * Меню
		 */
		$this->sMenuSubItemSelect='nocomments';
		/**
		 * Передан ли номер страницы
		 */
		$iPage=$this->GetParamEventMatch(0,2) ? $this->GetParamEventMatch(0,2) : 1;
		/**
		 * Получаем список топиков
		 */
		$aResult=$this->Topic_GetTopicsNocomments($iPage,Config::Get('module.topic.per_page'));
		$aTopics=$aResult['collection'];
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('topics_list_show',array('aTopics'=>$aTopics));
		/**
		 * Формируем постраничность
		 */
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.topic.per_page'),Config::Get('pagination.pages.count'),Router::GetPath('index').'nocomments');
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aTopics',$aTopics);
		$this->Viewer_Assign('aPaging',$aPaging);
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('index');

	}

	/**
	 * Вывод рейтинговых топиков
	 */
	protected function EventTypeTop() {

		if(!Config::Get('plugin.topiccck.show_index_filter')){
			return parent::EventNotFound();
		}
		
		$sPeriod=1; // по дефолту 1 день
		if (in_array(getRequest('period'),array(1,7,30,'all'))) {
			$sPeriod=getRequest('period');
		}
		/**
		 * Меню
		 */
		$this->sMenuSubItemSelect='top';

		/*
		 * Проверяем есть ли такой тип и активен ли он
		 */
		if(!$this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes')  ||
			!in_array(Router::GetParam(0), $this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes'))){

			return parent::EventNotFound();
		}
		if(!$this->oType=$this->PluginTopiccck_Topiccck_GetTopicTypeByTypeUrl(Router::GetParam(0))){
			return parent::EventNotFound();
		}

		/**
		 * Передан ли номер страницы
		 */
		$iPage=$this->GetParamEventMatch(2,2) ? $this->GetParamEventMatch(2,2) : 1;
		
		/**
		 * Получаем список топиков
		 */
		$aResult=$this->Topic_GetTopicsTypeTop($this->oType->getTypeUrl(),$iPage,Config::Get('module.topic.per_page'),$sPeriod=='all' ? null : $sPeriod*60*60*24);
		/**
		 * Если нет топиков за 1 день, то показываем за неделю (7)
		 */
		if (!$aResult['count'] and $iPage==1 and !getRequest('period')) {
			$sPeriod=7;
			$aResult=$this->Topic_GetTopicsTypeTop($this->oType->getTypeUrl(),$iPage,Config::Get('module.topic.per_page'),$sPeriod=='all' ? null : $sPeriod*60*60*24);
		}
		$aTopics=$aResult['collection'];
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('topics_list_show',array('aTopics'=>$aTopics));
		/**
		 * Формируем постраничность
		 */
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.topic.per_page'),Config::Get('pagination.pages.count'),Router::GetPath('index').'type/'.$this->oType->getTypeUrl().'/top',array('period'=>$sPeriod));
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aTopics',$aTopics);
		$this->Viewer_Assign('aPaging',$aPaging);
		$this->Viewer_Assign('sPeriodSelectCurrent',$sPeriod);
		$this->Viewer_Assign('sPeriodSelectRoot',Router::GetPath('index').'type/'.$this->oType->getTypeUrl().'/top/');
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('index');
	}
	/**
	 * Вывод обсуждаемых топиков
	 */
	protected function EventTypeDiscussed() {

		if(!Config::Get('plugin.topiccck.show_index_filter')){
			return parent::EventNotFound();
		}
		
		$sPeriod=1; // по дефолту 1 день
		if (in_array(getRequest('period'),array(1,7,30,'all'))) {
			$sPeriod=getRequest('period');
		}

		/*
		 * Проверяем есть ли такой тип и активен ли он
		 */
		if(!$this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes')  ||
			!in_array(Router::GetParam(0), $this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes'))){

			return parent::EventNotFound();
		}
		if(!$this->oType=$this->PluginTopiccck_Topiccck_GetTopicTypeByTypeUrl(Router::GetParam(0))){
			return parent::EventNotFound();
		}

		/**
		 * Меню
		 */
		$this->sMenuSubItemSelect='discussed';
		/**
		 * Передан ли номер страницы
		 */
		$iPage=$this->GetParamEventMatch(2,2) ? $this->GetParamEventMatch(2,2) : 1;
		
		/**
		 * Получаем список топиков
		 */
		$aResult=$this->Topic_GetTopicsTypeDiscussed($this->oType->getTypeUrl(),$iPage,Config::Get('module.topic.per_page'),$sPeriod=='all' ? null : $sPeriod*60*60*24);
		/**
		 * Если нет топиков за 1 день, то показываем за неделю (7)
		 */
		if (!$aResult['count'] and $iPage==1 and !getRequest('period')) {
			$sPeriod=7;
			$aResult=$this->Topic_GetTopicsTypeDiscussed($this->oType->getTypeUrl(),$iPage,Config::Get('module.topic.per_page'),$sPeriod=='all' ? null : $sPeriod*60*60*24);
		}
		$aTopics=$aResult['collection'];
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('topics_list_show',array('aTopics'=>$aTopics));
		/**
		 * Формируем постраничность
		 */
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.topic.per_page'),Config::Get('pagination.pages.count'),Router::GetPath('index').'type/'.$this->oType->getTypeUrl().'/discussed',array('period'=>$sPeriod));
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aTopics',$aTopics);
		$this->Viewer_Assign('aPaging',$aPaging);
		$this->Viewer_Assign('sPeriodSelectCurrent',$sPeriod);
		$this->Viewer_Assign('sPeriodSelectRoot',Router::GetPath('index').'type/'.$this->oType->getTypeUrl().'/discussed/');
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('index');
	}
	
	protected function EventTypeNewAll() {

		if(!Config::Get('plugin.topiccck.show_index_filter')){
			return parent::EventNotFound();
		}

		/*
		 * Проверяем есть ли такой тип и активен ли он
		 */
		if(!$this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes')  ||
			!in_array(Router::GetParam(0), $this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes'))){

			return parent::EventNotFound();
		}
		if(!$this->oType=$this->PluginTopiccck_Topiccck_GetTopicTypeByTypeUrl(Router::GetParam(0))){
			return parent::EventNotFound();
		}

		/**
		 * Меню
		 */
		$this->sMenuSubItemSelect='new';
		/**
		 * Передан ли номер страницы
		 */
		$iPage=$this->GetParamEventMatch(2,2) ? $this->GetParamEventMatch(2,2) : 1;
		/**
		 * Получаем список топиков
		 */
		$aResult=$this->Topic_GetTopicsTypeNewAll($this->oType->getTypeUrl(),$iPage,Config::Get('module.topic.per_page'));
		$aTopics=$aResult['collection'];
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('topics_list_show',array('aTopics'=>$aTopics));
		/**
		 * Формируем постраничность
		 */
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.topic.per_page'),Config::Get('pagination.pages.count'),Router::GetPath('index').'type/'.$this->oType->getTypeUrl().'/newall');
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aTopics',$aTopics);
		$this->Viewer_Assign('aPaging',$aPaging);
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('index');
	}

	/**
	 * Вывод новых топиков по типам
	 */
	protected function EventTypeNocomments() {

		if(!Config::Get('plugin.topiccck.show_index_filter')){
			return parent::EventNotFound();
		}

		/*
		 * Проверяем есть ли такой тип и активен ли он
		 */
		if(!$this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes')  ||
			!in_array(Router::GetParam(0), $this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes'))){

			return parent::EventNotFound();
		}
		if(!$this->oType=$this->PluginTopiccck_Topiccck_GetTopicTypeByTypeUrl(Router::GetParam(0))){
			return parent::EventNotFound();
		}

		/**
		 * Меню
		 */
		$this->sMenuSubItemSelect='nocomments';
		/**
		 * Передан ли номер страницы
		 */
		$iPage=$this->GetParamEventMatch(2,2) ? $this->GetParamEventMatch(2,2) : 1;
		/**
		 * Получаем список топиков
		 */
		$aResult=$this->Topic_GetTopicsTypeNocomments($this->oType->getTypeUrl(),$iPage,Config::Get('module.topic.per_page'));
		$aTopics=$aResult['collection'];
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('topics_list_show',array('aTopics'=>$aTopics));
		/**
		 * Формируем постраничность
		 */
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.topic.per_page'),Config::Get('pagination.pages.count'),Router::GetPath('index').'type/'.$this->oType->getTypeUrl().'/nocomments');
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aTopics',$aTopics);
		$this->Viewer_Assign('aPaging',$aPaging);
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('index');

	}
}
?>