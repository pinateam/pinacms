jQuery(function ($) {
		
/* jQuery Tools - Overlay */
	$("#header a[rel], #footnotes a[rel], #main_panes a[rel], #singleMainContent .add_to_wishlist_inactive a, #floatswrap .order_table a[rel], .shipping-form a[rel], a.show-popup").each(function(i) {
			
		$(this).overlay({
			effect: 'apple'
		});			
	});	

/* most popular - Image Hover */
	$('#floatswrap .widget .contentWrap').hover(function(){
		var $go = $(this).find('.teaser');
		$go.stop().animate({'opacity':'0.8'},{queue:false,duration:500});
	}, function(){
		var $go = $(this).find('.teaser');
		$go.stop().animate({'opacity':'0'},{queue:false,duration:500});
	});	
	

/* Multiple Product Pages - Image Hover */
	$('#floatswrap .contentWrap').hover(function(){
		var $go = $(this).find('.hover_link');
		$go.stop().animate({opacity:'0'},{queue:false,duration:500});
	}, function(){
		var $go = $(this).find('.hover_link');
		$go.stop().animate({opacity:'1'},{queue:false,duration:500});
	});

/* Single Product Page - jQuery Tools - Tabs*/
	$("#singleMainContent .related .tabs").tabs(".related div.panes > div", { event:'click' });
	$("#singleMainContent .single_post .tabs").tabs("#main_panes > div", { event:'click' });
	
/* Single Product Page - Adjacent Products */
	$('.adjacentProd').hover(function(){
		var $showME = $(this).find('.adjacentImg');
		$showME.stop(false,true).fadeIn("slow");
	}, function(){
		var $showME = $(this).find('.adjacentImg');
		$showME.stop(false,true).fadeOut("slow");
	});
	
/* Single Product Page - Main Product Image Tabs Add current class  */
	$("#singleMainContent .thumbTabs li:first-child .thumbTab").addClass('current');
	$("#singleMainContent .thumbTabs .thumbTab").mouseover(function() {
		$(this).addClass('current').parent().siblings().children().removeClass('current');
	});
	
});	

$(window).load(function(){

/* EQUAL HEIGHTS (fire this when everything has loaded for correct height calculation) */
	$.fn.equalHeights = function() {
		var maxheight = 0;
		$(this).children().each(function(){
			maxheight = ($(this).height() > maxheight) ? $(this).height() : maxheight;
		});
		$(this).children().css('height', maxheight);
	}
	$('#floatswrap .eqcol, #main_panes').equalHeights();

});

/* FONT REPLACEMENT */
Cufon.replace('.widget-title, .comments_title, .respond_title, .trackback_title', {
hover: true
});
