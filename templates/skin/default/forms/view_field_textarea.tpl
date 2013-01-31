{if $oField}
	<p><b>{$oField->getFieldName()}</b>:
		{$oTopic->getExtraValueCck($oField->getFieldId())}
	</p>
{/if}