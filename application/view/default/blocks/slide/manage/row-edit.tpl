<td class="draggable">
<ul class="operation-toolbar">
	<li><a href="javascript:void(0);" class="icon-move" title="{lng lng="move"}"></a></li>
</ul>
</td>
<td>
    <ul class="operation-toolbar">
        <li><a href="javascript:void(0);" class="icon-accept"  sid="{$slide.slide_id}" title="{lng lng="apply"}"></a></li>
        <li><a href="javascript:void(0);" class="icon-decline" sid="{$slide.slide_id}" title="{lng lng="cancel"}"></a></li>
    </ul>
</td>
<td>
	<img src="{img img=$slide.slide_filename type="slide" width="155"}" />
</td>
<td>
	<input name="slide_alt" type="text" value="{$slide.slide_alt}" />
</td>
<td>
	<input name="slide_href" type="text" value="{$slide.slide_href}" />
</td>
<td>
	{include file="skin/admin/splitter.tpl" sid="" name="slide_enabled" class="glow slide-enabled" sid=$slide.slide_id  value=$slide.slide_enabled items=$slide_statuses}
</td>