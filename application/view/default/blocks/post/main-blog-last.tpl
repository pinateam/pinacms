<h4 class="widget-title">{$post.post_title}</h4>

{$post.post_text|format_description}

<p>{$post.post_created|format_date}</p>

<p><a href="{link action="post.list" blog_id=$blog.blog_id}">{$blog.blog_title}</a></p>