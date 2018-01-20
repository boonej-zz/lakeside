<?php
add_action('widgets_init', 'association_featured_widget');

function association_featured_widget()
{
	register_widget('association_featured_widget');
}

class association_featured_widget extends WP_Widget {
	
	function association_featured_widget()
	{
		$widget_ops = array('classname' => 'association_featured_widget', 'description' => esc_html__('Featured posts widget.','association'));

		$control_ops = array('id_base' => 'association_featured_widget');

		$this->__construct('association_featured_widget', esc_html__('Themnific - Featured','association'), $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		
		$title = $instance['title'];
		$post_type = 'all';
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		$offset_posts = $instance['offset_posts'];
		
		echo($before_widget);
		?>
		
		<?php
		$post_types = get_post_types();
		unset($post_types['page'], $post_types['attachment'], $post_types['revision'], $post_types['nav_menu_item']);
		
		if($post_type == 'all') {
			$post_type_array = $post_types;
		} else {
			$post_type_array = $post_type;
		}
		?>
        
        <div class="featured-widget">
		
        	<?php if ( $title == "") {} else { ?>
        
				<h2 class="widget widget-alt"><span><a href="<?php echo get_category_link($categories); ?>"><?php echo esc_attr($title); ?></a></span></h2>
			
            <?php } ?>
            
			<?php
			$recent_posts = new WP_Query(array(
				'showposts' => $posts,
				'ignore_sticky_posts' => 1,
				'cat' => $categories,
				'offset' => esc_attr($offset_posts)
			));
			?>
            
                <ul class="featured">
                
				<?php 
                while ( $recent_posts->have_posts() ) : $recent_posts->the_post();if(has_post_format('aside')){ } elseif(has_post_format('quote')){ }else { 
                 };
                ?>
                	<li class="ghost p-border">
                	<?php include( get_template_directory() . '/post-types/featured-post.php'); ?>
                    </li>
            
				<?php  endwhile; ?>
                
                <?php wp_reset_postdata(); ?>
                
                </ul>
            
			<div class="clearfix"></div>
		
        </div>
        
		<?php
		echo($after_widget);
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['post_type'] = 'all';
		$instance['categories'] = $new_instance['categories'];
		$instance['posts'] = $new_instance['posts'];
		$instance['offset_posts'] = $new_instance['offset_posts'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Recent Posts', 'post_type' => 'all', 'categories' => 'all', 'posts' => 5, 'offset_posts' => "");
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','association'); ?></label>
			<input class="widefat" style="width: 100%;" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('categories')); ?>"><?php esc_html_e('Filter by Category:','association'); ?></label> 
			<select id="<?php echo esc_attr($this->get_field_id('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo esc_attr($category->term_id); ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo esc_attr($category->cat_name); ?></option>
				<?php } ?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('posts')); ?>"><?php esc_html_e('Number of posts:','association'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('posts')); ?>" name="<?php echo esc_attr($this->get_field_name('posts')); ?>" value="<?php echo esc_attr($instance['posts']); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('offset_posts')); ?>"><?php esc_html_e('Offset posts:','association'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('offset_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('offset_posts')); ?>" value="<?php echo esc_attr($instance['offset_posts']); ?>" />
		</p>
		

	<?php }
}
?>