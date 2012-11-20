<fieldset>
	<h2>{lng lng="common_settings"}</h2>

        {module action="post.manage.select-blog" value=$blog_id}

        <div class="field w50">
            <label for="coding">{lng lng="status"}</label>
            {module action="post.manage.status" enabled=$post.post_enabled input=true}
        </div>

	{if false && $post.post_id}
	<div class="field w50">
		 <label align="left">{lng lng="link"}</label>
		<div style="vertical-align: middle">
		<a href="{link action="post.view" post_id=$post.post_id}">{link action="post.view" post_id=$post.post_id}</a>
		</div>
	</div>
	{/if}

	{include file="skin/admin/form-line-input.tpl"
		 name="post_title" value=$post.post_title title="title"|lng
		 width="long-text"}

	{include file="skin/admin/form-line-textarea.tpl"
		 name="post_text" value=$post.post_text title="description"|lng
		 width="html-text" rows="20" help="description_explanation"|lng}
</fieldset>


{literal}
<script type="text/javascript">
    $(".status a").bind("click", function() {
        var splitter = $(this).parent().parent();
        var url = "api.php?action=post.manage.status-change&status="+$(this).attr("data-value")+"&post_id="+splitter.attr("sid");
        $.get(url);
    });
</script>
{/literal}

