{include file='header.tpl' showWhiteBack=true menu='topiccck'}

{literal}
<script>
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
		ls.ajax(aRouter['ajax']+'ajaxtopiccckchangeordertypes/', {'order':order}, function(response){
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


{if count($aTypes)>0}
<h2 class="page-header">{$aLang.plugin.topiccck.types_list}</h2>

<a href="{router page="cckadmin"}add/"><button type="button" class="button">{$aLang.plugin.topiccck.add}</button></a>
<br /><br />

<table width="100%" cellspacing="0" class="table" id="sortable">
	<thead class="topiccck_thead">
		<tr>
			<td width="200px"><b>{$aLang.plugin.topiccck.title}</b></td>
			<td align="center"><b>{$aLang.plugin.topiccck.url}</b></td>
			<td align="center"><b>{$aLang.plugin.topiccck.status}</b></td>
			<td align="center" width="160px"><b>{$aLang.plugin.topiccck.actions}</b></td>
		</tr>
	</thead>
	
	<tbody class="content">
		{foreach from=$aTypes item=oType name=el2}
			<tr id="{$oType->getTypeId()}" class="cursor-x">
				<td>
				{$oType->getTypeTitle()|escape:'html'}{if !$oType->getTypeCandelete()} <em>[{$aLang.plugin.topiccck.standart}]</em>{/if}
				</td>
				<td align="center">
					{$oType->getTypeUrl()|escape:'html'}
				</td>
				<td align="center">
					{if $oType->getTypeActive()}
						<span class="topiccck-on">{$aLang.plugin.topiccck.on}</span>
					{else}
						<span class="topiccck-off">{$aLang.plugin.topiccck.off}</span>
					{/if}
				</td>
				<td align="center">
					<a href="{router page='cckadmin'}?toggle={if $oType->getTypeActive()}off{else}on{/if}&type_id={$oType->getTypeId()}&security_ls_key={$LIVESTREET_SECURITY_KEY}">{if $oType->getTypeActive()}{$aLang.plugin.topiccck.turn_off}{else}{$aLang.plugin.topiccck.turn_on}{/if}</a>
					|
					<a href="{router page='cckadmin'}edit/{$oType->getTypeUrl()}/" alt="{$aLang.plugin.dao.catalog_settings}"><img src="{$aTemplateWebPathPlugin.topiccck}img/settings.gif" /></a>
                    {*if $oType->getTypeCandelete()}|
						<a href="{router page='cckadmin'}delete/{$oType->getTypeId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" onclick="return confirm('{$aLang.plugin.topiccck.delete_confirm}');" title="{$aLang.plugin.topiccck.delete}"><img src="{$aTemplateWebPathPlugin.topiccck}img/delete.gif" /></a>
					{/if*}
				</td>
			</tr>
		{/foreach}
	</tbody>
</table>
{/if}

{include file='footer.tpl'}