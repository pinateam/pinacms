{if $input}
    {include file="skin/admin/splitter-input.tpl" name="post_enabled" id="post_enabled" items=$statuses value=$status sid=$sid class="status"}
{else}
    {include file="skin/admin/splitter.tpl" name="post_enabled" id="post_enabled" items=$statuses value=$status sid=$sid class="status"}
{/if}