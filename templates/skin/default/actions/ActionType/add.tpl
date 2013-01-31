{if $aParams.0=='add'}
	{if $oConfig->GetValue('view.skin')=='social' || $oConfig->GetValue('view.skin')=='developer'}
		{include file='header.tpl' menu='create'}
	{else}
		{include file='header.tpl' menu_content='create'}
	{/if}
{elseif $aParams.0=='edit'}
	{include file='header.tpl'}
	<h2 class="page-header">{$aLang.plugin.topiccck.topic_edit}</h2>
{/if}


{include file='editor.tpl'}

{if $oType->isPhotosetEnable()}
<script type="text/javascript">
	jQuery(function($){
		if (jQuery.browser.flash) {
			ls.photoset.initSwfUpload({
				post_params: { 'topic_id': {json var=$_aRequest.topic_id} }
			});
		}
	});
</script>


<form id="photoset-upload-form" method="POST" enctype="multipart/form-data" onsubmit="return false;" class="modal modal-image-upload">
	<header class="modal-header">
		<h3>{$aLang.uploadimg}</h3>
		<a href="#" class="close jqmClose"></a>
	</header>
	
	<div id="topic-photo-upload-input" class="topic-photo-upload-input modal-content">
		<label for="photoset-upload-file">{$aLang.topic_photoset_choose_image}:</label>
		<input type="file" id="photoset-upload-file" name="Filedata" /><br><br>

		<button type="submit" class="button button-primary" onclick="ls.photoset.upload();">{$aLang.topic_photoset_upload_choose}</button>
		<button type="submit" class="button" onclick="ls.photoset.closeForm();">{$aLang.topic_photoset_upload_close}</button>
		
		<input type="hidden" name="is_iframe" value="true" />
		<input type="hidden" name="topic_id" value="{$_aRequest.topic_id}" />
	</div>
</form>
{/if}

{hook run='add_topic_type_begin'}


<form action="" method="POST" enctype="multipart/form-data" id="form-topic-add" class="wrapper-content">
	{hook run='form_add_topic_photoset_begin'}
	
	
	<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 
	
	
	<p><label for="blog_id">{$aLang.topic_create_blog}</label>
	<select name="blog_id" id="blog_id" onChange="ls.blog.loadInfo(jQuery(this).val());" class="input-width-full">
		<option value="0">{$aLang.topic_create_blog_personal}</option>
		{foreach from=$aBlogsAllow item=oBlog}
			<option value="{$oBlog->getId()}" {if $_aRequest.blog_id==$oBlog->getId()}selected{/if}>{$oBlog->getTitle()|escape:'html'}</option>
		{/foreach}     					
	</select>
	<small class="note">{$aLang.topic_create_blog_notice}</small></p>
	
	
	<script type="text/javascript">
		jQuery(document).ready(function($){
			ls.blog.loadInfo($('#blog_id').val());
		});
	</script>
	
	
	<p><label for="topic_title">{$aLang.topic_create_title}:</label>
	<input type="text" id="topic_title" name="topic_title" value="{$_aRequest.topic_title}" class="input-text input-width-full" /><br />
	<small class="note">{$aLang.topic_create_title_notice}</small></p>

	
	<p><label for="topic_text">{$aLang.topic_create_text}:</label>
	<textarea name="topic_text" class="mce-editor markitup-editor input-width-full" id="topic_text" rows="20">{$_aRequest.topic_text}</textarea>
	{if !$oConfig->GetValue('view.tinymce')}
		{include file='tags_help.tpl' sTagsTargetId="topic_text"}
	{/if}
	</p>
	  
	<p><label for="topic_tags">{$aLang.topic_create_tags}:</label>
	<input type="text" id="topic_tags" name="topic_tags" value="{$_aRequest.topic_tags}" class="input-text input-width-full autocomplete-tags-sep" /><br />
	<small class="note">{$aLang.topic_create_tags_notice}</small></p>

	
	<p><label for="topic_forbid_comment">
	<input type="checkbox" id="topic_forbid_comment" name="topic_forbid_comment" class="input-checkbox" value="1" {if $_aRequest.topic_forbid_comment==1}checked{/if} />
	{$aLang.topic_create_forbid_comment}</label>
	<small class="note">{$aLang.topic_create_forbid_comment_notice}</small></p>

	
	{if $oUserCurrent->isAdministrator()}
		<p><label for="topic_publish_index">
		<input type="checkbox" id="topic_publish_index" name="topic_publish_index" class="input-checkbox" value="1" {if $_aRequest.topic_publish_index==1}checked{/if} />
		{$aLang.topic_create_publish_index}</label>
		<small class="note">{$aLang.topic_create_publish_index_notice}</small></p>
	{/if}

	<input type="hidden" name="topic_type" value="{$sEvent}" />
	
	{hook run='form_add_topic_topic_end'}
			
			
	<button type="submit"  name="submit_topic_publish" id="submit_topic_publish" class="button button-primary fl-r">{$aLang.topic_create_submit_publish}</button>
	<button type="submit"  name="submit_preview" onclick="jQuery('#text_preview').parent().show(); ls.topic.preview('form-topic-add','text_preview'); return false;" class="button">{$aLang.topic_create_submit_preview}</button>
	<button type="submit"  name="submit_topic_save" id="submit_topic_save" class="button">{$aLang.topic_create_submit_save}</button>
</form>

<div class="topic-preview" id="text_preview"></div>
	
{hook run='add_topic_type_end'}



{include file='footer.tpl'}