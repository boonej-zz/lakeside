<?php

/*-----------------------------------------------------------------------------------
- Default
----------------------------------------------------------------------------------- */

add_action( 'after_setup_theme', 'association_theme_setup' );

function association_theme_setup() {
	global $content_width;

	/* Set the $content_width for things such as video embeds. */
	if ( !isset( $content_width ) )
		$content_width = 1110;

	/* Add theme support for automatic feed links. */
	add_theme_support( 'post-formats', array( 'video','audio', 'gallery','quote', 'link' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'woocommerce' );

	/* Add theme support for post thumbnails (featured images). */
	if (function_exists('add_theme_support')) {		
		add_theme_support('post-thumbnails');
		add_image_size('association_slider', 1600, 620, true );		//(cropped)
		add_image_size('association_blog', 299, 225, true );		//(cropped)
		add_image_size('association_tabs', 95, 70, true );		//(cropped)
	}
	
	function association_thumb_url(){
	$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2100,2100 ));
	return esc_url($src[0]);
	}

	/* Add your nav menus function to the 'init' action hook. */
	add_action( 'init', 'association_register_menus' );

	/* Add your sidebars function to the 'widgets_init' action hook. */
	add_action( 'widgets_init', 'association_register_sidebars' );
}

function association_register_menus() {
	register_nav_menus(array(
			'magazine-menu' => esc_html__( 'Main Menu','association' ),
			'bottom-menu' => esc_html__( 'Footer Menu','association' ),
	));
}

function association_register_sidebars() {
	
	register_sidebar(array('name' => esc_html__( 'Sidebar (Blog)','association' ),'id' => 'tmnf-sidebar','description' => esc_html__( 'Sidebar widget section (displayed on posts / blog)','association' ),'before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget"><span>','after_title' => '</span></h2>'));
	
	register_sidebar(array('name' => esc_html__( 'Sidebar (Pages)','association' ),'id' => 'tmnf-sidebar-pages','description' => esc_html__( 'Sidebar widget section (displayed on pages)','association' ),'before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget"><span>','after_title' => '</span></h2>'));
	
	//footer widgets
	register_sidebar(array('name' => esc_html__( 'Footer 1','association' ),'id' => 'tmnf-footer-1','description' => esc_html__( 'Widget section in footer - left','association' ),'before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget dekoline">','after_title' => '</h2>'));
	register_sidebar(array('name' => esc_html__( 'Footer 2','association' ),'id' => 'tmnf-footer-2','description' => esc_html__( 'Widget section in footer - center','association' ),'before_widget' => '','after_widget' => '','before_title' => '<h2>','after_title' => '</h2>'));
	register_sidebar(array('name' => esc_html__( 'Footer 3','association' ),'id' => 'tmnf-footer-3','description' => esc_html__( 'Widget section in footer - left','association' ),'before_widget' => '','after_widget' => '','before_title' => '<h2>','after_title' => '</h2>'));
	
	//woo widgets
	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar(array('name' => esc_html__( 'Shop Sidebar','association' ),'id' => 'tmnf-shop-sidebar','description' => esc_html__( 'Sidebar widget section (displayed on shop pages)','association' ),'before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget"><span class="maintitle">','after_title' => '</span></h2>'));
	
	}
	
	//free widgets
	if ( class_exists( 'MasterCity' ) ) {
		register_sidebar(array('name' => esc_html__( 'Free 1','association' ),'id' => 'tmnf-free-1','description' => esc_html__( 'Free usage in Layout Creator','association' ),'before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget"><span>','after_title' => '</span></h2>'));
		register_sidebar(array('name' => esc_html__( 'Free 2','association' ),'id' => 'tmnf-free-2','description' => esc_html__( 'Free usage in Layout Creator','association' ),'before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget"><span>','after_title' => '</span></h2>'));
		register_sidebar(array('name' => esc_html__( 'Free 3','association' ),'id' => 'tmnf-free-3','description' => esc_html__( 'Free usage in Layout Creator','association' ),'before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget"><span>','after_title' => '</span></h2>'));
	}
	
}

