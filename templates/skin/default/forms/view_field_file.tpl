{if $oField}
	<p><b>{$oField->getFieldName()}</b>:
		{assign var=oFile value=$oTopic->getFile($oField->getFieldId())}

		<a href="{router page="type"}download/{$oTopic->getTopicId()}/{$oField->getFieldId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}">{$oFile->getFileName()}</a>
		{$oFile->getSizeFormat()}
		({$aLang.plugin.topiccck.count_downloads}: {$oFile->getFileDownloads()})

	</p>
{/if}