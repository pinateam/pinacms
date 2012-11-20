{include file="skin/content-header.tpl" title=$blog.blog_title}

{module action="post.list" blog_id=$blog.blog_id page=$page paging=10}