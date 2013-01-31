{if $oTopic->getCloseAccess()}

    {if $bTopicList}
        {$oTopic->getTextShort()}

        {if $oTopic->getTextShort()!=$oTopic->getText()}
            <br/>
            <a href="{$oTopic->getUrl()}#cut" title="{$aLang.topic_read_more}">
                {if $oTopic->getCutText()}
                    {$oTopic->getCutText()}
                    {else}
                    {$aLang.topic_read_more} &rarr;
                {/if}
            </a>
        {/if}


	{else}
		{$oTopic->getText()}
	{/if}
	{hook run='topic_content_end' topic=$oTopic bTopicList=$bTopicList}
{else}
<form action="{$oTopic->getUrl()}" method="post">
    {if $oTopic->getCloseFriend()}
        {include file="$sTPTca/topic_friend.tpl"}
    {/if}
    {if $oTopic->getClose18plus()}
        {include file="$sTPTca/topic_18plus.tpl"}
    {/if}
    {if $oTopic->getClosePassword()}
        {include file="$sTPTca/topic_password.tpl"}
    {/if}
    <div style="text-align: center;">
        <input type="submit" name="topic_close" class="button button-primary" value="{$aLang.plugin.tca.topic_access_button}" />
    </div>
</form>
{/if}
