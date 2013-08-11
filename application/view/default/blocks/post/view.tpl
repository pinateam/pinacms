{include file="skin/content-header.tpl" title=$post.post_title}

{$post.post_text|format_description|format_photos:$post.post_id}

{module action="attachment.links" subject="post" post_id=$post.post_id}

{$post.post_created|format_datetime}

{block view="post-comment.post-view" post_id=$post.post_id}
{literal}
<script type="text/javascript">

$(document).ready(function(){
	$(".review").live("click", function(){
		var id = $(this).attr('id');
		var message = $("#comment-"+id+" .author").attr("data-value") + ",";

		if(!($("#comment_message").text()))
		{
			$("#comment_message").text(message);
			$("#answer_comment_id").val(id);
		}
	});
});
	
</script>
{/literal}