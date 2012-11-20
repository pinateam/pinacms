<td>
    <ul class="operation-toolbar">
        <li><a href="javascript:void(0);" class="icon-edit" sid="{$photo.photo_id}" title="{lng lng="edit"}"></a></li>
        <li><a href="javascript:void(0);" class="icon-delete"  sid="{$photo.photo_id}" title="{lng lng="delete"}"></a></li>
    </ul>
</td>
<td>
	<img src="{img img=$photo.photo_filename type="photo" width="155"}" />
</td>
<td>
	{$photo.post_title}
</td>
<td>
	{$photo.vk_url}
</td>
<td>
	{include file="skin/admin/splitter.tpl" name="photo_enabled" class="glow photo-enabled" sid=$photo.photo_id  value=$photo.photo_enabled items=$photo_statuses}
</td>