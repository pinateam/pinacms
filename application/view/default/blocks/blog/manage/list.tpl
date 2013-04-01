<table id="blog_sort_ids" class="w100 page-dnd" cellspacing="0">
<col width="60">
<col>
<col width="250">
<col width="150">
<thead>
    <tr>
        <th>{lng lng="act_"}</th>
        <th>
            {lng lng="title"}
        </th>
        <th>
            {lng lng="posts"}
        </th>
        <th>
            {lng lng="status"}
        </th>
    </tr>
</thead>
<tbody>
    {if $blogs}
        {foreach from=$blogs item="blog"}
        <tr class="blog-{$blog.blog_id}" id="{$blog.blog_id}">
            {block view="blog.manage.row"}
        </tr>
        {/foreach}
    {else}
        <tr>
            <td colspan="4">
                <span class="section-icon icon-colors"></span>
                <center>{lng lng="not_found"}</center>
            </td>
        </tr>
    {/if}
</tbody>
</table>

{literal}
<script type="text/javascript">

    $(document).ready(function(){
	$(".splitter-input a").bind("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=blog.manage.status-change&status="+$(this).attr("data-value")+"&blog_id="+splitter.attr("sid");
		$.get(url);
	});
    });

</script>

{/literal}