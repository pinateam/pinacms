{include file="skin/admin/paging.tpl"}

<table class="w100" cellspacing="0">
	<col width="40">
	<col width="30">
	<col width="30">
	<col width="80">
	<col>
	<col width="140">
	<col width="140">
	<col width="140">


	<thead>
	    {block view="post-comment.manage.search-head"}		
	</thead>
	
	<tbody>
		{foreach from=$comments item=comment}
		<tr>
			<td>
			   {$comment.comment_id}
			</td>
			<td>
			    <ul class="operation-toolbar">
				<li><a href="#" class="icon-delete" sid="{$comment.comment_id}" title="Удалить"></a></li>
			    </ul>
			</td>
			<td>
			   {$comment.visitor_name}
			</td>
			<td>
			   {$comment.visitor_email}
			</td>
			<td>
			   <a href="{link action="post.view" post_id=$comment.post_id}">{$comment.post_title}</a> / {$comment.comment_message} 
			</td>
			<td>
			   {$comment.comment_created|date_format:"%d.%m.%Y %H:%I:%S"}
			</td>
			<td>
			   {if $comment.comment_updated ne "0000-00-00 00:00:00"}
			     {$comment.comment_updated|date_format:"%d.%m.%Y %H:%I:%S"}
			   {/if}
			</td>
			
			<td>		
			    {include file="skin/admin/splitter.tpl" name="status" class="splitter-post-comment-status" sid=$comment.comment_id value=$comment.comment_approved items=$post_comment_statuses}
			</td>
			
		</tr>
		{foreachelse}
			<tr>
				<td colspan="8"><center>{lng lng="list_is_empty"}</center></td>
			</tr>
		{/foreach}
		
	</tbody>
</table>

