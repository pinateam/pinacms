<form action="api.php" method="POST" class="string-search-form">
	<input type="hidden" name="action" value="language.manage.search" />
	<ul class="clearfix" >

		<li class="w50 wide-label">
			<label for="lang">{lng lng="language"}:</label>
			<span class="full-row">
				<select name="language_code" id="language_code">
				{foreach from=$languages key=key item=value}
					<option value="{$key}" {if $search_rules.language_code eq $key}selected="selected"{/if}>{$value}</option>
				{/foreach}
				</select>
			</span>
		</li>

		<li class="w50 normal-label">
			<label for="mnemonic">{lng lng="mnemonics"}:</label>
			<span class="full-row">
				<input type="text" name="key" id="key" value="{$search_rules.key}" />
			</span>
		</li>

		<li class="w50 wide-label">
			<label for="base-lang">{lng lng="base_language"}:</label>
			<span class="full-row">
				<select name="base_language_code" id="base-lang">
				{foreach from=$languages key=key item=value}
					<option value="{$key}" {if $search_rules.base_language_code eq $key}selected="selected"{/if}>{$value}</option>
				{/foreach}
				</select>
			</span>
		</li>


		<li class="w50 normal-label">
			<label for="source-text">{lng lng="base_text"}:</label>
			<span class="full-row">
				<input type="text" name="base_value" id="base_value" value="{$search_rules.base_value}" />
			</span>
		</li>

		<li class="w50 wide-label">
			<label for="status">{lng lng="translation_status"}:</label>
			<span>
				{include file="skin/admin/splitter-input.tpl" name="status" value=$search_rules.status items=$string_status_filter}
			</span>
		</li>

		<li class="w50 normal-label">
			<label for="translation">{lng lng="translation_text"}:</label>
			<span class="full-row">
				<input type="text" name="value" id="value" value="{$search_rules.value}" />
			</span>
		</li>

	</ul>
</form>

{literal}
<script type="text/javascript">
<!--

function string_search(page)
{
	$('.string-manage-search-wrapper').fadeTo(0, 0.5);
	var rules = $(".string-search-form").getData();

	var sort = $("#string-list").getSort();
	var sort_up = $("#string-list").getSortUp(sort);

	$.ajax({
		async: false,
		type: 'post',
		url: 'block.php',
		data: {
			"action": "string.manage.search",
			"rules": rules,
			"page": page,
			"sort": sort,
			"sort_up": sort_up
		},
		success: function(html) {
			$('.string-manage-search-wrapper').html(html);
			$('.string-manage-search-wrapper').fadeTo(0, 1);
		},
		dataType: 'html'
	});
}

$(".string-search-form").find("input, select").change(function() {
	string_search(0);
});

-->
</script>
{/literal}