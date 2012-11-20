	<!-- Javascript at the bottom for fast page loading -->

	<script src="{$smarty.const.SITE_JS}admin/jquery-ui-1.8.24.custom.min.js"></script>
	<script src="{$smarty.const.SITE_JS}admin/jquery.form.js"></script>
	<script src="{$smarty.const.SITE_JS}admin/jquery.blockUI.js"></script>
        <script src="{$smarty.const.SITE_JS}admin/jquery.autocomplete.js"></script>
        <script src="{$smarty.const.SITE_JS}admin/jquery.simplemodal.js"></script>
        <script src="{$smarty.const.SITE_JS}admin/jquery.dimensions.js"></script>
	
	<script src="{$smarty.const.SITE_LIB}swfupload/swfupload.js"></script>
	<script src="{$smarty.const.SITE_LIB}swfupload/swfupload.queue.js"></script>

	<!--[if lt IE 7 ]>
	<script src="{$smarty.const.SITE_JS}admin/dd_belatedpng.min.js"></script>
	<script>
		//DD_belatedPNG.fix('img');
		//DD_belatedPNG.fix('ul.operation-toolbar a');
		//DD_belatedPNG.fix('span.tree-level a');
		//DD_belatedPNG.fix('aside#left li a');
	</script>
	<![endif]-->

	<script src="{$smarty.const.SITE_JS}admin/jquery.tablednd-0.5.min.js"></script>

	<script src="{$smarty.const.SITE_JS}admin/jquery.jsquared-0.1.min.js"></script>

	<script src="{$smarty.const.SITE_JS}admin/inettuts.js"></script>

	<script language="JavaScript">
{literal}
		function intval(mixed_var, base)
		{ 	// Get the integer value of a variable
			// 
			// +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
			var tmp;

			if (typeof(mixed_var) == 'string')
			{
				tmp = parseInt(mixed_var);
				
				if (isNaN(tmp))
				{
					return 0;
				}
				else
				{
					return tmp.toString(base || 10);
				}
			}
			else if(typeof(mixed_var) == 'number')
			{
				return Math.floor(mixed_var);
			}
			
			return 0;
		}

		function updateTreeLevelIcons($table)
		{
			if (!$($table).hasClass('category-tree')) { // не трогаем дерево категорий - оно обрабатывается по-другому
				$("tr td.tree", $table).each(function () {
					var $this = $(this);

					var parentLevel = $this.parent().data("level");
					var nextLevel = $this.parent().next().data("level");
					if (parentLevel == undefined)
					{
						return;
					}

					$("span.tree-level", $this).remove();
					for (var i = 0; i < parentLevel; i++)
					{
						$span = $("<span class='tree-level'></span>");
						if (i == 0 && parentLevel < nextLevel)
						{
							$span.addClass("expanded");
						}
						$this.prepend($span);
					}
				});
			}
		}

		function slideRowDown($row, duration)
		{
			$row.find('td')
				.wrapInner('<div class="wrapper" style="display: none;" />')
				.parent()
				.show()
				.find('td > div')
				.slideDown(duration, function() {
					var $this = $(this);
					$this.replaceWith($this.contents());
				});
		}

		function slideRowUp($row, duration)
		{
			$row.find('td')
				.wrapInner('<div class="wrapper" style="display: block;" />')
				.parent()
				.find('td > div')
				.slideUp(duration, function(){
					var $this = $(this);
					$this.parent().parent().hide();
					$this.replaceWith($this.contents());
				});
		}

		function expandCollapseNode($node)
		{
			var $tr = $node.parent().parent();
			var parentLevel = $tr.data("level");

			$tr = $tr.next();
			while ($tr.is("tr"))
			{
				var rowLevel = $tr.data("level");
				if (rowLevel == undefined || rowLevel <= parentLevel)
				{
					break;
				}

				if ($node.hasClass("collapsed"))
				{
					slideRowDown($tr, 300);
					//$tr.show();
					$("span.collapsed", $tr)
						.removeClass("collapsed")
						.addClass("expanded");
				}
				if ($node.hasClass("expanded"))
				{
					slideRowUp($tr, 300);
					//$tr.hide();
				}
				$tr = $tr.next();
			}

			$node.toggleClass("collapsed");
			$node.toggleClass("expanded");
		}
		
		function showBlockUI(title, message) {
			$.blockUI({
				theme: true,
				title: title,
				message: message,
				overlayCSS: {
					backgroundColor: '#fff'
				}
			});
		}
		
		function hideBlockUI(callback) {
			$.unblockUI({
				onUnblock: function() {
					if (callback) {
						callback.call();
					}
				}
			});
		}

			// Переключение элементов сплиттера
			$("ul.splitter li a,ul.filter li a").live("click", function () {
				var $splitter = $(this).parent().parent();
				
				if ($("a", $splitter).hasClass('disabled')) {
					alert('Данный элемент не может быть изменен.');
					return false;
				}
				
				$("a", $splitter).removeClass("selected");
				$(this).addClass("selected");
				return false;
			});

			$("ul.splitter-input li a,ul.filter-input li a").live("click", function () {
				var $splitter = $(this).parent().parent();
				$(".splitter-input-" + $splitter.attr("data-name")).val(
					$(this).attr("data-value")
				);
				setTimeout(function() {
					$(".splitter-input-" + $splitter.attr("data-name")).trigger("change");
				}, 10);
			});
		
		$(document).ready(function () {

			//$("ul.splitter li a").addClass("css3");

			// Удаляем старые и добавляем новые [+] / [-] в узлы дерева
			updateTreeLevelIcons($("table.tree"));
			
			// Сворачивание / разворачивание узлов дерева
			$("span.collapsed, span.expanded").live("click", function () {
				if (!$(this).hasClass('category-tree-level')) { // не трогаем дерево категорий - оно обрабатывается по-другому
					expandCollapseNode($(this));
				}
			});

			// Переключатель левого меню
			$(".menu-toggle").click(function() {
				if ($("#wrapper").toggleClass("no-menu").hasClass("no-menu"))
					status = 'hide'; 
				else
					status = 'show';
				$.get("api.php?action=config.manage.save-menu-toggle-status&status="+status);
			});

                        // why?
			//$("#export-catagories-list tr[data-level=1] span.expanded").click();

			$('.add-new-row').hide();

			// Дополнительную форму сохранения прижимаем к низу страницы
			$operationsBottom = $('.operations').filter('.bottom').each(function() {
				$this = $(this);
				var $leftColumn = $("#main .left-wide-column");
				var $rightColumn = $("#main .right-narrow-column");
				var rightBottom = $rightColumn.height();
				var needBottom = Math.max($leftColumn.height(), $rightColumn.height());
				$this.css("padding-top", needBottom - rightBottom);
			});

		});
{/literal}
	</script>