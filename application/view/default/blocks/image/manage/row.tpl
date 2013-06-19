<tr class="image-row {if $image.image_id} image-{$image.image_id}{/if}">
	<td class="image-exists{if not $image.image_filename} hidden{/if}">
		{if $few}
		<input type="hidden"
			name="image_id{if $postfix}_{$postfix}{/if}{if $few}_{$image.image_id}{/if}"
			value="{$image.image_id}"
		/>
		{/if}
		<ul class="operation-toolbar">
			<li><a href="javascript:void(0);" sid="{$image.image_id}" class="icon-delete" title="{lng lng="delete"}"></a></li>
		</ul>
	</td>
	<td>
		<div class="image-selector image-exists{if not $image.image_filename} hidden{/if}">
			<div class="image">
				<img src="{img img=$image.image_filename}" width="155" alt="" />
			</div>
		</div>
	</td>
</tr>
<tr class="image-row image-alt {if $image.image_id}image-{$image.image_id}{/if}">
	<td><label class="sub" for="image-alt">ALT:</label></td>
	<td>
		<input type="text" 
			name="image_alt{if $postfix}_{$postfix}{/if}{if $few}_{$image.image_id}{/if}"
			value="{$image.image_alt|htmlall}"
			maxlength="100"
		/>
	</td>
</tr>