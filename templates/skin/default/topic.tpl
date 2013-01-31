{if $LS->Topic_IsAllowTopicType($oTopic->getType())}
	{if in_array($oTopic->getType(),array('topic','photoset','question','link'))}
		{assign var="sTopicTemplateName" value="topic_`$oTopic->getType()`.tpl"}
		{include file=$sTopicTemplateName}
	{else}
		{include file="`$aTemplatePathPlugin.topiccck`/topic_cck.tpl"}
	{/if}
{/if}