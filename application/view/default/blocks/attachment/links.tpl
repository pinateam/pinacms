{if $title}{include file="skin/content-subheader" title=$title}{/if}
<p>
{foreach from=$attachments item=attachment}
    <a href="{$attachment.attachment_url}">{$attachment.attachment_title}</a><br />
{/foreach}
</p>