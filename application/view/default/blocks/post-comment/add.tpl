<form action="api.php" method="post">
    <input type="hidden" name="action" value="post-comment.add" />
    <input type="hidden" name="post_id" value="{$post_id}" />

    {block view="post-comment.form"}
    <input type="submit" value ="{lng lng="send"}" /> 
    </br>
    </br>
    </br>
    {if $auth_user_id}
				
		Рейтинг:{$totalRating}
		<a href="{link api="post-comment.post_rating" post_id=$post_id user_id=$auth_user_id rating=1}">{lng lng="like"}</a>
		<a href="{link api="post-comment.post_rating" post_id=$post_id user_id=$auth_user_id rating=-1}">{lng lng="unlike"}</a>

		{foreach from=$ratings item="rating"} 
			{if $rating.user_id eq $auth_user_id and $rating.post_id eq $post_id}
				<a href="{link api="post-comment.delete_post_rating" rating_id=$rating.rating_id }">{lng lng="reset"}</a>
			{/if}
		{/foreach}
	{/if}
</form>