// Make theme available for translation
load_theme_textdomain( 'association', get_template_directory() . '/lang' );

	
/*-----------------------------------------------------------------------------------
- Framework - Please refrain from editing this section 
----------------------------------------------------------------------------------- */






// Set path to Framework and theme specific functions
$functions_path = get_template_directory() . '/functions/';

// Theme specific functionality
require_once ($functions_path . 'admin-functions.php');					// Custom functions and plugins

require_once ($functions_path . 'posttypes/post-metabox.php'); 			// custom meta box

// Add Redux options panel
if ( !isset( $themnific_redux ) && file_exists( get_template_directory()  . '/redux-framework/redux-themnific.php' ) ) {
    require_once( get_template_directory()  . '/redux-framework/redux-themnific.php' );
}

	
/*-----------------------------------------------------------------------------------
- Enqueues scripts and styles for front end
----------------------------------------------------------------------------------- */ 

function association_enqueue_style() {
	
	// Main stylesheet
	wp_enqueue_style( 'association-style', get_stylesheet_uri());
	
	// prettyPhoto css
	wp_enqueue_style('prettyPhoto', get_template_directory_uri() .	'/styles/prettyPhoto.css');
	
	// Font Awesome css	
	wp_enqueue_style('font-awesome', get_template_directory_uri() .	'/styles/font-awesome.min.css');
	
	
}
add_action( 'wp_enqueue_scripts', 'association_enqueue_style' );




// themnific custom css + chnage the order of how the sytlesheets are loaded, and overrides WooCommerce styles.
function association_custom_order() {
	
	// place wooCommerce styles before our main stlesheet
	if ( class_exists( 'WooCommerce' ) ) {
		wp_dequeue_style( 'woocommerce_frontend_styles' );
		wp_enqueue_style('woocommerce_frontend_styles', plugins_url() .'/woocommerce/assets/css/woocommerce.css');
	}
	if ( class_exists('woocommerce') ) {
	wp_enqueue_style('association-woo-custom', get_template_directory_uri().	'/styles/woo-custom.css');
	}
	wp_enqueue_style('association-mobile', get_template_directory_uri().'/style-mobile.css');
}
add_action('wp_enqueue_scripts', 'association_custom_order');


function association_enqueue_script() {

	// Load Common scripts	
	wp_enqueue_script('hoverIntent', get_template_directory_uri().'/js/jquery.hoverIntent.minified.js',array( 'jquery' ),'', true);
	wp_enqueue_script('prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js',array( 'jquery' ),'', true);
	wp_enqueue_script('superfish', get_template_directory_uri().'/js/superfish.js',array( 'jquery' ),'', true);
	wp_enqueue_script('association-ownScript', get_template_directory_uri() .'/js/ownScript.js',array( 'jquery' ),'', true);
	
	// Singular comment script		
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

}
	
add_action('wp_enqueue_scripts', 'association_enqueue_script');

/*-----------------------------------------------------------------------------------
- Loads all the .php files found in /admin/widgets/ directory
----------------------------------------------------------------------------------- */

include_once (get_template_directory() . '/functions/widgets/widget-ads-300.php');
include_once (get_template_directory() . '/functions/widgets/widget-blogauthor.php');
include_once (get_template_directory() . '/functions/widgets/widget-facebook.php');
include_once (get_template_directory() . '/functions/widgets/widget-featured.php');
include_once (get_template_directory() . '/functions/widgets/widget-social.php');
include_once (get_template_directory() . '/functions/widgets/widget-tabs.php');


