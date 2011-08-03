/**************************************************** 
	jQuery jquery.slideshow.js
	A powerpoint-esque slideshow
	Johnathan Warlick <johnathanwarlick@gmail.com>
	http://johnathanwarlick.com
	License: USE IT! 
****************************************************/

(function($) {
	
	//define slideshow object with some default c settings
	$.slideshow = {
	  defaults: {
	  	panels	: ".panels",	  	
	  	$panels	: $(panels),
	  	panel_id: "panel",	  	
	    next	: ".next",
	    $next	: $(next),
	    prev	: ".prev",
	    $prev	: $(prev),
	    current_panel : "current-panel",
	    current_panel : $("."+current_panel),
	    transition : true,
	    speed: 300
	  }
	};

	//extend jquery with the plugin
	$.fn.extend({
		slideshow:function(c) {		
					
			//use defaults or properties supplied by user
			var c = $.extend({}, $.slideshow.defaults, c);
			
			alert($panels);
			// The first step? Load the first panel. 
			
			
				
							

	
			//return the jquery object for chaining
			return this;
		}
	});
		
})(jQuery);
