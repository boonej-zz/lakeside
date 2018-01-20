<?php
/** A simple text block **/
class ML_MP_Staff extends ML_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => esc_html__('Staff','association'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('ML_MP_Staff', $block_options);
	}
	
	function form($instance) {
                
	$defaults = array('title' => '','subtitle' => '', 'post_type' => 'all', 'categories' => '', 'posts' => 3,'type_sel' =>'','layout_sel' =>'','columns_sel' => '3',
	'block_bg_color' => '#f9f9f9','block_text_color' => '#222','height' => '60' );

	$type_type = array(
				'' => esc_html__('Default','association'),
				'boxed' => esc_html__('Boxed','association'),
			);
			
	$layout_type = array(
				'' => esc_html__('Default','association'),
				'simple' => esc_html__('Simple','association'),
			);

	$columns_type = array(
				'1' => esc_html__('1 Columns','association'),
				'2' => esc_html__('2 Columns','association'),
				'3' => esc_html__('3 Columns','association'),
				'4' => esc_html__('4 Columns','association'),
			);
	$instance = wp_parse_args((array) $instance, $defaults);
	
			
   	
	extract($instance); ?>		
                
                
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('title')) ?>">
				<?php esc_html_e('Title (optional)','association'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('title')) ?>" class="input-full" type="text" value="<?php echo esc_attr($title) ?>" name="<?php echo esc_attr($this->get_field_name('title')) ?>">
			</label>
		</p>
        
       	<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('subtitle')) ?>">
				<?php esc_html_e('Subitle (optional)','association'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('subtitle')) ?>" class="input-full" type="text" value="<?php echo esc_attr($subtitle) ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')) ?>">
			</label>
		</p>

        <p class="description half last" style=" clear:right;">
			<label for="<?php echo esc_attr($this->get_field_id('categories')); ?>"><?php esc_html_e('Filter by Category:','association'); ?></label> 
			<select id="<?php echo esc_attr($this->get_field_name('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>" class="widefat categories">
				<option value='' <?php if ('' == $instance['categories']) echo 'selected="selected"'; ?>></option>
				<?php $categories = get_categories($args = array(
															'type'		=> 'mp_staff',
															'orderby'	=> 'name',
															'order'		=> 'ASC',
															'taxonomy'	=> 'mp_teams'
															)) ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo esc_attr($category->cat_name); ?>' <?php if ($category->cat_name == $instance['categories']) echo 'selected="selected"'; ?>><?php echo esc_attr($category->cat_name); ?></option>
				<?php } ?>
			</select>
		</p>
        
        <p class="clearfix"></p>
		
		<p class="description half">
			<label for="<?php echo esc_attr($this->get_field_id('type_sel')) ?>">
				<?php esc_html_e('Select MP type','association'); ?><br/>
               <?php echo ml_field_select('type_sel', $block_id, $type_type, $type_sel, $block_id); ?>
			</label>
		</p>
        
		<p class="description half">
			<label for="<?php echo esc_attr($this->get_field_id('layout_sel')) ?>">
				<?php esc_html_e('Select layout','association'); ?><br/>
               <?php echo ml_field_select('layout_sel', $block_id, $layout_type, $layout_sel, $block_id); ?>
			</label>
		</p>
        
		<p class="description half">
			<label for="<?php echo esc_attr($this->get_field_id('columns_sel')) ?>">
				<?php esc_html_e('Pick number of columns','association'); ?><br/>
               <?php echo ml_field_select('columns_sel', $block_id, $columns_type, $columns_sel, $block_id); ?>
			</label>
		</p>
        
        <p class="clearfix"></p>
		
		<p class="description half">
			<label for="<?php echo esc_attr($this->get_field_id('posts')); ?>"><?php esc_html_e('Number of posts:','association'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('posts')); ?>" name="<?php echo esc_attr($this->get_field_name('posts')); ?>" value="<?php echo esc_attr($instance['posts']); ?>" />
		</p>
        
        
        <p class="clearfix"></p>
        
        <div class="description half">
			<label for="<?php echo esc_attr($this->get_field_id('block_bg_color')) ?>">
				<?php esc_html_e('Pick a background color','association'); ?><br/>
				<?php echo ml_field_color_picker('block_bg_color', $block_id, $block_bg_color, $defaults['block_bg_color']) ?>
			</label>
			
		</div>   
        
        <div class="description half">
			<label for="<?php echo $this->get_field_id('block_text_color') ?>">
				<?php esc_html_e('Pick a link & text color','association'); ?><br/>
				<?php echo ml_field_color_picker('block_text_color', $block_id, $block_text_color, $defaults['block_text_color']) ?>
			</label>
			
		</div>
        
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
		$post_type = 'all';
		$categories = $instance['categories'];
		$type = $instance['type_sel'];
		$layout = $instance['layout_sel'];
		$columns = $instance['columns_sel'];
		$posts = $instance['posts'];
		
		?>
			

        
        <div class="widgetwrap" style="padding:<?php echo esc_html($height);?>px 0;">
        
        <div class="block_bg"  style="background-color:<?php echo esc_attr($block_bg_color);?>;"></div>
        
        	<div class="container">
        
			<?php if ( $title == "") {} else { ?>
            <h2 class="block"  style="color:<?php echo esc_attr($block_text_color);?>;">
                
                <span class="maintitle" style="background-color:<?php echo esc_attr($block_bg_color);?>;"><?php echo esc_attr($title) ?></span>
                
                <?php if ( $subtitle == "") {} else { ?>
                    <span class="subtitle" style="color:<?php echo esc_attr($block_text_color);?>;"><?php echo esc_attr($subtitle) ?></span>
                <?php } ?>
                    
            </h2>
            <?php } ?><!-- end title section-->


            <?php echo do_shortcode('[mc-staff category="'.  esc_attr($categories) .'" type="'. esc_attr($type).'" layout="'. esc_attr($layout).'" columns="'. esc_attr($columns).'"  posts="'. esc_attr($posts).'"]'); ?>
            </div> 

        </div>
        <?php wp_reset_postdata(); ?>
        <?php
                
        }
	
}
ml_register_block('ML_MP_Staff');