/*-----------------------------------------------------------------------------------
- TGM_Plugin_Activation class.
----------------------------------------------------------------------------------- */
require_once get_template_directory() . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'association_register_required_plugins' );
function association_register_required_plugins() {

    $plugins = array(
	

        // REDUX
        array(
            'name'				=> esc_html__( 'Redux Framework','association' ),
            'slug'      		=> 'redux-framework',
            'required'  		=> true,
        ),

        // SHORTCODES ULTIMATE
        array(
            'name'				=> esc_html__( 'Shortcodes Ultimate','association' ),
            'slug'      		=> 'shortcodes-ultimate',
            'required'  		=> true,
        ),


        // MASTER LAYOUT
        array(
            'name'				=> esc_html__( 'Master City','association' ),
            'slug'              => 'mastercity',
            'source'            => get_template_directory() . '/master/mastercity.zip', // The plugin source.
            'required'          => true,
        ),

    );
    $config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => esc_html__( 'Install Required Plugins','association' ),
            'menu_title'                      => esc_html__( 'Install Plugins','association' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s','association' ), // %s = plugin name.
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.','association' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.','association'), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.','association' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.','association' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.','association' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.','association' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.','association' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.','association' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.','association' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins','association' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins','association' ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer','association' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.','association' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s','association' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}

	
/*-----------------------------------------------------------------------------------
- Other theme functions
----------------------------------------------------------------------------------- */



// icons - font awesome
function association_icon() {
	
	if(has_post_format('audio')) {return '<i class="tmnf_icon icon-volume-up"></i>';
	}elseif(has_post_format('gallery')) {return '<i class="tmnf_icon icon-camera"></i>';	
	}elseif(has_post_format('link')) {return '<i class="tmnf_icon icon-link"></i>';			
	}elseif(has_post_format('quote')) {return '<i class="tmnf_icon icon-quote-right"></i>';		
	}elseif(has_post_format('video')) {return '<i class="tmnf_icon icon-play-circle2"></i>';
	} else {return '';}	
	
}

function association_icon_spec() {
	if(has_post_format('link')) {return '<i class="fa fa-sign-out"></i>';	
	} else {'';}
}

// icons ribbons - font awesome
function association_ribbon() {
	if(has_post_format('video')) {return '<span class="ribbon video-ribbon"></span><span class="ribbon_icon"><i class="fa fa-play-circle"></i></span>';
	}elseif(has_post_format('audio')) {return '<span class="ribbon audio-ribbon"></span><span class="ribbon_icon"><i class="fa fa-microphone"></i></span>';
	}elseif(has_post_format('gallery')) {return '<span class="ribbon gallery-ribbon"></span><span class="ribbon_icon"><i class="fa fa-picture-o"></i></span>';
	}elseif(has_post_format('link')) {return '<span class="ribbon link-ribbon"></span><span class="ribbon_icon"><i class="fa fa-link"></i></span>';
	}elseif(has_post_format('image')) {return '<span class="ribbon image-ribbon"></span><span class="ribbon_icon"><i class="fa fa-camera"></i></span>';
	}elseif(has_post_format('quote')) {return '<span class="ribbon quote-ribbon"></span><span class="ribbon_icon"><i class="fa fa-quote-right"></i></span>';
	} else {}	
	
}



// link format
function association_permalink() {
	$linkformat = get_post_meta(get_the_ID(), 'themnific_linkss', true);
	if($linkformat) echo esc_url($linkformat); else the_permalink();
}

// the_excerpt class
add_filter( "the_excerpt", "association_add_class_to_excerpt" );
function association_add_class_to_excerpt( $excerpt ) {
    return str_replace('<p', '<p class="teaser"', $excerpt);
}

// excerpt function
function association_excerpt($text, $chars = 1620) {
	$text = $text." ";
	$text = substr($text,0,$chars);
	$text = substr($text,0,strrpos($text,' '));
	$text = $text."";
	return $text;
}

function association_trim_excerpt($text) {
     $text = str_replace('[', '', $text);
     $text = str_replace(']', '', $text);
     return $text;
    }
add_filter('get_the_excerpt', 'association_trim_excerpt');






// function to display number of views.
function association_post_views($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count.'';
}

// function to count views.
function association_count_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}



// pagination
function association_pagination( $args = array() ) {
global $wp_rewrite, $wp_query;

/* If there's not more than one page, return nothing. */
if ( 1 >= $wp_query->max_num_pages )
return;

/* Get the current page. */
$current = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );

