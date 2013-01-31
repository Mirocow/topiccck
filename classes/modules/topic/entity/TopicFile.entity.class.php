<?php

/*-------------------------------------------------------
*
*	Plugin "TopicCCK"
*	Author: Vladimir Yuriev (extravert)
*	Official site: lsmods.ru
*	Contact e-mail: support@lsmods.ru
*
---------------------------------------------------------
*/

class PluginTopiccck_ModuleTopic_EntityTopicFile extends Entity {

	public function getSizeFormat(){
		$iSize = $this->getFileSize();
		$aSizes = array('B','KiB','MiB','GiB','TiB');
		$i = 0;
		while($iSize>1000){
			$iSize /= 1024;
			$i++;
		}
		return sprintf('%.2f %s', $iSize, $aSizes[$i]);
	}
	
}
?>