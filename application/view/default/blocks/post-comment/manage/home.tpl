{block view="post-comment.manage.search-form" wrapper="post-comment-search-form"}

{module action="post-comment.manage.search" wrapper="post-comment-search"}

{literal}
<script type="text/javascript">
	
	$(".last-week").lastWeek("#date-start", "#date-end");
	$(".last-month").lastMonth("#date-start", "#date-end");
	$(".dont-matter").lastAll("#date-start", "#date-end");

	$(".post-comment-search").manageTable({
		action_list: "post-comment.manage.search",
		api_delete:"post-comment.manage.delete",
		wrapper_form: ".post-comment-search-form",
		object: "post_comment"
	});

</script>
{/literal}

{literal}
<script language="JavaScript">
$(document).ready(function() {
	$(".splitter-post-comment-status a").live("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=post-comment.manage.change-status&status="+$(this).attr("data-value")+"&comment_id="+splitter.attr("sid");
		$.get(url);
	});
});
</script>
{/literal}
