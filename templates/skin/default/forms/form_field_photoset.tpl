{if $oField}
	<div class="topic-photo-upload">
		<h2>{$aLang.topic_photoset_upload_title}</h2>

		<div class="topic-photo-upload-rules">
			{$aLang.topic_photoset_upload_rules|ls_lang:"SIZE%%`$oConfig->get('module.topic.photoset.photo_max_size')`":"COUNT%%`$oConfig->get('module.topic.photoset.count_photos_max')`"}
		</div>

		<input type="hidden" name="topic_main_photo" id="topic_main_photo" value="{$_aRequest.topic_main_photo}" />

		<ul id="swfu_images">
			{if count($aPhotos)}
				{foreach from=$aPhotos item=oPhoto}
					{if $_aRequest.topic_main_photo && $_aRequest.topic_main_photo == $oPhoto->getId()}
						{assign var=bIsMainPhoto value=true}
					{/if}

					<li id="photo_{$oPhoto->getId()}" {if $bIsMainPhoto}class="marked-as-preview"{/if}>
						<img src="{$oPhoto->getWebPath('100crop')}" alt="image" />
						<textarea onBlur="ls.photoset.setPreviewDescription({$oPhoto->getId()}, this.value)">{$oPhoto->getDescription()}</textarea><br />
						<a href="javascript:ls.photoset.deletePhoto({$oPhoto->getId()})" class="image-delete">{$aLang.topic_photoset_photo_delete}</a>
						<span id="photo_preview_state_{$oPhoto->getId()}" class="photo-preview-state">
							{if $bIsMainPhoto}
								{$aLang.topic_photoset_is_preview}
							{else}
								<a href="javascript:ls.photoset.setPreview({$oPhoto->getId()})" class="mark-as-preview">{$aLang.topic_photoset_mark_as_preview}</a>
							{/if}
						</span>
					</li>

					{assign var=bIsMainPhoto value=false}
				{/foreach}
			{/if}
		</ul>

		<a href="javascript:ls.photoset.showForm()" id="photoset-start-upload">{$aLang.topic_photoset_upload_choose}</a>
	</div>
{/if}