{if $sEventReal && $sEventReal=='blog'}
	<br/><br/><li class="graytext">{$aLang.plugin.topiccck.by_type}:</li>
	{foreach from=$aActiveTopicTypes item=oType}
		<li {if $aParams.0=='type' && $aParams.1==$oType->getTypeUrl()}class="active"{/if}>
			<a href="{router page='blog'}{$sEvent}/type/{$oType->getTypeUrl()}/">{$oType->getTypeTitle()|escape:'html'}</a>
		</li>
	{/foreach}
{/if}