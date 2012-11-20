
{foreach from=$blogs item="blog"}
 
   <p><a href="{link action="blog.view" blog_id=$blog.blog_id}">{$blog.blog_title}</a></p>

{/foreach}