$.fn.getData = function()
{
        var options = {};
	var elem = this;

        elem.find('select').each(function() {
            options[this.name] = elem.find('select[name='+this.name+']').val();
        });

        elem.find('select').each(function() {
            options[this.name] = elem.find('select[name='+this.name+']').val();
        });

        elem.find('input').each(function() {
            options[this.name] = elem.find('input[name='+this.name+']').val();
        });

        return options;
}

$.fn.reloadTable = function(action, page, data)
{
	var elem = this;
	$(elem).fadeTo(0, 0.5);

	data['action'] = action;
	data['page'] = page;

	var sort = $(elem).getSort();
	if (sort)
	{
		data['sort'] = sort;
		data['sort_up'] = $(this).getSortUp(sort);
	}

	$.ajax({
		async: false,
		type: 'post',
		url: 'block.php',
		data: data,
		success: function(html) {
			$(elem).html(html);
			$(elem).fadeTo(0, 1);
			$(elem).trigger("table_reloaded");
		},
		error: function() {
			alert('error');
		},
		dataType: 'html'
	});
}

$.fn.manageTable = function(options)
{
	var elem = this;
	var object_id = options["object"] + "_id";
	var object_selector = "." + options["object"] + "-";

	if (options["action_list"] && !options["oncall"])
	{
		options["oncall"] = function(page)
		{
			var extra = {};
			if (options["oncall_extra"])
			{
				var fnExtra = options["oncall_extra"];
				extra = fnExtra();
			}
			if (options["wrapper_form"])
			{
				extra["rules"] = $(options["wrapper_form"]).getData();
			}
			$(elem).reloadTable(
				options["action_list"], page, extra
			);
		}
	}

	if (options["wrapper_form"])
	{
		$(options["wrapper_form"]).find("input").live("change", function() {
			var fnReload = options["oncall"];
			fnReload(0);
		});
	}

	if (options["action_edit"])
	{
		elem.find(".editable a").live("click", function()
		{
			var link = $(this).attr("href");
			if (!link) return true;
			document.location = link;
			return false;
		});
		elem.find(".icon-edit, .editable").live("click", function()
		{
			var id = $(this).attr("sid");
			if (!id)id = $(this).parent().attr("sid");
			if (!id)id = $(this).parent().attr("id");
			if (!id)alert("Please specify SID");
			var params = {};
			params["action"] = options['action_edit'];
			params[object_id] = id;
			$.ajax({
				async: false,
				type: 'post',
				url: 'block.php',
				data: params,
				success: function(html) {
					$(object_selector+id).html(html);
				},
				dataType: 'html'
			});
			return false;
		});
	}

	if (options["action_view"])
	{
		elem.find(".icon-accept").live("click", function()
		{
			var id = $(this).attr("sid");
			if (id != 'none') {
				if (!id) alert("Please specify SID");
				var params = $(object_selector + id).getData();
				params['action'] = options['api_edit'];
				params[object_id] = id;
				$.ajax({
					async: false,
					type: 'post',
					url: 'api.php',
					data: params,
					success: function(){
						var params = {};
						params['action'] = options['action_view'];
						params[object_id] = id;
						$.ajax({
							async: false,
							type: 'post',
							url: 'block.php',
							data: params,
							success: function(html) {
								$(object_selector+id).html(html);
								elem.trigger("row_changed", [id]);
							},
							dataType: 'html'
						})
					},
					error: function(){
						alert(PinaLng.lng("request_sending_failed"));
					},
					dataType: 'html'
				});
			}
			return false;
		});
	}

	if (options["action_view"])
	{
		elem.find(".icon-decline").live("click", function()
		{
			var id = $(this).attr("sid");
			
			if (id != 'none') {
				if (!id) alert("Please specify SID");
				var params = {};
				params["action"] = options["action_view"];
				params[object_id] = id;
				$.ajax({
					async: false,
					type: 'post',
					url: 'block.php',
					data: params,
					success: function(html) {
						$(object_selector+id).html(html);
					},
					dataType: 'html'
				});
			}
			return false;
		});
	}

	if (options["api_delete"])
	{
		elem.find(".icon-delete").live("click", function()
		{
			if (!$(this).confirmDeleteMessage()) return false;

			var id = $(this).attr("sid");
			if (!id) alert("Please specify SID");
			var params = {};
			params["action"] = options["api_delete"];
			params[object_id] = id;

			$(this).requestDelete(params, options["oncall"]);
			
			elem.trigger("row_deleted");

			return false;
		});
	}

        if (options["api_add"])
	{
		elem.find(".icon-add,.button-add").live("click", function()
		{
                        var id = $(this).attr("sid");
			if (!id) alert("Please specify SID");
			var params = $(object_selector + id).getData();
			params["action"] = options["api_add"];
                        params[object_id] = id;

			var fnReload = options["oncall"];

			$.ajax({
				type: 'post',
				url: 'api.php',
				data: params,
				success: function(packet) {
					if (packet && packet.e) {
						var errors = [];

						for (i = 0; i < packet.e.length; i++)
						{
							if (packet.e[i].s)
							{
								errors.push(packet.e[i].m);
							}
						}

						if (errors.length > 0) {
							alert(errors.join('\n'));
						}
					} else {
						if (fnReload)
						{
							fnReload($(this).getPage());
							elem.trigger("row_added");
						}
					}
				},
				error: function() {
					alert(PinaLng.lng("request_sending_failed"));
				},
				dataType: 'json'
			});
			return false;
		});
	}

	elem.find("tr th a").live("click", function()
	{
		var new_class = "sort-up";
		if ($(this).parent().find("span").hasClass("sort-up"))
		{
			new_class = "sort-down";
		}
		$(this).parent().parent().find("span").removeClass("sort-up sort-down");
		$(this).parent().find("span").addClass(new_class);

		var fnReload = options["oncall"];
		fnReload($(this).getPage());
		return false;
	});

	$(".paginator a").live("click", function()
	{
		var fnReload = options["oncall"];
		fnReload($(this).attr("data-value"));
		return false;
	});

	if (options["api_reorder"])
	{
		$(elem).bind("table_reloaded", function(){
			var sortableItems = elem.find("div.table.dnd div.tbody ul.tr:not(.no-dnd)");
			if (sortableItems.length)
			{
				var settings = {
					columns : 'div.table div.tbody'
					//,
					//handleSelector: 'li'
				}

				sortableItems.find(settings.handleSelector).css({
					cursor: 'move'
				}).mousedown(function (e) {
					sortableItems.css({width:''});
					$(this).parent().css({
						width: $(this).parent().width() + 'px'
					});
				}).mouseup(function () {
					if(!$(this).parent().hasClass('dragging')) {
						$(this).parent().css({width:''});
					} else {
						$(settings.columns).sortable('disable');
					}
				});

				$(settings.columns).sortable({
					items: sortableItems,
					connectWith: $(settings.columns),
					handle: settings.handleSelector,
					placeholder: 'widget-placeholder',
					forcePlaceholderSize: true,
					revert: 300,
					delay: 100,
					opacity: 0.8,
					containment: 'document',
					start: function (e, ui) {
						$(ui.helper).addClass('dragging');
					},
					stop: function (e, ui) {
						$(ui.item).css({width:''}).removeClass('dragging');
						$(settings.columns).sortable('enable');

						var params = {};
						params["action"] = options["api_reorder"];
						var param_object = options["object"] + "_sort_ids";
						params[param_object] = {};
						$(elem).find("ul.tr").each(function(){
							var id = $(this).attr("id");
							params[param_object + "_" + id] = id;
						});

						$(elem).fadeTo(0, 0.5);
						$.ajax({
							type: 'post',
							url: 'api.php',
							data: params,
							dataType: 'text',
							success: function(result) {
								$(elem).fadeTo(0, 1);
							},
							error: function() {
								alert(PinaLng.lng("request_sending_failed"));
								$(elem).fadeTo(0, 1);
							}
						});
					}
				});
			}
		});


		$(document).ready(function(){
			$(elem).trigger('table_reloaded');
		});
	}

}


