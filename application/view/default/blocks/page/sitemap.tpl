
{foreach from=$posts item="post"}
 
  <p><a href="{link action="page.view" page_id=$post.post_id}">{*{$category.category_parent_id} =*} {$post.post_title}</a></p>

{/foreach}
