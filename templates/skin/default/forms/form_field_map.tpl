{if $oField}
	{assign var=field_id value=$oField->getFieldId()}

	{assign var="maptype" value=$oConfig->GetValue('plugin.topiccck.map_type')}
	{include file="`$aTemplatePathPlugin.topiccck`/forms/maps/`$maptype`/edit.tpl" oField=$oField}
{/if}