{include file='topic_part_header.tpl'}

<script type="text/javascript">
	jQuery(window).load(function($) {
		ls.photoset.showMainPhoto({$oTopic->getId()});
	});
</script>

{if $oTopic->getTypeObj()->isPhotosetEnable()}

	{assign var=oMainPhoto value=$oTopic->getPhotosetMainPhotoCck()}
	{if $oMainPhoto}
	<div class="topic-photo-preview" id="photoset-main-preview-{$oTopic->getId()}" onclick="window.location='{$oTopic->getUrl()}#photoset'">
		<div class="topic-photo-count" id="photoset-photo-count-{$oTopic->getId()}">{$oTopic->getPhotosetCount()} {$aLang.topic_photoset_photos}</div>

		{if $oMainPhoto->getDescription()}
			<div class="topic-photo-desc" id="photoset-photo-desc-{$oTopic->getId()}">{$oMainPhoto->getDescription()}</div>
		{/if}

		<img src="{$oMainPhoto->getWebPath(500)}" alt="image" id="photoset-main-image-{$oTopic->getId()}" />
	</div>
	{/if}
	{assign var=iPhotosCount value=$oTopic->getPhotosetCount()}
{/if}

<div class="topic-content text">
	{hook run='topic_content_begin' topic=$oTopic bTopicList=$bTopicList}

	{if $aPluginActive.tca}
		{* если подключен плагин topic access то используем интеграцию*}
		{include file="`$aTemplatePathPlugin.topiccck`/tca.tpl"}
	{else}
		{if $bTopicList}
			{$oTopic->getTextShort()}

			{if $oTopic->getTextShort()!=$oTopic->getText()}
				<br/>
				<a href="{$oTopic->getUrl()}#cut" title="{$aLang.topic_read_more}">
					{if $oTopic->getCutText()}
						{$oTopic->getCutText()}
					{else}
						{if $oTopic->getTypeObj()->isPhotosetEnable()}
							{$aLang.topic_photoset_show_all|ls_lang:"COUNT%%`$iPhotosCount`"}
						{else}
							{$aLang.topic_read_more}
						{/if}
						 &rarr;
					{/if}
				</a>
			{/if}
		{else}
			{$oTopic->getText()}
		{/if}
		{hook run='topic_content_end' topic=$oTopic bTopicList=$bTopicList}
	{/if}
	
</div>


{include file='topic_part_footer.tpl'}
