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

class PluginTopiccck_ActionBlog extends PluginTopiccck_Inherit_ActionBlog {
	
	protected $oType=null;

	public function Init(){
		parent::Init();
		$this->aBadBlogUrl[]='type';
	}

	protected function RegisterEvent() {

		//фильтр при просмотре топиков из главной страницы блогов
		//$this->AddEventPreg('/^type$/i','/^[\w\-\_]+$/i','/^(page([1-9]\d{0,5}))?$/i','EventTopicsByType');
		
		parent::RegisterEvent();

		//фильтр внутри блога
		$this->AddEventPreg('/^[\w\-\_]+$/i','/^type$/i','/^[\w\-\_]+$/i','/^(page([1-9]\d{0,5}))?$/i','EventTopicsByTypeBlog');

		

	}

	public function EventTopicsByTypeBlog(){
		
		if(!Config::Get('plugin.topiccck.show_blog_filter')){
			return parent::EventNotFound();
		}

		if(in_array($this->sCurrentEvent,$this->aBadBlogUrl)){
			return parent::EventNotFound();
		}

		$sBlogUrl=$this->sCurrentEvent;
		/**
		 * Проверяем есть ли блог с таким УРЛ
		 */
		if (!($oBlog=$this->Blog_GetBlogByUrl($sBlogUrl))) {
			return parent::EventNotFound();
		}
		/**
		 * Передан ли номер страницы
		 */
		$iPage= $this->GetParamEventMatch(2,2) ? $this->GetParamEventMatch(2,2) : 1;
		/**
		 * Определяем права на отображение закрытого блога
		 */
		if($oBlog->getType()=='close'
			and (!$this->oUserCurrent
				or !in_array(
					$oBlog->getId(),
					$this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent)
				)
			)
		) {
			$bCloseBlog=true;
		} else {
			$bCloseBlog=false;
		}
		/**
		 * Меню
		 */
		//$this->sMenuSubItemSelect=$sShowType=='newall' ? 'new' : $sShowType;
		$this->sMenuSubBlogUrl=$oBlog->getUrlFull();
		/*
		 * Проверяем есть ли такой тип и активен ли он
		 */
		if(!$this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes')  ||
			!in_array(Router::GetParam(1), $this->Viewer_GetSmartyObject()->getTemplateVars('aTopicTypes'))){

			return parent::EventNotFound();
		}
		if(!$this->oType=$this->PluginTopiccck_Topiccck_GetTopicTypeByTypeUrl(Router::GetParam(1))){
			return parent::EventNotFound();
		}
		
		if (!$bCloseBlog) {
			/**
			 * Получаем список топиков
			 */
			$aResult=$this->Topic_GetBlogTopicsByType($oBlog,$this->oType->getTypeUrl(),$iPage,Config::Get('module.topic.per_page'));

			$aTopics=$aResult['collection'];

			/**
			 * Получаем число новых топиков в текущем блоге
			 */
			$this->iCountTopicsBlogNew=$this->Topic_GetCountTopicsByBlogNew($oBlog);
			/**
			* Формируем постраничность
			*/
			$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.topic.per_page'),Config::Get('pagination.pages.count'),$oBlog->getUrlFull().'type/'.$this->oType->getTypeUrl().'/');
			/**
			* Загружаем переменные в шаблон
			*/
			$this->Viewer_Assign('aPaging',$aPaging);
			$this->Viewer_Assign('aTopics',$aTopics);
		}
		/**
		 * Выставляем SEO данные
		 */
		$sTextSeo=strip_tags($oBlog->getDescription());
		$this->Viewer_SetHtmlDescription(func_text_words($sTextSeo, Config::Get('seo.description_words_count')));
		/**
		 * Получаем список юзеров блога
		 */
		$aBlogUsersResult=$this->Blog_GetBlogUsersByBlogId($oBlog->getId(),ModuleBlog::BLOG_USER_ROLE_USER,1,Config::Get('module.blog.users_per_page'));
		$aBlogUsers=$aBlogUsersResult['collection'];
		$aBlogModeratorsResult=$this->Blog_GetBlogUsersByBlogId($oBlog->getId(),ModuleBlog::BLOG_USER_ROLE_MODERATOR);
		$aBlogModerators=$aBlogModeratorsResult['collection'];
		$aBlogAdministratorsResult=$this->Blog_GetBlogUsersByBlogId($oBlog->getId(),ModuleBlog::BLOG_USER_ROLE_ADMINISTRATOR);
		$aBlogAdministrators=$aBlogAdministratorsResult['collection'];
		/**
		 * Для админов проекта получаем список блогов и передаем их во вьювер
		 */
		if($this->oUserCurrent and $this->oUserCurrent->isAdministrator()) {
			$aBlogs = $this->Blog_GetBlogs();
			unset($aBlogs[$oBlog->getId()]);

			$this->Viewer_Assign('aBlogs',$aBlogs);
		}
		/**
		 * Вызов хуков
		 */
		//$this->Hook_Run('blog_collective_show',array('oBlog'=>$oBlog,'sShowType'=>$sShowType));
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aBlogUsers',$aBlogUsers);
		$this->Viewer_Assign('aBlogModerators',$aBlogModerators);
		$this->Viewer_Assign('aBlogAdministrators',$aBlogAdministrators);
		$this->Viewer_Assign('iCountBlogUsers',$aBlogUsersResult['count']);
		$this->Viewer_Assign('iCountBlogModerators',$aBlogModeratorsResult['count']);
		$this->Viewer_Assign('iCountBlogAdministrators',$aBlogAdministratorsResult['count']+1);
		$this->Viewer_Assign('oBlog',$oBlog);
		$this->Viewer_Assign('bCloseBlog',$bCloseBlog);
		
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('blog');
	}

	public function EventTopicsByType(){

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
		$aResult=$this->Topic_GetTopicsByType($iPage,Config::Get('module.topic.per_page'),$this->oType->getTypeUrl(),true,array('open'));


		$aTopics=$aResult['collection'];
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('topics_list_show',array('aTopics'=>$aTopics));
		/**
		 * Формируем постраничность
		 */
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.topic.per_page'),Config::Get('pagination.pages.count'),Router::GetPath('blog').'type/'.$this->oType->getTypeUrl());
		/**
		 * Вызов хуков
		 */
		//$this->Hook_Run('blog_show',array('sShowType'=>$sShowType));
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

	public function EventShutdown(){
		parent::EventShutdown();
		$this->Viewer_Assign('sEventReal',$this->GetCurrentEventName());
	}
	

}
?>