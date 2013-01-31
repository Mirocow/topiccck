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

class PluginTopiccck_ModuleTopic extends PluginTopiccck_Inherit_ModuleTopic {
	
	protected $aTopicTypes=array(
		
	);

	/**
	 * Получает список топиков по типам
	 *
	 * @param  int    $iPage	Номер страницы
	 * @param  int    $iPerPage	Количество элементов на страницу
	 * @param  bool   $bAddAccessible Указывает на необходимость добавить в выдачу топики,
	 *                                из блогов доступных пользователю. При указании false,
	 *                                в выдачу будут переданы только топики из общедоступных блогов.
	 * @return array
	 */
	public function GetTopicsByType($iPage,$iPerPage,$sType,$bAddAccessible=true,$aTypes=array('personal','open','dao')) {
		$aFilter=array(
			'blog_type' => $aTypes,
			'topic_publish' => 1,
			'topic_type'=>$sType
		);
		/**
		 * Если пользователь авторизирован, то добавляем в выдачу
		 * закрытые блоги в которых он состоит
		 */
		if($this->oUserCurrent && $bAddAccessible) {
			$aOpenBlogs = $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent);
			if(count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
		}
		return $this->GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}

	public function GetBlogTopicsByType($oBlog,$sType,$iPage,$iPerPage) {
		$aFilter=array(
			'blog_id'=>$oBlog->getId(),
			/*'blog_type' => array(
				'open',
			),*/
			'topic_publish' => 1,
			'topic_type'=>$sType
		);
		return $this->GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}

	public function GetTopicsNocomments($iPage,$iPerPage,$bAddAccessible=true) {
		$aFilter=array(
			'topic_count_comment' => 0,
			'topic_publish' => 1,
		);
		/**
		 * Если пользователь авторизирован, то добавляем в выдачу
		 * закрытые блоги в которых он состоит
		 */
		if($this->oUserCurrent && $bAddAccessible) {
			$aOpenBlogs = $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent);
			if(count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
		}
		return $this->GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}


	public function GetTopicsTypeDiscussed($sType,$iPage,$iPerPage,$sPeriod=null,$bAddAccessible=true) {
		if (is_numeric($sPeriod)) {
			// количество последних секунд
			$sPeriod=date("Y-m-d H:00:00",time()-$sPeriod);
		}

		$aFilter=array(
			'topic_type'=>$sType,
			'blog_type' => array(
				'personal',
				'open',
				'dao'
			),
			'topic_publish' => 1
		);
		if ($sPeriod) {
			$aFilter['topic_date_more'] = $sPeriod;
		}
		$aFilter['order']=' t.topic_count_comment desc, t.topic_id desc ';
		/**
		 * Если пользователь авторизирован, то добавляем в выдачу
		 * закрытые блоги в которых он состоит
		 */
		if($this->oUserCurrent && $bAddAccessible) {
			$aOpenBlogs = $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent);
			if(count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
		}
		return $this->GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}

	public function GetTopicsTypeTop($sType,$iPage,$iPerPage,$sPeriod=null,$bAddAccessible=true) {
		if (is_numeric($sPeriod)) {
			// количество последних секунд
			$sPeriod=date("Y-m-d H:00:00",time()-$sPeriod);
		}

		$aFilter=array(
			'topic_type'=>$sType,
			'blog_type' => array(
				'personal',
				'open',
				'dao'
			),
			'topic_publish' => 1
		);
		if ($sPeriod) {
			$aFilter['topic_date_more'] = $sPeriod;
		}
		$aFilter['order']=array('t.topic_rating desc','t.topic_id desc');
		/**
		 * Если пользователь авторизирован, то добавляем в выдачу
		 * закрытые блоги в которых он состоит
		 */
		if($this->oUserCurrent && $bAddAccessible) {
			$aOpenBlogs = $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent);
			if(count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
		}
		return $this->GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}

	public function GetTopicsTypeNewAll($sType,$iPage,$iPerPage,$bAddAccessible=true) {
		$aFilter=array(
			'topic_type'=>$sType,
			'blog_type' => array(
				'personal',
				'open',
				'dao'
			),
			'topic_publish' => 1,
		);
		/**
		 * Если пользователь авторизирован, то добавляем в выдачу
		 * закрытые блоги в которых он состоит
		 */
		if($this->oUserCurrent && $bAddAccessible) {
			$aOpenBlogs = $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent);
			if(count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
		}
		return $this->GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}


	public function GetTopicsTypeNocomments($sType,$iPage,$iPerPage,$bAddAccessible=true) {
		$aFilter=array(
			'topic_type'=>$sType,
			'blog_type' => array(
				'personal',
				'open',
				'dao'
			),
			'topic_count_comment' => 0,
			'topic_publish' => 1,
		);
		/**
		 * Если пользователь авторизирован, то добавляем в выдачу
		 * закрытые блоги в которых он состоит
		 */
		if($this->oUserCurrent && $bAddAccessible) {
			$aOpenBlogs = $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent);
			if(count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
		}
		return $this->GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}


	public function changeEnum($sTypeOld,$sTypeNew){
		return $this->oMapperTopic->changeEnum($sTypeOld,$sTypeNew);
	}



}
?>