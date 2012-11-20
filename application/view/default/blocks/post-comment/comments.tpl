<h1>{lng lng="comments"}</h1>
   
{if $comments}
{foreach from=$comments item="comment"} 
        <div class="comment" id="comment-{$comment.comment_id}">
		<div class="author" data-value="{$comment.visitor_name}"><a name="comments-{$comment.comment_id}" href="#comments-{$comment.comment_id}"><img src="{$comment.gravatar_url}" alt="" /></a>
			<div>

				{if $comment.visitor_site}
					<a href="{$comment.visitor_site}">
				{/if}

				<span>
				{$comment.visitor_name}
				</span>

				{if $comment.visitor_site}
					</a>
				{/if}  


				{if $comment.answer_comment_id}
					<span>
					(<a href="#comments-{$comment.answer_comment_id}">{lng lng ="answer_for"} {lng lng="comment"} №{$comment.answer_comment_id}</a>)
					</span>
				{/if}

			</div>
	
			{$comment.comment_message|format_description}

			<div class="date">{$comment.comment_created|date_format:"%d.%m.%Y %H:%I:%S"}
				{if $comment.comment_updated ne "0000-00-00 00:00:00" and $comment.comment_updated}
					
					({lng lng="edited_by"}: {$comment.comment_updated|format_date})
				{/if}
			</div>

			 
			<div class="actions">
				<a class="review" id="{$comment.comment_id}" href="javascript:void(0);">{lng lng="answer"}</a>
				{if ($auth_user_id eq $comment.user_id) and $auth_user_id}
					<a href="{link api="post-comment.delete" comment_id=$comment.comment_id}">{lng lng="delete"}</a>
					<a href="{link action="post-comment.edit" comment_id=$comment.comment_id}">{lng lng="edit"}</a>
					<br/>
					<br/>
					
				 {/if}
			</div>
			{if $auth_user_id}
				
				Рейтинг:{$comment.rating}
				<a href="{link api="post-comment.comment_rating" comment_id=$comment.comment_id user_id=$auth_user_id rating=1}">{lng lng="like"}</a>
				<a href="{link api="post-comment.comment_rating" comment_id=$comment.comment_id user_id=$auth_user_id rating=-1}">{lng lng="unlike"}</a>

				{foreach from=$ratings item="rating"} 
					{if $rating.user_id eq $auth_user_id and $rating.comment_id eq $comment.comment_id}
						<a href="{link api="post-comment.delete_comment_rating" rating_id=$rating.rating_id }">{lng lng="reset"}</a>
					{/if}
				{/foreach}
		      {/if}
	        
		</div>
    </div>
{/foreach}
{/if}