{if $oField}
	<script type="text/javascript" src="{cfg name='path.root.engine_lib'}/external/prettyPhoto/js/prettyPhoto.js"></script>
	<link rel='stylesheet' type='text/css' href="{cfg name='path.root.engine_lib'}/external/prettyPhoto/css/prettyPhoto.css" />
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('.photoset-image').prettyPhoto({
				social_tools:'',
				show_title: false,
				slideshow:false,
				deeplinking: false
			});
		});
	</script>


	<div class="topic-photo-images">
		<h2>{$oTopic->getPhotosetCount()} {$oTopic->getPhotosetCount()|declension:$aLang.topic_photoset_count_images}</h2>
		<a name="photoset"></a>

		<ul id="topic-photo-images">
			{assign var=aPhotos value=$oTopic->getPhotosetPhotos(0, $oConfig->get('module.topic.photoset.per_page'))}
			{if count($aPhotos)}
				{foreach from=$aPhotos item=oPhoto}
					<li><a class="photoset-image" href="{$oPhoto->getWebPath(1000)}" rel="[photoset]"  title="{$oPhoto->getDescription()}"><img src="{$oPhoto->getWebPath('50crop')}" alt="{$oPhoto->getDescription()}" /></a></li>
					{assign var=iLastPhotoId value=$oPhoto->getId()}
				{/foreach}
			{/if}
			<script type="text/javascript">
				ls.photoset.idLast='{$iLastPhotoId}';
			</script>
		</ul>

		{if count($aPhotos)<$oTopic->getPhotosetCount()}
			<a href="javascript:ls.photoset.getMore({$oTopic->getId()})" id="topic-photo-more" class="topic-photo-more">{$aLang.topic_photoset_show_more} &darr;</a>
		{/if}
	</div>
{/if}