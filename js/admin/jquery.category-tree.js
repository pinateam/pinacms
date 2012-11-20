$.fn.categorySelector = function(options)
{
	$(".category-tree tr td a").live("click", function() {
		$('td.tree.active').removeClass('active');
		$(this).parent('td.tree').addClass('active');

		var category_id = $(this).attr("sid");

		if (options["oncall"]) {
			var fnReload = options["oncall"];
			fnReload(1);
		}
		return false;
	});

	if (!options["js_callback"]) {
		options["js_callback"] = '';
	}

	// Сворачивание / разворачивание узлов дерева категорий
	$("span.category-tree-level").live("click", function(){
		$(this).expandCollapseCategoryTree(options["max_title_length"], options["js_callback"]);
	});

	$(this).expandCollapseCategoryTreeInit(options["max_title_length"], options["js_callback"]);
}

$.fn.expandCollapseCategoryTreeInit = function($max_title_length, $js_callback)
{
	// Разворачивание нужных категорий в каталоге
	if ($('#category-path').get(0)) {
		var $categoryPath = $('#category-path').html();

		if ($categoryPath != '') {
			var $categoryIds = $categoryPath.split('-');

			for ($i = 0; $i < $categoryIds.length - 1; $i++) {
				var $categoryId = $categoryIds[$i];
				var $span = $('.category-' + $categoryId + '-span');

				$span.expandCollapseCategoryTree($max_title_length, $js_callback);
			}
		}
	}
}

$.fn.expandCollapseCategoryTree = function($max_title_length, $js_callback)
{
	var $span = $(this);
	
	if (!$span.hasClass('collapsed') && !$span.hasClass('expanded'))
	{
		return;
	}

	var $tr = $(this).parent().parent();
	var $level = $tr.attr('data-level') - 0;

	if ($(this).hasClass('expanded'))
	{
		$(this).removeClass("expanded").addClass("collapsed");

		$tr.nextAll('tr').each(function(){
			if ($(this).attr('data-level') > $level) {
				$(this).remove();
			}
		});

		return;
	}

	var $category_id = $tr.attr('id').replace('category-', '');
	var $category_type_id = $('#category-type-id').html();
	var $selected_category_id = $('#selected-category-id').html();
	var $language_code = $('#language-code').html();

	$.ajax({
		async: false,
		type: 'post',
		url: 'block.php',
		data: {
			action: 'category.manage.subcategories',
			category_id: $category_id,
			selected_category_id: $selected_category_id,
			category_type_id: $category_type_id,
			language_code: $language_code,
			level: $level + 1,
			max_title_length: $max_title_length,
			js_callback: $js_callback
		},
		success: function(html) {
			$tr.after(html);
			$span.removeClass("collapsed").addClass("expanded");
		},
		dataType: 'html'
	});
}
