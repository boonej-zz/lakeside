<?php
/** A simple text block **/
class ML_Blog_Minimal extends ML_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => esc_html__('News: Minimal','association'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('ML_Blog_Minimal', $block_options);
	}
	
	function form($instance) {
                
		$defaults = array('title' => esc_html__('Recent Posts','association'),'subtitle' => esc_html__('Optional Subtitle','association'),'moretitle' => '','urlmore' => '','post_type' => 'all', 'categories' => 'all', 'posts' => 6,'offset_posts' => "", 'columns_sel' => esc_html__('4 Columns','association'),'height' => '60', 'block_bg_color' => '#f9f9f9','block_text_color' => '#fff');
		
	$columns_type = array(
				'3' => esc_html__('3 Columns','association'),
				'4' => esc_html__('4 Columns','association'),
			);
			
		
			
	$instance = wp_parse_args((array) $instance, $defaults);
	extract($instance);	          
    ?>
    
    
    	<p class="description"><?php esc_html_e('This block is not suitable for "Narrow Column" block','association'); ?></p>	
                
        <hr>   
         
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('title')) ?>">
				<?php esc_html_e('Title (optional)','association'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('title')) ?>" class="input-full" type="text" value="<?php echo esc_attr($title) ?>" name="<?php echo esc_attr($this->get_field_name('title')) ?>">
			</label>
		</p>
        
       	<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('subtitle')) ?>">
				<?php esc_html_e('Subtitle (optional)','association'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('subtitle')) ?>" class="input-full" type="text" value="<?php echo esc_attr($subtitle) ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')) ?>">
			</label>
		</p>
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('categories')); ?>"><?php esc_html_e('Filter by Category:','association'); ?></label> 
			<select id="<?php echo esc_attr($this->get_field_id('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo esc_attr($category->term_id); ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo esc_attr($category->cat_name); ?></option>
				<?php } ?>
			</select>
		</p>
        
        <p class="clearfix"></p>
        <hr>
		
		<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('posts')); ?>"><?php esc_html_e('Number of posts:','association'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('posts')); ?>" name="<?php echo esc_attr($this->get_field_name('posts')); ?>" value="<?php echo esc_attr($instance['posts']); ?>" />
		</p>
        
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('moretitle')) ?>">
				<?php esc_html_e('More Posts - Link Title (optional)','association'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('moretitle')) ?>" class="input-full" type="text" value="<?php echo esc_attr($moretitle) ?>" name="<?php echo esc_attr($this->get_field_name('moretitle')) ?>">
			</label>
		</p>
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('urlmore')) ?>">
				<?php esc_html_e('More Posts - URL to archive (optional)','association'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('urlmore')) ?>" class="input-full" type="text" value="<?php echo esc_url($urlmore) ?>" name="<?php echo esc_attr($this->get_field_name('urlmore')) ?>">
			</label>
		</p>
        
        <p class="clearfix"></p>
        
        
        
        <div class="description half">
			<label for="<?php echo esc_attr($this->get_field_id('block_bg_color')) ?>">
				<?php esc_html_e('Pick a background color','association'); ?><br/>
				<?php echo ml_field_color_picker('block_bg_color', $block_id, $block_bg_color, $defaults['block_bg_color']) ?>
			</label>
			
		</div>
        
        <div class="description half last">
			<label for="<?php echo esc_attr($this->get_field_id('block_text_color')) ?>">
				<?php esc_html_e('Pick a link & text color','association'); ?><br/>
				<?php echo ml_field_color_picker('block_text_color', $block_id, $block_text_color, $defaults['block_text_color']) ?>
			</label>
			
		</div>
        
        <p class="clearfix"></p>
        <hr>
		
		<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('offset_posts')); ?>">Offset posts</label>
			<input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('offset_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('offset_posts')); ?>" value="<?php echo esc_attr($instance['offset_posts']); ?>" />
		</p>
        
        <p class="clearfix"></p>
        <hr>
        
		<div class="description">
			<label for="<?php echo esc_attr($this->get_field_id('height')) ?>">
				<?php esc_html_e('Vertical Padding','association'); ?><br/>
				<?php echo ml_field_input('height', $block_id, $height, 'min', 'number') ?> px
			</label>

		</div>
        
		<?php
	}
	
		
		
		
		function block($instance) {
                extract($instance);
        $title = $instance['title'];
        $subtitle = $instance['subtitle'];
        $moretitle = $instance['moretitle'];
        $urlmore = $instance['urlmore'];
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		$offset_posts = $instance['offset_posts'];

		?>
        
        <div class="widgetwrap widgetwrap-alt homeblog_mini" style="padding:<?php echo esc_html($height);?>px 0;">
        
        <div class="block_bg" style="background-color:<?php echo esc_attr($block_bg_color);?>;"></div>
                
			<?php if ( $title == "") {} else { ?>
            <h2 class="block"  style="color:<?php echo esc_attr($block_text_color);?>;">
                
                <span class="maintitle" style="background-color:<?php echo esc_attr($block_bg_color);?>;"><?php echo esc_attr($title) ?></span>
                
                <?php if ( $subtitle == "") {} else { ?>
                    <span class="subtitle" style="color:<?php echo esc_attr($block_text_color);?>;"><?php echo esc_attr($subtitle) ?></span>
                <?php } ?>
                    
            </h2>
            <?php } ?><!-- end title section-->
                    
                  <div class="blogger">
                  
                            <?php
                                if ( get_query_var('paged') ) {
                                    $paged = get_query_var('paged');
                                } else if ( get_query_var('page') ) {
                                    $paged = get_query_var('page');
                                } else {
                                    $paged = 1;
                                }
                                query_posts( array( 'post_type' => 'post', 'paged' => $paged, 'cat' => esc_attr($categories), 'posts_per_page' => esc_attr($posts),'offset' => esc_attr($offset_posts)) );
                            ?>
                            <?php if (have_posts()) : ?>
                            
                            <?php  while ( have_posts() ) : the_post();  ?>
                            
                                <?php get_template_part('/post-types/blog-classic-small-alt'); ?>
                            
                            <?php  endwhile; ?>
            
                        <?php else : endif; wp_reset_query(); ?>
                            
                        <?php if ( $urlmore == "") {} else { ?>
                        
                        	<div class="clearfix"></div>
                        
                            <a class="morebutton" href="<?php echo esc_url($urlmore); ?>"><?php echo esc_attr($moretitle); ?> <i class="fa fa-angle-double-right"></i></a>
                        
                        <?php } ?>
                            
                    </div><!-- end latest posts section-->
            
            <div class="clearfix"></div>
                
        </div><!-- end #core -->
        
        <div class="clearfix"></div>
                
			<?php
                
        }
	
}
ml_register_block('ML_Blog_Minimal');