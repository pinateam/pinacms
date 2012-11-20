{include file="skin/admin/paging.tpl"}

<table id="post_sort_ids" class="w100 page-dnd" cellspacing="0">
    <col width="60">
    <col>
    <col width="160">
    <col width="160">
    <thead>
        <tr>
            <th>{lng lng="act_"}</th>
            <th>
		{include file="skin/admin/table-header-sort.tpl" value="title" title="title"|lng}
            </th>
            <th>
                {include file="skin/admin/table-header-sort.tpl" value="created" title="date"|lng}
            </th>
            <th>
                {include file="skin/admin/table-header-sort.tpl" value="enabled" title="status"|lng}
            </th>
        </tr>
    </thead>
    <tbody>
        {if $posts}
            {foreach from=$posts item="post"}
            <tr class="post-{$post.post_id}" id="{$post.post_id}">
                {block view="post.manage.row"}
            </tr>
            {/foreach}
        {else}
            <tr>
                <td colspan="4">
                    <center>{lng lng="not_found"}</center>
                </td>
            </tr>
        {/if}
        <tr class="button-bar">
            <td colspan="4">
                <button class="css3 post_add" type="reset">{lng lng="add_post"}</button>
            </td>
        </tr>
    </tbody>
</table>
{include file="skin/admin/paging.tpl"}

{literal}
<script type="text/javascript">

    $(document).ready(function(){
        $(".post_add").bind("click", function(){
            var blogId = $(".splitter-input-blog_id").val();
            var url = 'page.php?action=post.manage.add&blog_id='+blogId;
            if(blogId == 0) url = 'page.php?action=page.manage.add';
            location.href = url
        });

	$(".status a").bind("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=post.manage.status-change&status="+$(this).attr("data-value")+"&post_id="+splitter.attr("sid");
		$.get(url);
	});
    });

</script>

{/literal}