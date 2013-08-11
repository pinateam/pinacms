{if $attachments}
	<p>
	{foreach from=$attachments item=attachment}
		<a href="{$smarty.const.SITE_ATTACHMENTS}{$attachment.attachment_filename}" target="_blank">{$attachment.attachment_title|default:$attachment.attachment_filename}</a> ({$attachment.attachment_filesize} Kb)
		<br />
	{/foreach}
	</p>
{/if}