/* Get the max number of pages. */
$max_num_pages = intval( $wp_query->max_num_pages );

/* Get the pagination base. */
$pagination_base = $wp_rewrite->pagination_base;

/* Set up some default arguments for the paginate_links() function. */
$defaults = array(
'base' => esc_url(add_query_arg( 'paged', '%#%' )),
'format' => '',
'total' => $max_num_pages,
'current' => $current,
'prev_next' => true,
'show_all' => false,
'end_size' => 1,
'mid_size' => 1,
'add_fragment' => '',
'type' => 'plain',

// Begin loop_pagination() arguments.
'before' => '<nav class="loop-pagination">',
'after' => '</nav>',
'echo' => true,
);

/* Add the $base argument to the array if the user is using permalinks. */
if ( $wp_rewrite->using_permalinks() && !is_search() )
$defaults['base'] = user_trailingslashit( trailingslashit( get_pagenum_link() ) . "{$pagination_base}/%#%" );

/* Allow developers to overwrite the arguments with a filter. */
$args = apply_filters( 'loop_pagination_args', $args );

/* Merge the arguments input with the defaults. */
$args = wp_parse_args( $args, $defaults );

/* Don't allow the user to set this to an array. */
if ( 'array' == $args['type'] )
$args['type'] = 'plain';

/* Get the paginated links. */
$page_links = paginate_links( $args );

/* Remove 'page/1' from the entire output since it's not needed. */
$page_links = preg_replace(
array(
"#(href=['\"].*?){$pagination_base}/1(['\"])#", // 'page/1'
"#(href=['\"].*?){$pagination_base}/1/(['\"])#", // 'page/1/'
"#(href=['\"].*?)\?paged=1(['\"])#", // '?paged=1'
"#(href=['\"].*?)&\#038;paged=1(['\"])#" // '&#038;paged=1'
),
'$1$2',
$page_links
);

/* Wrap the paginated links with the $before and $after elements. */
$page_links = $args['before'] . $page_links . $args['after'];

/* Allow devs to completely overwrite the output. */
$page_links = apply_filters( 'loop_pagination', $page_links );

/* Return the paginated links for use in themes. */
if ( $args['echo'] )
echo ($page_links);
else
return $page_links;
}



//Breadcrumbs
function association_breadcrumbs() {
	if (!is_home()) {
		echo '<a href="'. esc_url(home_url('/')).'">';
		echo '<i class="icon-home"></i> ';
		echo "</a> <i class='fa fa-angle-right'></i>
 ";
		if (is_category() || is_single()) {
			the_category(', ');
			if (is_single()) {
				echo " <i class='fa fa-angle-right'></i> ";
				echo the_title();
			}
	} elseif (is_page()) {
		global $post;
		if($post->post_parent){
			echo get_the_title($post->post_parent)."<i class='fa fa-angle-right'></i>";
			echo the_title();
		} else {
			echo the_title();
		}
	} 
	}
}


function association_attachment_toolbox($size = thumbnail) {
	if($images = get_children(array(
		'post_parent'    => get_the_ID(),
		'post_type'      => 'attachment',
		'numberposts'    => -1, // show all
		'post_status'    => null,
		'post_mime_type' => 'image',
	))) {
		foreach($images as $image) {
			$attimg   = wp_get_attachment_image($image->ID,$size);
			$atturl   = wp_get_attachment_url($image->ID);
			$attlink  = get_attachment_link($image->ID);
			$postlink = get_permalink($image->post_parent);
			$atttitle = apply_filters('the_title',$image->post_title);

			echo '<p><strong>wp_get_attachment_image()</strong><br />'.$attimg.'</p>';
			echo '<p><strong>wp_get_attachment_url()</strong><br />'.esc_url($atturl).'</p>';
		}
	}
}

//Featured image in RSS feeds
function association_image_in_rss($content)
{
    global $post;
    if (has_post_thumbnail($post->ID))
    {
        $content = get_the_post_thumbnail($post->ID, 'small', array('style' => 'margin-bottom:10px;')) . $content;
    }
    return $content;
}
add_filter('the_excerpt_rss', 'association_image_in_rss');
add_filter('the_content_feed', 'association_image_in_rss');


