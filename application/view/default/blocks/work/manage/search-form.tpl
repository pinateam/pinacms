{if $group_statuses}
<section class="filters css3" id="review-search-form">
<form action="page.php" method="get">
<input type="hidden" name="action" value="work.manage.list" />

<ul class="clearfix">
    

<li class="w33">
	<label for="event_enabled">{lng lng="status"}:</label> 
	<span>

	{include file="skin/admin/splitter-input.tpl" name="work_group_id" class="work-group-id"  value=$group_value items=$group_statuses}
	</span>
</li>
</ul>
</form>
</section>
{/if}