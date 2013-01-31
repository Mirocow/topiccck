{include file='header.tpl' showWhiteBack=true menu='topiccck'}

{literal}
<script>

function selectfield(f){
	$('#select_inputval').css({'display':'none'});
	$('#daoobj_select').css({'display':'none'});
	//для типа выпадающий список
	if(f=='select'){
		$('#select_inputval').css({'display':'block'});
	}
	//для ДАОсвязей
	if(f=='daoobj'){
		$('#daoobj_select').css({'display':'block'});
	}
	return false;
}
</script>
{/literal}


{if $sEvent=='fieldadd'}
	<h2 class="page-header">{$aLang.plugin.topiccck.add_field_title} ({$aLang.plugin.topiccck.for} "{$oType->getTypeTitle()|escape:'html'}")</h2>
{elseif $sEvent=='fieldedit'}
	<h2 class="page-header">{$aLang.plugin.topiccck.edit_field_title}: {$oField->getFieldName()|escape:'html'} ({$aLang.plugin.topiccck.for} "{$oType->getTypeTitle()|escape:'html'}")</h2>
{/if}

<form action="" method="post" id="popup-login-form">
	<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
		{*<input type="hidden" name="topic_type" value="{$oType->getTypeId()}"/>*}

		<p><label for="field_type">{$aLang.plugin.topiccck.type}:</label>
			<select name="field_type" id="field_type" onChange="selectfield(jQuery(this).val());" class="input-text input-width-300" {if $sEvent=='fieldedit'}disabled{/if}>
				<option value="input" {if $_aRequest.field_type=='input'}selected{/if} title="{$aLang.plugin.topiccck.field_input_notice}">{$aLang.plugin.topiccck.field_input}</from>
				<option value="textarea" {if $_aRequest.field_type=='textarea'}selected{/if} title="{$aLang.plugin.topiccck.field_textarea_notice}">{$aLang.plugin.topiccck.field_textarea}</from>
				<option value="select" {if $_aRequest.field_type=='select'}selected{/if} title="{$aLang.plugin.topiccck.field_select_notice}">{$aLang.plugin.topiccck.field_select}</from>
				<option value="date" {if $_aRequest.field_type=='date'}selected{/if} title="{$aLang.plugin.topiccck.field_date_notice}">{$aLang.plugin.topiccck.field_date}</from>
				<option value="map" {if $_aRequest.field_type=='map'}selected{/if} title="{$aLang.plugin.topiccck.field_map_notice}">{$aLang.plugin.topiccck.field_map}</from>
				<option value="link" {if $_aRequest.field_type=='link'}selected{/if} title="{$aLang.plugin.topiccck.field_link_notice}">{$aLang.plugin.topiccck.field_link}</from>
				<option value="file" {if $_aRequest.field_type=='file'}selected{/if} title="{$aLang.plugin.topiccck.field_file_notice}">{$aLang.plugin.topiccck.field_file}</from>
				{if !$oType->isPhotosetEnable() && $oType->getTypeCandelete()}<option value="photoset" {if $_aRequest.field_type=='photoset'}selected{/if} title="{$aLang.plugin.topiccck.field_photoset_notice}">{$aLang.plugin.topiccck.field_photoset}</from>{/if}
				<option value="daoobj" {if $_aRequest.field_type=='daoobj'}selected{/if} title="{$aLang.plugin.topiccck.field_daoobj_notice}">{$aLang.plugin.topiccck.field_daoobj}</from>
				{if !$oType->isLitepollEnable()}<option value="litepoll" {if $_aRequest.field_type=='litepoll'}selected{/if} title="{$aLang.plugin.topiccck.field_litepoll_notice}">{$aLang.plugin.topiccck.field_litepoll}</from>{/if}
				{*<option value="gallery" {if $_aRequest.field_type=='gallery'}selected{/if} title="{$aLang.plugin.topiccck.field_gallery_notice}">{$aLang.plugin.topiccck.field_gallery}</from>*}


			</select>
		</p>

		<p><input type="text" name="field_name" value="{$_aRequest.field_name}" placeholder="{$aLang.plugin.topiccck.name}" class="input-text input-width-300"></p>

		<p><input type="text" name="field_description" value="{$_aRequest.field_description}" placeholder="{$aLang.plugin.topiccck.description}" class="input-text input-width-300"></p>

		<p {if !$_aRequest.field_type || $_aRequest.field_type!='select'}style="display:none;"{/if} id="select_inputval">
			<textarea name="field_values" id="field_values" placeholder="{$aLang.plugin.topiccck.values}" class="input-text input-width-300" rows="5">{$_aRequest.field_values}</textarea>
		</p>

		<p {if !$_aRequest.field_type || $_aRequest.field_type!='daoobj'}style="display:none;"{/if} id="daoobj_select">
			{if $aPluginActive.dao}
				{include file="`$aTemplatePathPlugin.dao`inject.topiccck.tpl"}
			{else}
				{$aLang.plugin.topiccck.buydao}
			{/if}
		</p>

		<p><button type="submit"  name="submit_field" class="button button-primary" id="popup-field-submit">{$aLang.plugin.topiccck.submit}</button></p>
	</form>


{include file='footer.tpl'}