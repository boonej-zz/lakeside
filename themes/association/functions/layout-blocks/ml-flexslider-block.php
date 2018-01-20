<?php
/** A simple text block **/
class ML_Flexslider_Block extends ML_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => esc_html__('Main Slider (Full Width)','association'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('ml_flexslider_block', $block_options);
	}
	
	function form($instance) {
                
	$defaults = array('title' => '', 'post_type' => 'all', 'categories' => 'all', 'posts' => 4,'query_type_sel' => 'Latest', 'no_margin' => 1,'menu_dis' => 0,'boxed_layout'=>'1','block_bg_color' => '#212233','block_text_color' => '#fff');
	$query_type = array(
				'latest' => esc_html__('Latest','association'),
				'featured' => esc_html__('Featured','association'),
			);
	$instance = wp_parse_args((array) $instance, $defaults);
	
			
   	
	extract($instance); ?>	
    
    
    	<p class="description"><?php esc_html_e('Do not use this block inside "column" block','association'); ?></p>	
                
        <hr>        
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('title')) ?>">
				<?php esc_html_e('Title (optional)','association'); ?><br/>
                <small><?php esc_html_e('For back-end purpose only, title is not visible on the front-end','association'); ?></small>
				<input id="<?php echo esc_attr($this->get_field_id('title')) ?>" class="input-full" type="text" value="<?php echo esc_attr($title) ?>" name="<?php echo esc_attr($this->get_field_name('title')) ?>">
			</label>
		</p>

		<p class="description half">
			<label for="<?php echo esc_attr($this->get_field_id('query_type_sel')) ?>">
				<?php esc_html_e('Pick a query type (Latest vs. Featured)','association'); ?><br/>
               	<?php echo ML_field_select('query_type_sel', $block_id, $query_type, $query_type_sel, $block_id); ?>
			</label>
		</p>

        <p class="description half last">
			<label for="<?php echo esc_attr($this->get_field_id('categories')); ?>"><?php esc_html_e('Filter by Category:','association'); ?></label> 
			<select id="<?php echo esc_attr($this->get_field_id('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>></option>
				<?php $categories = get_categories($args = array(
															'type'		=> 'slider',
															'orderby'	=> 'name',
															'order'		=> 'ASC',
															'taxonomy'	=> 'groups'
															)) ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo esc_attr($category->term_id); ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo esc_attr($category->cat_name); ?></option>
				<?php } ?>
			</select>
		</p>
        
        <p class="clearfix"></p>
		
		<p class="description half">
			<label for="<?php echo esc_attr($this->get_field_id('posts')); ?>"><?php esc_html_e('Number of posts:','association'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('posts')); ?>" name="<?php echo esc_attr($this->get_field_name('posts')); ?>" value="<?php echo esc_attr($instance['posts']); ?>" />
		</p>
        
		<?php
	}
		
		
		function block($instance) {
                extract($instance);
		wp_enqueue_script('jquery.flexslider-min', get_template_directory_uri() .'/js/jquery.flexslider-min.js',array( 'jquery' ),'', true);		
		wp_enqueue_script('jquery.flexslider.start.main', get_template_directory_uri() .'/js/jquery.flexslider.start.main.js',array( 'jquery' ),'', true);

        $title = $instance['title'];
		$post_type = 'all';
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		
		?>
			
		<?php
        $featuredpost = new WP_Query(array(
            'showposts' => esc_attr($posts),
            'post_type' => 'slider',
            'tax_query' => array(
                array(
                    'taxonomy' => 'groups',
                    'terms' => $categories,
                    'field' => 'term_id',
                )
            ), 
        ));
        
        $recent_posts = new WP_Query(array(
            'showposts' => esc_attr($posts),
            'post_type' => 'slider', 
        ));
        ?>
        
        </div></div></div>
        <div class="clearfix"></div>
        <div class="mainflex flexslider loading"> 
            
        <div class="loading-inn"><i class="fa fa-circle-o-notch fa-spin"></i></div>
           
           
        <ul class="slides" >
        
        <?php if ($query_type_sel == 'featured'){ ?>      

			<?php if ($featuredpost->have_posts()) : while ( $featuredpost->have_posts() ) : $featuredpost->the_post();
			$project_url = get_post_meta(get_the_ID(), 'themnific_project_url', true);
			$slider_content = get_post_meta(get_the_ID(), 'themnific_slider_inside', true);
			?>

			<li>
                
					<?php if ( has_post_thumbnail()) { ?>
                        
                             <a href="<?php echo (esc_url($project_url)); ?>" title="<?php the_title();?>" >
                             
                                <?php the_post_thumbnail( 'association_slider', array('class' => 'tranz'));  ?>
                                
                             </a>
                        
                    <?php } ?>
                
                    <div class="flexinside rad tranz content_<?php echo esc_attr($slider_content); ?>">
                    
                    	<h2><a href="<?php echo (esc_url($project_url)); ?>" title="<?php the_title();?>" ><?php the_title();?></a></h2>
                    
                        <div class="flexinside-inn">
                            
                            <?php the_content(); ?>
                        
                        </div>
            
                    </div>
                        
			</li>
            
            <?php endwhile; endif;  ?>
            
        <?php } else { ?>    
            
            
			<?php if ($recent_posts->have_posts()) :while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
			$project_url = get_post_meta(get_the_ID(), 'themnific_project_url', true);
			$slider_content = get_post_meta(get_the_ID(), 'themnific_slider_inside', true);
			?>
                    
            <li>
                    
                    <?php if ( has_post_thumbnail()) { ?>
                        
                             <a href="<?php echo (esc_url($project_url)); ?>" title="<?php the_title();?>" >
                             
                                <?php the_post_thumbnail( 'association_slider', array('class' => 'tranz'));  ?>
                                
                             </a>
                        
                    <?php } ?>
                
                        <div class="flexinside rad tranz content_<?php echo esc_attr($slider_content); ?>">
                    
                    		<h2><a href="<?php echo (esc_url($project_url)); ?>" title="<?php the_title();?>" ><?php the_title();?></a></h2>
                            
                            <div class="flexinside-inn">
                                
                            	<?php the_content(); ?>
                            
                            </div>
                        
                        </div>
                        
			</li>
            
			<?php endwhile; endif;  ?>
            
		<?php }  ?> 

        </ul>
        
        </div>
        <div class="clearfix"></div>


        <div class="container_alt builder woocommerce"><div class="ml-template-wrapper ml_row"><div>
        
        
        <?php
                
        }
	
}
ML_register_block('ML_Flexslider_Block');