// meta sections

function association_meta_cat() {
	?>    
	<p class="meta cat fr tranz <?php global $themnific_redux ; if($themnific_redux['post-meta-dis'] == '1') echo 'tmnf_hide' ?>">
		<?php the_category(' ') ?>
    </p>
    <?php
}

function association_meta_date() {
	?>    
	<p class="meta date tranz <?php global $themnific_redux ; if($themnific_redux['post-meta-dis'] == '1') echo 'tmnf_hide' ?>"> 
        <?php the_time(get_option('date_format')); ?>
    </p>
    <?php
}

function association_meta() { ?>   
	<p class="meta <?php global $themnific_redux ; if($themnific_redux['post-meta-dis'] == '1') echo 'tmnf_hide' ?>">
		<?php the_time(get_option('date_format')); ?> &bull; 
		<?php the_category(', ') ?>
    </p>
<?php }

function association_meta_full() { ?>    
	<p class="meta fl meta_full <?php global $themnific_redux ; if($themnific_redux['post-meta-dis'] == '1') echo 'tmnf_hide' ?>">
    	<span class="date"><?php the_time(get_option('date_format')); ?></span>
        <span class="tmnf_divider"> / </span>
      	<span class="comm"><i class="icon-chat"></i> <?php comments_popup_link( esc_html__('Comments (0)','association'), esc_html__('Comments (1)','association'), esc_html__('Comments (%)','association')); ?></span>
    </p>
<?php
}

function association_meta_more() {
	?>    
	<p class="meta_more">
    		<a href="<?php association_permalink() ?>"><i class="fa fa-angle-right" aria-hidden="true"></i>
</a>
    </p>
    <?php
}

// get featured image on posts screen  
function association_get_featured_image($post_ID) {  
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);  
    if ($post_thumbnail_id) {  
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'thumbnail');  
        return $post_thumbnail_img[0];  
    }  
} 
    // ADD NEW COLUMN  
    function association_columns_head($defaults) {  
        $defaults['featured_image'] = 'Featured Image';  
        return $defaults;  
    }  
    // SHOW THE FEATURED IMAGE  
    function association_columns_content($column_name, $post_ID) {  
        if ($column_name == 'featured_image') {  
            $post_featured_image = association_get_featured_image($post_ID);  
            if ($post_featured_image) {  
                echo '<img src="' . $post_featured_image . '" />';  
            }  
        }  
    }  
add_filter('manage_posts_columns', 'association_columns_head');  
add_action('manage_posts_custom_column', 'association_columns_content', 10, 2); 

	

// Walker menu
class association_description_walker extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) 
      {
           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names ) . '"';

           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

           $prepend = '';
           $append = '';
           $description  = ! empty( $item->description ) ? '<div class="sub sf-mega">'.esc_attr( $item->description ).'</div>' : '';

           if($depth != 0)
           {
                     $description = $append = $prepend = "";
           }

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= '</a>';
            $item_output .= $description.$args->link_after;
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
}

add_filter('wp_nav_menu', 'association_do_menu_shortcodes');
function association_do_menu_shortcodes( $menu ){
        return do_shortcode( $menu );
}


// Remove Paragraph Tags From Around Images
function association_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'association_filter_ptags_on_images');

if ( class_exists( 'MasterCity' ) ) {
		add_image_size('mp-service', 353, 197, true );		//(cropped)
}


/////////
// woocommerce
/////////
 
	
// limit related na upsells posts

if ( class_exists( 'WooCommerce' ) ) {
	
	// Change number or products per row to 3
	add_filter('loop_shop_columns', 'loop_columns');
	if (!function_exists('loop_columns')) {
		function loop_columns() {
			return 3; // 3 products per row
		}
	}
	
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );
	 
	if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
	function woocommerce_output_upsells() {
		woocommerce_upsell_display( 3,3 ); // Display 3 products in rows of 3
	}
	}

}




?>