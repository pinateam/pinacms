{if $images}
	<div class="image-list">
	{foreach from=$images item=image name=images}
		<div id="{$image.image_id}" class="image-selector image-exists{if not $image.image_filename} hidden{/if}">
			<div class="image">
				<img src="{img img=$image.image_filename width="155" height="90"}" width="155" height="90" alt="{$image.image_alt|htmlall}" title="{$image.image_alt|htmlall}" />
				{$image.image_width}x{$image.image_height}
			</div>
		</div>
	{/foreach}
	</div>
	{include file="skin/admin/paging.tpl"}	

{else}
	<center>{lng lng="not_found"}</center>
{/if}
