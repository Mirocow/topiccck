<br />
<label><input type="checkbox"{if $aRole.topiccck} checked{/if} name="role[topiccck]" id="role_topiccck{$sId}" value="1" onclick="sh(this)" /> {$aLang.plugin.topiccck.role_topiccck}</label>
<div id="role_topiccck{$sId}_box" class="opt-role">
	{foreach from=$aTopicTypes item=oType}
		{assign var=type value=$oType->getTypeUrl()}
		<label><input type="checkbox"{if $aRole.topiccck.$type} checked{/if} name="role[topiccck][{$oType->getTypeUrl()}]" value="1" id="topiccck_{$oType->getTypeUrl()}{$sId}_add" /> {$oType->getTypeTitle()|escape:'html'}</label><br />
	{/foreach}
</div>