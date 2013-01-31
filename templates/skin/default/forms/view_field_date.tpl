{if $oField}
	<p><b>{$oField->getFieldName()}</b>:
		<time datetime="{date_format date=$oTopic->getExtraValueCck($oField->getFieldId()) format='c'}" title="{date_format date=$oTopic->getExtraValueCck($oField->getFieldId()) format='j F Y'}">
			{date_format date=$oTopic->getExtraValueCck($oField->getFieldId()) format="j F Y"}
		</time>
	</p>
{/if}