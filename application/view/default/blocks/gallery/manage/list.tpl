<table class="w100" cellspacing="0">
<col width="20">
<col width="150">
<col width="250">
<col width="250">
<col width="150">
<thead>
    <tr>
        <th>{lng lng="act_"}</th>
	<th>{lng lng="image"}</th>
	<th>{lng lng="post"}</th>
        <th>VK</th>
	<th>{lng lng="status"}</th>
    </tr>
</thead>
<tbody>
    {foreach from=$photos item=p}
    <tr class="photo-{$p.photo_id}" id="{$p.photo_id}">
        {block view="gallery.manage.row" photo=$p}
    </tr>
    {foreachelse}
    <tr>
	<td colspan="5">
		<center>{lng lng="list_is_empty"}</center>
	</td>
    </tr>
    {/foreach}
</tbody>
</table>