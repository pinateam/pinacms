<li class="w10">
    <ul class="operation-toolbar">
        <li><a href="javascript:void(0);" class="icon-edit" sid="{$slide.slide_id}" title="{lng lng="edit"}"></a></li>
        <li><a href="javascript:void(0);" class="icon-delete"  sid="{$slide.slide_id}" title="{lng lng="delete"}"></a></li>
    </ul>
</li>
{strip}
<li class="w20">
	<a href="{link action="slide.manage.edit" slide_id=$slide.slide_id}">
		{module action="image.manage.image" image_id=$slide.image_id width="150"}
	</a>
</li>
{/strip}
<li class="w50 editable">
	{$slide.slide_href}
</li>
<li class="w20">
	{include file="skin/admin/splitter.tpl" sid="" name="slide_enabled" class="glow slide-enabled" sid=$slide.slide_id  value=$slide.slide_enabled items=$slide_statuses}
</li>