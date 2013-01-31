{if $oField}
	{assign var=field_id value=$oField->getFieldId()}
	<p><label for="field-{$oField->getFieldId()}">{$oField->getFieldName()}:</label>
		{if $aLinksItems[$oField->getFieldId()]}
			<select class="input" name="fields[{$oField->getFieldId()}][]" id="field[{$oField->getFieldId()}]" {if $oField->getDaoobj()->getLinkDisplayType()=='multiple'}multiple{/if}>
			{if $oField->getDaoobj()->getLinkDisplayType()=='once'}
				<option value="">{$aLang.plugin.dao.catalog_links_no_linked}</option>
			{/if}
			{foreach from=$aLinksItems[$oField->getFieldId()] item=oItem}
				<option value="{$oItem->getItemId()}" {if is_array($_aRequest.fields.$field_id) && in_array($oItem->getItemId(),$_aRequest.fields.$field_id)}selected{/if} >{$oItem->getItemTitle()|escape}</option>
			{/foreach}
			</select>
		{else}
			{$aLang.plugin.dao.catalog_links_no_data_for_linking}
		{/if}
	<span class="note">{$oField->getFieldDescription()}</span>
	</p>
{/if}