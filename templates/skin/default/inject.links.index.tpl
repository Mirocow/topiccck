{if $aPluginActive.flow}<br><br>{/if}
<ul class="nav nav-pills {if !$aPluginActive.flow}mb-20{/if}">
	<li class="graytext">{$aLang.plugin.topiccck.by_type}:</li>
	{foreach from=$aActiveTopicTypes item=oType}
		<li {if $sEvent=='type' && $aParams.0==$oType->getTypeUrl()}class="active"{/if}>
			<a href="{router page='index'}type/{$oType->getTypeUrl()}/{if $sMenuSubItemSelect && in_array($sMenuSubItemSelect,array('newall','discussed','top','nocomments'))}{$sMenuSubItemSelect}/{/if}">{$oType->getTypeTitle()|escape:'html'}</a>
		</li>
	{/foreach}
</ul>