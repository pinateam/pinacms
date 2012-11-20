<tr>
    {params var="sort_params" action="post-comment.manage.list" comment_date_start=$comment_date_start|urlencode comment_date_end=$comment_date_end|urlencode post_id=$post_id|urlencode accessibility=$accessibility|urlencode}
    <th>
	{include file="skin/admin/table-header-sort.tpl" value="comment_id" title="ID"}
    </th>
    <th>
	{lng lng="act_"}
    </th>
    <th>
	{lng lng="name"}
    </th>
    <th>
	{include file="skin/admin/table-header-sort.tpl" value="visitor_email" title="E-Mail"}
    </th>
    <th>
	{include file="skin/admin/table-header-sort.tpl" value="post_title" title="page_title"|lng}
	 / 
	{include file="skin/admin/table-header-sort.tpl" value="comment_message" title="text"|lng}
    </th>
    <th>
	{include file="skin/admin/table-header-sort.tpl" value="comment_created" title="date"|lng}
    </th>
    <th>
	{include file="skin/admin/table-header-sort.tpl" value="comment_updated" title="update_date"|lng}
    </th>
    <th>
	{include file="skin/admin/table-header-sort.tpl" value="comment_approved" title="approved"|lng}
    </th>
  
</tr>
