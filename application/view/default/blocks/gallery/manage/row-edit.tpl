<td>
	<ul class="operation-toolbar">
		<li><a href="#" class="icon-accept" sid="{$photo.photo_id}" title="{lng lng="save"}"></a></li>
		<li><a href="#" class="icon-decline" sid="{$photo.photo_id}" title="{lng lng="cancel"}"></a></li>
	</ul>
</td>
<td>
	<img src="{img img=$photo.photo_filename type="photo" width="155"}" />
</td>
<td>
	{$photo.post_title}
</td>
<td>
	<input type="text" name="vk_url" value="{$photo.vk_url}" />
</td>
<td>
	{include file="skin/admin/splitter.tpl" name="photo_enabled" class="glow photo-enabled" sid=$photo.photo_id  value=$photo.photo_enabled items=$photo_statuses}
</td>