$.fn.confirmDeleteMessage = function()
{
	var message = $(this).attr("data-message");
	if (!message) message = PinaLng.lng("are_you_sure_to_delete");

	if (!confirm(message)) {
		return false;
	}
	return true;
}

$.fn.requestDelete = function(params, fnReload)
{
	$.ajax({
		type: 'post',
		url: 'api.php',
		data: params,
		success: function(packet) {
			if (packet && packet.e) {
				var errors = []
				for (i = 0; i < packet.e.length; i++)
				{
					errors.push(packet.e[i].m);
				}

				if (errors.length > 0) {
					alert(errors.join('\n'));
				}
			} else {
				if (fnReload)
				{
					fnReload($(this).getPage());
				}
			}
		},
		error: function() {
			alert(PinaLng.lng("request_sending_failed"));
		},
		dataType: 'json'
	});
}

$.fn.getPage = function()
{
	var page = $(".paginator .current").html();
	if (!page) page = 0;
	return page;
}

$.fn.getSort = function()
{
	return $(this).find("tr th span.sort-up, tr th span.sort-down").attr("data-value");
}

$.fn.getSortUp = function(sort)
{
	if ($(this).find("tr th span.sort-up[data-value="+sort+"],tr th span.sort-down[data-value="+sort+"]").hasClass("sort-up"))
	{
		return "1";
	}
	return "0";
}


