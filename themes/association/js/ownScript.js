jQuery(document).ready(function(){
/*global jQuery:false */
/*jshint devel:true, laxcomma:true, smarttabs:true */
"use strict";



	// hide .scrollTo_top first
		jQuery(".scrollTo_top").hide();
	// fade in .scrollTo_top
	jQuery(function () {
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 100) {
				jQuery('.scrollTo_top').fadeIn();
				jQuery('#header').addClass('scrolled'); 
			} else {
				jQuery('.scrollTo_top').fadeOut();
				jQuery('#header').removeClass('scrolled'); 
			}
		});

		// scroll body to 0px on click
	jQuery('.scrollTo_top a').on('click',function(){
		jQuery('html, body').animate({scrollTop:0}, 500 );
		return false;
	});
	});
		
		

	// trigger + show menu on fire
	  
	jQuery('a#navtrigger').on('click',function(){ 
			jQuery('#navigation').toggleClass('shownav'); 
			jQuery('#header ul.social-menu').toggleClass('shownav'); 
			jQuery(this).toggleClass('active'); 
			return false; 
	});

	// safari fix
	jQuery(function() {
		if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1){
				jQuery(".navhead").css('-webkit-transform','none');
		}
	});
	
	
	/* searchtrigger */
	jQuery('a.searchtrigger').on('click',function(){ 
			jQuery('#curtain').toggleClass('open'); 
            jQuery(this).toggleClass('opened'); 
			return false; 
	}); 
	
	jQuery('a.curtainclose').on('click',function(){ 
			jQuery('#curtain').removeClass('open'); 
			jQuery('a.searchtrigger').removeClass('opened');
			return false; 
	});
	
	/* clear the blog */
	jQuery('.ml_row>.ml_span12>.homeblog_mini .item:nth-child(3n),.ml-block-ml_2_3_column_block>.ml_span12 .item:nth-child(2n)').next().css({'clear': 'both'});

	/* Tooltips */
	jQuery("body").prepend('<div class="tooltip"><p></p></div>');
	var tt = jQuery("div.tooltip");
	
	jQuery("#footer ul.social-menu li a,.ribbon_icon,.rating_star,.nav_item i").hover(function() {								
		var btn = jQuery(this);
			
			tt.children("p").text(btn.attr("title"));								
						
			var t = Math.floor(tt.outerWidth(true)/2),
				b = Math.floor(btn.outerWidth(true)/2),							
				y = btn.offset().top - 55,
				x = btn.offset().left - (t-b);
						
			tt.css({"top" : y+"px", "left" : x+"px", "display" : "block"});			
			   
		}, function() {		
			tt.hide();			
	});



	function lightbox() {
		// Apply PrettyPhoto to find the relation with our portfolio item
		jQuery("a[data-gal^='prettyPhoto']").prettyPhoto({
			// Parameters for PrettyPhoto styling
			animationSpeed:'fast',
			slideshow:5000,
			theme:'pp_default',
			show_title:false,
			overlay_gallery: false,
			social_tools: false
		});
	}
	
	if(jQuery().prettyPhoto) {
		lightbox();
	}

});