<h1><span class="section-icon icon-bubble"></span>{lng lng="comments"} </h1>

<section class="filters css3" id="review-search-form">
<form action="page.php" method="get">
<input type="hidden" name="action" value="post-comment.manage.search" />

<ul class="clearfix">
    
<li class="w66">
	<label for="date-start">{lng lng="date"}:</label> 
	<span>
		<input type="text" class="date" id="date-start" name="comment_date_start" value="" />
		&divide;
		<input type="text" class="date" id="date-end" name="comment_date_end" value="" />

		<a href="#" class="last-week">{lng lng="for_last_week"}</a>
		<a href="#" class="last-month">{lng lng="for_last_month"}</a>
		<a href="#" class="dont-matter">{lng lng="filter_all"}</a>
	</span>
</li>

<li class="w33">
	<label for="comment_approved">{lng lng="approved"}:</label>
	<span>
		{include file="skin/admin/splitter-input.tpl" name="comment_approved" class="splitter-post-comment-approved" value="N" items=$post_comment_statuses}	
	</span>
</li>
</ul>
</form>
</section>