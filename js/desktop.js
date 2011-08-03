jQuery.noConflict();
(function($) {

	$(document).ready(function() {

		$('#slideshow').jcarousel({
			scroll: 1,	
			wrap: 'both',	
			visible: 1,	
			easing: 'swing',
			buttonNextHTML: '<div>next &raquo;</div>',	
			buttonPrevHTML: '<div>&laquo; previous</div>'	

		});
	
	});

})(jQuery);  



