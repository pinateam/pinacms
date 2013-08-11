{include file="skin/content-header.tpl" title=$post.post_title}

{$post.post_text|format_description}

{module action="attachment.links" subject="post" post_id=$post.post_id}