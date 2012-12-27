!function($, window) {

	$(function(){
		// prettify
		$('pre').addClass('prettyprint');
		prettyPrint();

		$('.qa-search-field').focus(function(){
			$(this).animate({width:'300px'}, 400);
		}).blur(function(){
			$(this).animate({width:'165px'}, 400);
		})
	})	// end Document ready
}(window.jQuery, window)