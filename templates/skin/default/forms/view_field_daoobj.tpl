{if $oField}
	<p><b>{$oField->getFieldName()}</b>:

		{assign var=oDao value=$oField->getDaoobj()}
		{if $oDao->getViewType()=='link'}
			{foreach from=$oDao->getItems($oTopic->getExtraValueCck($oField->getFieldId())) item=oItem name=list}
				<a href="{$oItem->getUrl()}">{$oItem->getItemTitle()|escape:'html'}</a>{if !$smarty.foreach.list.last}, {/if}
			{/foreach}
		{else}
			{include file="`$oDao->getCatalog()->getTemplatePath()`/tpltypes/`$oDao->getCatalog()->getCatalogType()`/view/`$oDao->getCatalog()->getCatalogType()`.list.tpl" aItems=$oDao->getItems($oTopic->getExtraValueCck($oField->getFieldId())) oCatalog=$oDao->getCatalog() aPaging=null aPagingLink=null sAction='topic' sEvent='topic'}
		{/if}
	</p>
{/if}