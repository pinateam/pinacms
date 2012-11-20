/*
 * Script from NETTUTS.com [by James Padolsey]
 * @requires jQuery($), jQuery UI & sortable/draggable UI modules
 */

var iNettuts = {

	jQuery : $,

	settings : {
		columns : '.column',
		widgetSelector: '.widget',
		handleSelector: '.widget-head',
		contentSelector: '.widget-content',
		widgetDefault : {
			movable: true,
			removable: true,
			collapsible: false,
			editable: true
		},
		widgetIndividual : {
/*
			intro : {
				movable: false,
				removable: false
			}
*/
		}
	},

	init : function () {
		this.addWidgetControls();
		this.makeSortable();
                this.assignEvents();
	},

        assignEvents : function(id) {
            var iNettuts = this,
            $ = this.jQuery,
            settings = this.settings;

            $("#iNettuts a.icon-delete").live("click",function () {
                $(this).parent().parent().clone().appendTo("#general");
                $("#"+ $(this).parent().parent().attr("id") +" a.icon-accept").click();

                $(this).parents(settings.widgetSelector).animate({
                        opacity: 0
                },function () {
                        $(this).wrap('<div />').parent().slideUp(function () {
                                $(this).remove();
                        });
                });

                iNettuts.makeSortable();
                return false;
            });
            
            $("#iNettuts a.icon-edit").live("click", function () {
                    $(this).removeClass("icon-edit").addClass("icon-accept")
                            .parents(settings.widgetSelector)
                            .find('.edit-box').show().find('input').focus();
                    return false;
            });

            $("#iNettuts a.icon-accept").live("click", function () {
                    $(this).removeClass("icon-accept").addClass("icon-edit")
                            .parents(settings.widgetSelector)
                            .find('.edit-box').hide();
                    return false;
            });

        },

	getWidgetSettings : function (id) {
		//alert(id);
		var $ = this.jQuery,
			settings = this.settings;
		return (id && settings.widgetIndividual[id])
				? $.extend({}, settings.widgetDefault, settings.widgetIndividual[id])
				: settings.widgetDefault;
	},

	addWidgetControls : function () {
		var iNettuts = this,
			$ = this.jQuery,
			settings = this.settings;                

		$(settings.widgetSelector, $(settings.columns)).each(function () {
			var thisWidgetSettings = iNettuts.getWidgetSettings(this.id);
			if (thisWidgetSettings.removable) {
				$('<a href="#" class="icon icon-delete" title="Удалить"></a>').mousedown(function (e) {
					e.stopPropagation();
				}).appendTo($(settings.handleSelector, this));
                                
			}

			if (thisWidgetSettings.editable && getModuleSetting($(this).attr("id"))) {

				$('<a href="#" class="icon icon-edit" title="Настройки"></a>').mousedown(function (e) {
					e.stopPropagation();
				}).appendTo($(settings.handleSelector,this));
				/*var $editBox = $('<div class="edit-box" style="display:none;"/>')
					.append('<ul><li class="item"><label>Change the title?</label><input value="' + $('h3',this).text() + '"/></li>')
					.append('</ul>');*/
                                //alert(getModuleSetting($(this).attr('moduel')));
                                var $editBox = $('<div class="edit-box" style="display:none;"/>')
					.append(getModuleSetting($(this).attr('id')));
				$(settings.contentSelector,this).html($editBox);
			}

/*
			if (thisWidgetSettings.collapsible) {
				$('<a href="#" class="icon icon-collapse" title="Свернуть / развернуть"></a>').mousedown(function (e) {
					e.stopPropagation();
				}).toggle(function () {
					$(this).css({backgroundPosition: '-38px 0'})
						.parents(settings.widgetSelector)
							.find(settings.contentSelector).hide();
					return false;
				},function () {
					$(this).css({backgroundPosition: ''})
						.parents(settings.widgetSelector)
							.find(settings.contentSelector).show();
					return false;
				}).prependTo($(settings.handleSelector,this));
			}
*/

		});

	},

	makeSortable : function () {
		var iNettuts = this,
			$ = this.jQuery,
			settings = this.settings,
			$sortableItems = (function () {
				var notSortable = '';
				$(settings.widgetSelector,$(settings.columns)).each(function (i) {
					if (!iNettuts.getWidgetSettings(this.id).movable) {
						if(!this.id) {
							this.id = 'widget-no-id-' + i;
						}
						notSortable += '#' + this.id + ',';
					}
				});
				if (notSortable == "") {
					return $('> li', settings.columns);
				} else {
					return $('> li:not(' + notSortable + ')', settings.columns);
				}
			})();

		$sortableItems.find(settings.handleSelector).css({
			cursor: 'move'
		}).mousedown(function (e) {
			$sortableItems.css({width:''});
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
			items: $sortableItems,
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
			}
		});
	}

};

iNettuts.init();