$.fn.lastWeek = function(selector_start, selector_end)
{
	$(this).live("click", function() {
		var d=new Date();
		var last_day=d.getDate();
		var last_month=d.getMonth()+1;
		var last_year=d.getFullYear();
		var first_day = 0;
		var first_month = 0;
		var first_year = 0;

		first_day = last_day - 6;
		if((first_day == 0) || (first_day < 0))
		{
			first_month = last_month - 1;
			if(first_month == 0)
			{
				first_year = last_year - 1;
				first_month = 12;
			}
			else
			{
				first_year = last_year;
			}

			var dayCount = new Date(last_year, first_month, 0).getDate();
			first_day = dayCount + first_day;
		}
		else
		{
			first_month = last_month;
			first_year = last_year;
		}

		if(first_day < 10)
		{
			first_day = '0' + first_day;
		}
		if(first_month < 10)
		{
			first_month = '0' + first_month;
		}
		if(last_day < 10)
		{
			last_day = '0' + last_day;
		}
		if(last_month < 10)
		{
			last_month = '0' + last_month;
		}
		$(selector_start).val(first_day + "." + first_month + "." + first_year);
		$(selector_end).val(last_day + "." + last_month + "." + last_year);
		$(selector_start).trigger("change");
		return false;
	});
}


$.fn.lastMonth = function(selector_start, selector_end)
{
	$(this).live("click", function() {
		var d=new Date();
		var day=d.getDate();
		var last_month=d.getMonth()+1;
		var last_year=d.getFullYear();
		var first_month = 0;
		var first_year = 0;

		first_month = last_month - 1;
		if(first_month == 0)
		{
			first_year = last_year - 1;
			first_month = 12;
		}
		else
		{
			first_year = last_year;
		}

		if(day < 10)
		{
			day = '0' + day;
		}
		if(first_month < 10)
		{
			first_month = '0' + first_month;
		}
		if(last_month < 10)
		{
			last_month = '0' + last_month;
		}

		$(selector_start).val(day + "." + first_month + "." + first_year);
		$(selector_end).val(day + "." + last_month + "." + last_year);
		$(selector_start).trigger("change");
		return false;
	});
}

$.fn.lastAll = function(selector_start, selector_end)
{
	$(this).live("click", function()
	{
		$(selector_start).val('');
		$(selector_end).val('');
		$(selector_start).trigger("change");
		return false;
	});
}




$.fn.lastDay = function(selector_start, selector_end)
{
	$(this).live("click", function() {
		var d=new Date();
		var day=d.getDate();
		var month=d.getMonth()+1;
		var year=d.getFullYear();

		
		if(day < 10)
		{
			day = '0' + day;
		}
		if(month < 10)
		{
			month = '0' + month;
		}

		$(selector_start).val(day + "." + month + "." + year);
		$(selector_end).val(day + "." + month + "." + year);
		$(selector_start).trigger("change");
		return false;
	});
}