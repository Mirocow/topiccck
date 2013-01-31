{include file='header.tpl' showWhiteBack=true menu='topiccck'}

{literal}
<script>

function selectfield(f){
	$('#select_inputval').hide();
	$('#daoobj_select').hide();
	//для типа выпадающий список
	if(f=='select'){
		$('#select_inputval').show();
	}
	//для ДАосвязей
	if(f=='daoobj'){
		$('#daoobj_select').show();
	}
}
	
var fixHelper = function(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
};

var sortSave = function(e, ui) {
	var notes = $('#sortable tbody.content tr');
	if (notes.length > 0) {
		var order = [];
		$.each(notes.get().reverse(), function(index, value) {
			order.push({'id': $(value).attr('id'), 'order': index});
		});
		ls.ajax(aRouter['ajax']+'ajaxtopiccckchangeorderfields/', {'order':order}, function(response){
			if (!response.bStateError) {
			   ls.msg.notice(response.sMsgTitle,response.sMsg);
			} else {
			   ls.msg.error(response.sMsgTitle,response.sMsg);
			}
		});
	}
};

$(function() {
	$( "#sortable tbody.content" ).sortable({
		helper: fixHelper
	});
	$( "#sortable tbody.content" ).disableSelection();

	$( "#sortable tbody.content" ).sortable({
	   stop: sortSave
	});
});
</script>
{/literal}


{if $sEvent=='add'}
	<h2 class="page-header">{$aLang.plugin.topiccck.add_title}</h2>
{elseif $sEvent=='edit'}
	<h2 class="page-header">{$aLang.plugin.topiccck.edit_title}: {$oType->getTypeTitle()|escape:'html'}</h2>
{/if}

<form method="POST" name="typeadd" enctype="multipart/form-data">
	
	<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />

	<p><label for="type_title">{$aLang.plugin.topiccck.title}:</label>
		<input type="text" id="type_title" name="type_title" value="{$_aRequest.type_title}" class="input-text input-width-300" />
		<span class="note">{$aLang.plugin.topiccck.title_notice}</span>
	</p>
	<p><label for="type_title_decl">{$aLang.plugin.topiccck.title_decl}:</label>
		<input type="text" id="type_title_decl" name="type_title_decl" value="{$_aRequest.type_title_decl}" class="input-text input-width-300" />
		<span class="note">{$aLang.plugin.topiccck.title_decl_notice}</span>
	</p>

	<p {if $oType && !$oType->getTypeCandelete()}style="display:none;"{/if}><label for="type_url">{$aLang.plugin.topiccck.url}:</label>
		<input type="{if isset($_aRequest.type_candelete) && $_aRequest.type_candelete=='0'}hidden{else}text{/if}" id="type_url" name="type_url" value="{$_aRequest.type_url}" class="input-text input-width-300" />
		<span class="note">{$aLang.plugin.topiccck.url_notice}</span>
	</p>

	<p><label for="type_access">{$aLang.plugin.topiccck.type_access}:</label>
		<select name="type_access" id="type_access" class="input-width-250">
			<option value="1" {if $_aRequest.type_access=='1'}selected{/if}>{$aLang.plugin.topiccck.type_access_all}</option>
			<option value="2" {if $_aRequest.type_access=='2'}selected{/if}>{$aLang.plugin.topiccck.type_access_admin}</option>
			{if $aPluginActive.role}<option value="4" {if $_aRequest.type_access=='4'}selected{/if}>{$aLang.plugin.topiccck.type_access_role}</option>{/if}
		</select>
		<small class="note">{$aLang.plugin.topiccck.type_access_notice}</small>
	</p>


{if $sEvent=='edit'}
	<p>
		<h2 class="page-header">{$aLang.plugin.topiccck.fields_added}</h3>

		<table id="sortable" width="100%" cellspacing="0" class="table">
			<thead class="topiccck_thead">
				<tr>
					<td align="center"><b>{$aLang.plugin.topiccck.type}</b></td>
					<td align="center"><b>{$aLang.plugin.topiccck.name}</b></td>
					<td align="center"><b>{$aLang.plugin.topiccck.description}</b></td>
					{*<td align="center"><b>{$aLang.plugin.topiccck.values}</b></td>*}
					<td align="center"><b>{$aLang.plugin.topiccck.actions}</b></td>
				</tr>
			</thead>

			<tbody class="content">
					{foreach from=$oType->getFields() item=oField name=el2}
						<tr id="{$oField->getFieldId()}" class="cursor-x">
							<td align="center">
								{$oField->getFieldType()}
							</td>
							<td align="center">
								{$oField->getFieldName()}
							</td>
							<td align="center">
								{$oField->getFieldDescription()}
							</td>
							{*<td align="center">
								{if $oField->getFieldType()=='select'}
									{$oField->getFieldDescription()}
								{else}
									&mdash;
								{/if}
							</td>*}
							<td align="center">
								<a href="{router page='cckadmin'}fieldedit/{$oField->getFieldId()}/">{$aLang.plugin.topiccck.edit}</a>
								|
								<a href="{router page='cckadmin'}fielddelete/{$oField->getFieldId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" onclick="return confirm('{$aLang.plugin.topiccck.field_detele_confirm}');">{$aLang.plugin.topiccck.delete}</a>
							</td>
						</tr>
					{/foreach}
			</tbody>
		</table>

	</p>

<p>
	<a class="button fl-r" href="{router page="cckadmin"}fieldadd/{$oType->getTypeUrl()}/">{$aLang.plugin.topiccck.add_field}</a><br/>
</p>
{/if}

<div class="submit_topiccck_button">
	<p>
		<button type="submit" class="button button-primary" name="submit_type_add">{$aLang.plugin.topiccck.submit}</button>
	</p>
	{if $sEvent=='add'}
		<p><span class="note">{$aLang.plugin.topiccck.afteradd}</span></p>
	{/if}
</div>
</form>

{include file='footer.tpl'}