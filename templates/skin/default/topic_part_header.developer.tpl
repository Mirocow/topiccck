{assign var="oBlog" value=$oTopic->getBlog()}
{assign var="oUser" value=$oTopic->getUser()}
{assign var="oVote" value=$oTopic->getVote()}


<article class="topic topic-type-{$oTopic->getFuncType()} js-topic">
	<header class="topic-header">
		<h1 class="topic-title word-wrap">
			{if $oTopic->getPublish() == 0}   
				<i class="icon-tag" title="{$aLang.topic_unpublish}"></i>
			{/if}
			
			{if $oTopic->getType() == 'link'} 
				<i class="icon-share-alt" title="{$aLang.topic_link}"></i>
			{/if}
			
			{if $bTopicList}
				<a href="{$oTopic->getUrl()}">{$oTopic->getTitle()|escape:'html'}</a>
			{else}
				{$oTopic->getTitle()|escape:'html'}
			{/if}
		</h1>
		
		
		{if $oTopic->getType() == 'link'}
			<div class="topic-url">
				<a href="{router page='link'}go/{$oTopic->getId()}/" title="{$aLang.topic_link_count_jump}: {$oTopic->getLinkCountJump()}">{$oTopic->getLinkUrl()}</a>
			</div>
		{/if}
		
		
		<div class="topic-info">
			<a href="{$oBlog->getUrlFull()}" class="topic-blog">{$oBlog->getTitle()|escape:'html'}</a>
			
			<time datetime="{date_format date=$oTopic->getDateAdd() format='c'}" title="{date_format date=$oTopic->getDateAdd() format='j F Y, H:i'}">
				{date_format date=$oTopic->getDateAdd() format="j F Y, H:i"}
			</time>
			
			{*<ul class="actions">
				{if $oUserCurrent and ($oUserCurrent->getId()==$oTopic->getUserId() or $oUserCurrent->isAdministrator() or $oBlog->getUserIsAdministrator() or $oBlog->getUserIsModerator() or $oBlog->getOwnerId()==$oUserCurrent->getId())}
					<li><a href="{cfg name='path.root.web'}/{$oTopic->getType()}/edit/{$oTopic->getId()}/" title="{$aLang.topic_edit}" class="actions-edit">{$aLang.topic_edit}</a></li>
				{/if}
				
				{if $oUserCurrent and ($oUserCurrent->isAdministrator() or $oBlog->getUserIsAdministrator() or $oBlog->getOwnerId()==$oUserCurrent->getId())}
					<li><a href="{router page='topic'}delete/{$oTopic->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" title="{$aLang.topic_delete}" onclick="return confirm('{$aLang.topic_delete_confirm}');" class="actions-delete">{$aLang.topic_delete}</a></li>
				{/if}
			</ul>*}
		</div>

		{if Config::Get('view.skin')=='social'}
		<div id="vote_area_topic_{$oTopic->getId()}" class="vote
															{if $oVote || ($oUserCurrent && $oTopic->getUserId() == $oUserCurrent->getId()) || strtotime($oTopic->getDateAdd()) < $smarty.now-$oConfig->GetValue('acl.vote.topic.limit_time')}
																{if $oTopic->getRating() > 0}
																	vote-count-positive
																{elseif $oTopic->getRating() < 0}
																	vote-count-negative
																{/if}
															{/if}

															{if $oVote}
																voted

																{if $oVote->getDirection() > 0}
																	voted-up
																{elseif $oVote->getDirection() < 0}
																	voted-down
																{/if}
															{/if}">
			{if $oVote || ($oUserCurrent && $oTopic->getUserId() == $oUserCurrent->getId()) || strtotime($oTopic->getDateAdd()) < $smarty.now-$oConfig->GetValue('acl.vote.topic.limit_time')}
				{assign var="bVoteInfoShow" value=true}
			{/if}
			<div class="vote-up" onclick="return ls.vote.vote({$oTopic->getId()},this,1,'topic');"></div>
			<div class="vote-down" onclick="return ls.vote.vote({$oTopic->getId()},this,-1,'topic');"></div>
			<div class="vote-count {if $bVoteInfoShow}js-infobox-vote-topic{/if}" id="vote_total_topic_{$oTopic->getId()}" title="{$aLang.topic_vote_count}: {$oTopic->getCountVote()}">
				{if $bVoteInfoShow}
					{if $oTopic->getRating() > 0}+{/if}{$oTopic->getRating()}
				{else}
					<a href="#" onclick="return ls.vote.vote({$oTopic->getId()},this,0,'topic');">?</a>
				{/if}
			</div>
			{if $bVoteInfoShow}
				<div id="vote-info-topic-{$oTopic->getId()}" style="display: none;">
					+ {$oTopic->getCountVoteUp()}<br/>
					- {$oTopic->getCountVoteDown()}<br/>
					&nbsp; {$oTopic->getCountVoteAbstain()}<br/>
					{hook run='topic_show_vote_stats' topic=$oTopic}
				</div>
			{/if}
		</div>
		{/if}
	</header>