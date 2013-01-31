<br />
<label><input type="checkbox" name="role[topiccck]" id="role_topiccck" value="1" onclick="sh(this)" /> {$aLang.plugin.topiccck.role_topiccck}</label>
<div id="role_topiccck_box" class="opt-role">
	{foreach from=$aTopicTypes item=oType}
		<label><input type="checkbox" name="role[topiccck][{$oType->getTypeUrl()}]" value="1" id="topiccck_{$oType->getTypeUrl()}_add" /> {$oType->getTypeTitle()|escape:'html'}</label><br />
	{/foreach}
</div>