<ul class="nav nav-menu">
	<li {if $sAction=='cckadmin' && $sEvent==''}class="active"{/if}>
		<a href="{router page='cckadmin'}">{$aLang.plugin.topiccck.menu}</a>
	</li>
	{hook run='topiccck_main_menu'}
</ul>