<td class="draggable">
<ul class="operation-toolbar">
	<li><a href="javascript:void(0);" class="icon-move" title="{lng lng="move"}"></a></li>
</ul>
</td>
<td>
    <ul class="operation-toolbar">
        <li><a href="javascript:void(0);" class="icon-edit" sid="{$slide.slide_id}" title="{lng lng="edit"}"></a></li>
        <li><a href="javascript:void(0);" class="icon-delete"  sid="{$slide.slide_id}" title="{lng lng="delete"}"></a></li>
    </ul>
</td>
<td>
	<a href="{link action="slide.manage.edit" slide_id=$slide.slide_id}"><img src="{img img=$slide.slide_filename type="slide" width="155"}" /></a>
</td>
<td>
	{$slide.slide_alt}
</td>
<td>
	{$slide.slide_href}
</td>
<td>
	{include file="skin/admin/splitter.tpl" sid="" name="slide_enabled" class="glow slide-enabled" sid=$slide.slide_id  value=$slide.slide_enabled items=$slide_statuses}
</td>