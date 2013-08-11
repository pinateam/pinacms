{if $post}
{capture name="content"}

{$post.post_text|strip_images|format_description}

<p>{$post.post_created|format_datetime}</p>

<p><a href="{link action="blog.view" blog_id=$blog.blog_id}">{$blog.blog_title}</a></p>

{/capture}
{include file="skin/sidebar-line.tpl" title=$post.post_title class="news" content=$smarty.capture.content}
{/if}