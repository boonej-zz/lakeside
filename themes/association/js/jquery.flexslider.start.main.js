jQuery(window).load(function() {
/*global jQuery:false */
"use strict";
	
  jQuery('.mainflex').flexslider({
	animation: "fade",
	slideshow: true,                //Boolean: Animate slider automatically
	slideshowSpeed: 11000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
	animationDuration: 600,
	smoothHeight: true,
	useCSS: false,
	prevText: "", 
	nextText: "",
	start: function(slider) {
  		slider.removeClass('loading');
		}
    });
  
});