{foreach from=$pages item=page}
	<li><a class="{iflocation action="page.manage.edit" page_id=$page.post_id}active{/iflocation}" href="{link action="page.manage.edit" page_id=$page.post_id}">{$page.post_title}</a></li>
{/foreach}