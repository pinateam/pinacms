<h1>{lng lng="portfolio"}</h1>
{foreach from=$work_groups item=work_group name=work_group}
<div>
	{module action="image.image" image_id=$work_group.image_id class="alignleft"}
	<a href="{link action="work-group.view" work_group_id=$work_group.work_group_id}">{$work_group.work_group_title}</a>
	<hr />
</div>
{/foreach}