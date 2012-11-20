<h1><span class="section-icon icon-book"></span>{lng lng="post_management"}</h1>

<div class="right-narrow-column post-search-form">
	{module action="blog.manage.filter" blog_id=$search_rules.blog_id filter_all=true}

	<fieldset class="operations">
		<h2>{lng lng="actions"}</h2>
		<ul>
			<li><a href="{link action="post.manage.add" blog_id=$search_rules.blog_id}" class="add">{lng lng="add_post"}</a></li>
		</ul>
	</fieldset>
</div>

<div class="left-wide-column">
	<section class="filters css3">
	    {module action="post.manage.search-form" wrapper="post-search-form"}
	</section>

	{module action="post.manage.list" rules=$search_rules wrapper="post-list"}
</div>

{literal}
<script type="text/javascript">

$(".post-list").manageTable({
	action_list: "post.manage.list",
	action_view: "post.manage.row",
	action_edit: "post.manage.row-edit",
	api_delete: "post.manage.delete",
	api_edit: "post.manage.edit-row",
	wrapper_form: ".post-search-form",
	object: "post"
});


$(".post-search-form ul.filter a").bind("click", function(){
	var href = '';//$(".operations .add").attr("href");
	var blog_id = $(this).attr("data-value");
	if (blog_id != 0)
	{
		href = "page.php?action=post.manage.add&blog_id=" + blog_id;
	}
	else
	{
		href = "page.php?action=page.manage.add";
	}
	$(".operations .add").attr("href", href);
});

</script>
{/literal}