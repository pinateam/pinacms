<table id="blog_sort_ids" class="w100 page-dnd" cellspacing="0">
<col width="60">
<col>
<col width="250">
<col width="250">
<thead>
    <tr>
        <th>{lng lng="actions"}</th>
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
        <tr class="blog-{$blog.blog_id}" id="{$page.post_id}">
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
    <tr class="button-bar">
        <td colspan="4">
            <button class="css3 blog_add" type="reset">{lng lng="add_blog"}</button>
        </td>
    </tr>
</tbody>
</table>

{literal}
<script type="text/javascript">

    $(document).ready(function(){
        $(".blog_add").bind("click", function(){
            location.href = 'page.php?action=blog.manage.add';
        });

	$(".splitter-input a").bind("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=blog.manage.status-change&status="+$(this).attr("data-value")+"&blog_id="+splitter.attr("sid");
		$.get(url);
	});
    });

</script>

{/literal}