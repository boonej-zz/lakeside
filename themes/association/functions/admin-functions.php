<?php
//definitions
if(!defined('ASSOCIATION_PATH')) define( 'ASSOCIATION_PATH', get_template_directory() . '/functions/layout-blocks/' );

// plugin related blocks

// detect plugin 
if ( class_exists( 'MasterCity' ) ) {
	

	//  2/3 (content) block
	require_once(ASSOCIATION_PATH . 'ml-2-3-column-block.php');
	ml_register_block('ML_2_3_Column_Block');
	
	// 1/3 (sidebar) block
	require_once(ASSOCIATION_PATH . 'ml-3-column-block.php');
	ml_register_block('ML_3_Column_Block');

	//flexslider block
	require_once(ASSOCIATION_PATH . 'ml-flexslider-block.php');
	ml_register_block('ML_Flexslider_Block');
	
	//blog
	require_once(ASSOCIATION_PATH . 'ml-blog-classic.php');
	ml_register_block('ML_Blog');
	
	//blog minimal
	require_once(ASSOCIATION_PATH . 'ml-blog-minimal.php');
	ml_register_block('ML_Blog_Minimal');

	// call to action block
	require_once(ASSOCIATION_PATH . 'ml-text-block-action.php');
	ml_register_block('ML_Text_Block_Action');
	
	// text (full-width) block
	require_once(ASSOCIATION_PATH . 'ml-text-block-full.php');
	ml_register_block('ML_Text_Block_Full');

	// text block
	require_once(ASSOCIATION_PATH . 'ml-text-block.php');
	ml_register_block('ML_Text_Block');
	
	// MP Services
	require_once(ASSOCIATION_PATH . 'ml-mp-services.php');
	ml_register_block('ML_MP_Services');
	
	// MP Staff
	require_once(ASSOCIATION_PATH . 'ml-mp-staff.php');
	ml_register_block('ML_MP_Staff');
	
	// widgets block
	require_once(ASSOCIATION_PATH . 'ml-widgets.php');
	ml_register_block('ML_Widgets_Block');
	
	// clear block
	require_once(ASSOCIATION_PATH . 'ml-clear-block.php');
	ml_register_block('ML_Clear_Block');





	// Get out of my theme :)
	add_action('wp_print_styles', 'tmnf_dequeue_css_from_plugins', 100);
	function tmnf_dequeue_css_from_plugins()  {
		wp_dequeue_style('master-layout-style');
		wp_dequeue_style('mp-font-awesome.min');
	}
	
	function tmnf_enqueue_ml_style() {
		wp_enqueue_style('master-layout', get_template_directory_uri() .	'/styles/master-layout.css');
	}
	add_action( 'wp_enqueue_scripts', 'tmnf_enqueue_ml_style' );

	
		
}


/*-----------------------------------------------------------------------------------*/
/* REDUX - speciable */
/*-----------------------------------------------------------------------------------*/

// detect plugin 
if ( class_exists( 'ReduxFrameworkPlugin' ) ) {

function tmnf_custom_style() {
			wp_enqueue_style('tmnf-custom-style',get_template_directory_uri() . '/styles/custom-style.css'
	);
	$themnific_redux = get_option( 'themnific_redux' );
	if (empty($themnific_redux['tmnf-custom-css'])) {} else {
		$custom_redux = $themnific_redux['tmnf-custom-css'];
	wp_add_inline_style( 'tmnf-custom-style', $custom_redux );
	}
	

}
add_action( 'wp_enqueue_scripts', 'tmnf_custom_style' );

} else {
	
	function association_enqueue_reduxfall() {
		
		// Redux fallback
		wp_enqueue_style('tmnf-reduxfall', get_template_directory_uri() . '/styles/reduxfall.css');
		
		// google link
		function association_fonts_url() {
			$font_url = '';
			if ( 'off' !== _x( 'on', 'Google font: on or off','association') ) {
				$font_url = add_query_arg( 'family', urlencode( 'Roboto:400,700|Raleway:400,500,600,700,800|Montserrat:400,700&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
			}
			return $font_url;
		}
    	wp_enqueue_style( 'tmnf-fonts', association_fonts_url(), array(), '1.0.0' );

		
	}
	add_action( 'wp_enqueue_scripts', 'association_enqueue_reduxfall' );
	
}


/*-----------------------------------------------------------------------------------*/
/* THE END */
/*-----------------------------------------------------------------------------------*/
?>