<table id="page_sort_ids" class="w100 page-dnd" cellspacing="0">
<col width="60">
<col>
<col width="250">
<thead>
    <tr>
        <th>{lng lng="actions"}</th>
        <th>
            {lng lng="title"}
        </th>
        <th>
            {lng lng="status"}
        </th>
    </tr>
</thead>
<tbody>
	{if $pages}
    {foreach from=$pages item=page}
    <tr class="page-{$page.post_id}" id="{$page.post_id}">
        {block view="page.manage.row" page=$page}
    </tr>
    {/foreach}
	{else}
	<tr>
		<td colspan="3">
                    <center>{lng lng="not_found"}</center>
		</td>
	</tr>
	{/if}
    <tr class="button-bar">
        <td colspan="3">
            <button class="css3 page_add" type="reset">{lng lng="add_static_page"}</button>
        </td>
    </tr>
</tbody>
</table>

{literal}
<script type="text/javascript">

    $(document).ready(function(){
        $(".page_add").bind("click", function(){
            location.href = 'page.php?action=page.manage.add';
        });
    });

    $(document).ready(function() {
	$(".splitter-input a").bind("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=page.manage.status-change&status="+$(this).attr("data-value")+"&page_id="+splitter.attr("sid");
		$.get(url);
	});
    });

</script>

{/literal}