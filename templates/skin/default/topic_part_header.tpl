{if in_array(Config::Get('view.skin'),Config::Get('plugin.topiccck.developer_based'))}
	{include file="`$aTemplatePathPlugin.topiccck`/topic_part_header.developer.tpl"}
{else}
	{include file="`$aTemplatePathPlugin.topiccck`/topic_part_header.synio.tpl"}
{/if}