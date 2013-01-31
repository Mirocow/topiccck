{if $oType && $oType->getFields()}
	{foreach from=$oType->getFields() item=oField}
		{include file="`$aTemplatePathPlugin.topiccck`forms/form_field_`$oField->getFieldType()`.tpl" oField=$oField}
	{/foreach}
{/if}