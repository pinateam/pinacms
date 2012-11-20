<form action="api.php" method="post">
    
    <input type="hidden" name="action" value="post-comment.edit" />
    <input type="hidden" name="post_id" value="{$fill.post_id}" />
    <input type="hidden" name="comment_id" value="{$fill.comment_id}" />

    {block view="post-comment.form"}

    <input type="submit" value="{lng lng="send"}" />
</form>


<form action="page.php" method="get">
    <input type="hidden" name="action" value="post.view" />
    <input type="hidden" name="post_id" value="{$fill.post_id}" />
    <input type="submit" value="Назад" />
</form>