{if $oField}
	{assign var="maptype" value=$oConfig->GetValue('plugin.topiccck.map_type')}
	{include file="`$aTemplatePathPlugin.topiccck`/forms/maps/`$maptype`/show.tpl" oField=$oField}
{/if}