{if $work_groups}
	{foreach from=$work_groups item=work_group}
		<li><a href="{link action="work-group.view" work_group_id=$work_group.work_group_id}">{$work_group.work_group_title}</a></li>
	{/foreach}
{else}
	<li><a href="{link action="work.home"}">{lng lng="portfolio"}</a></li>
{/if}