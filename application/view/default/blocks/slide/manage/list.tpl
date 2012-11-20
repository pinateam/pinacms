<table id="slide_sort_ids" class="w100 slide-dnd" cellspacing="0">
<col width="5">
<col width="20">
<col>
<col width="250">
<col width="250">
<col width="150">
<thead>
    <tr>
        <th colspan="2">{lng lng="act_"}</th>
	<th>{lng lng="image"}</th>
	<th>ALT</th>
        <th>{lng lng="link"}</th>
	<th>{lng lng="status"}</th>
    </tr>
</thead>
<tbody>
    {foreach from=$slides item=s}
    <tr class="slide-{$s.slide_id}" id="{$s.slide_id}">
        {block view="slide.manage.row" slide=$s}
    </tr>
    {foreachelse}
    <tr class="slide-{$s.slide_id}" id="{$s.slide_id}">
	<td colspan="5">
		<center>{lng lng="list_is_empty"}</center>
	</td>
    </tr>
    {/foreach}
    <tr class="button-bar">
        <td colspan="6">
            <button class="css3 button-row-add" onClick="location.href = '{link action="slide.manage.add"}'; return false;">{lng lng="add"}</button>
        </td>
    </tr>
</tbody>
</table>

{literal}
<script language="JavaScript">
//$(document).ready(function() {
	$(".slide-enabled a").bind("click", function() {
		var splitter = $(this).parent().parent();
		var url = "api.php?action=slide.manage.change-status&status="+$(this).attr("data-value")+"&slide_id="+splitter.attr("sid");
		$.get(url);
	});
//});
</script>
{/literal}