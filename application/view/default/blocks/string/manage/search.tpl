<form action="api.php" method="POST" onsubmit="javascript: return false;">

	<table id="string-list" class="translation-list w100" cellspacing="0">

		<col width="7%">
		<col width="31%">
		<col width="31%">
		<col width="31%">

		{assign var="lk" value=$search_rules.language_key}
		{assign var="blk" value=$search_rules.base_language_key}

		<thead>
			<tr>
				<th>{lng lng="act_"}</th>
				<th>{include file="skin/admin/table-header-sort.tpl" value="string_key" title="mnemonics"|lng}</th>
				<th>{include file="skin/admin/table-header-sort.tpl" value="string_value_base" title="source_language_text"|lng}</th>
				<th>{include file="skin/admin/table-header-sort.tpl" value="string_value" title="translation_text"|lng}</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$strings item=string}
			<tr {if $string.string_value_base eq "" && $string.string_value}class="no-base-text"
				{elseif $string.string_value eq ""}class="untranslated"
				{/if}>
				{block view="string.manage.row" string=$string}
			</tr>
			{/foreach}
			<tr class="string-add" sid="add">
				<td>
					<input type="hidden" name="language_code" value="{$search_rules.language_code}" />
				</td>
				<td>
					<input type="text" name="string_key" value="" />
				</td>

				<td>
					&nbsp;
				</td>
				<td>
					<input type="text" name="string_value" value="" />
				</td>
			</tr>
			<tr class="button-bar">
				<td colspan="4">

					<button class="css3 button-add" sid="add">{lng lng="add"}</button>

					{* TODO: Появляется после первого редактирования *}
					<button class="css3 edit-few">Сохранить</button>
				</td>
			</tr>
		</tbody>
	</table>

	{include file="skin/admin/paging.tpl"}
</form>