<tr class="product-attachment product-attachment-{$attachment.attachment_id}{if $isFirst} first{/if}">
	<td>
		<ul class="operation-toolbar">
			<li><a href="javascript:void(0);" class="icon-delete" title="{lng lng="delete"}" onClick="productAttachmentDelete({$attachment.attachment_id});"></a></li>
		</ul>
	</td>
	<td>
		<input type="hidden" name="attachment_id_{$attachment.attachment_id}" value="{$attachment.attachment_id}" />
		<input type="text" name="attachment_title_{$attachment.attachment_id}" class="long-text" value="{$attachment.attachment_title|htmlall}" maxlength="1024"  />
		<br />
		<a href="{$attachment.attachment_url}" target="_blank">{lng lng="download"}</a> ({$attachment.attachment_size} b)
	</td>
</tr>