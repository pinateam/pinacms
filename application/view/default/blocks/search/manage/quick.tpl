<form class="global-search-form" action="api.php" method="POST">
    <strong>{lng lng="search"}:</strong>
    <select name="action" id="action" autofocus>
	{block view="product.manage.search-quick-option"}
	{block view="user.manage.search-quick-option"}
        {block view="order.manage.search-quick-option"}
    </select>

    <span id="search-term-wrapper">
	<input type="text" name="query" class="search-term" id="search-term" value="" placeholder="{lng lng="search_words"}" autocomplete="off">
    </span>
    <button class="transparent search-button" type="submit">
        <img src="{site img="admin/magnifier.png"}" class="small-icon" />
    </button>
</form>

{literal}
<script type="text/javascript">

function setAutocompleteAction(action_title)
{
	//remove old autocomplete handler
	var h = $("#search-term-wrapper").html();
	$("#search-term-wrapper").html('');
	$("#search-term-wrapper").html(h);

	//assign new handler
	$('#search-term').autocomplete('api.php', {
		delay: 10,
		minChars: 1,
		matchSubset: 1,
		autoFill: true,
		maxItemsToShow: 10,
		extraParams: {action: action_title+'-autocomplete'}
	});
}

$("#action").change(function(){
    setAutocompleteAction($('#action').val());
});

$(document).ready(function() {
    setAutocompleteAction($('#action').val());
});
</script>
{/literal}