<?php
add_action('widgets_init', 'association_tabs_widget');

function association_tabs_widget()
{
	register_widget('association_tabs_widget');
}

class association_tabs_widget extends WP_Widget {
	
	function association_tabs_widget()
	{
		$widget_ops = array('classname' => 'association_tabs_widget', 'description' => esc_html__('Featured posts widget.','association'));

		$control_ops = array('id_base' => 'association_tabs_widget');

		$this->__construct('association_tabs_widget', esc_html__('Themnific - Tabs','association'), $widget_ops, $control_ops);
}	
	function widget($args, $instance)
	{
	extract($args);
		
	wp_enqueue_script('tabs', get_template_directory_uri() .'/js/tabs.js',array( 'jquery' ),'', true);
		
		$title = $instance['title'];
		$post_type = 'all';
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		
		echo($before_widget);
		?>
        
        
		
        	<div id="hometab" class="">
            
                <ul id="serinfo-nav">
                
                        <li class="li01"><a href="#serpane0"><i class="fa fa-fire"></i> <?php esc_html_e('Popular','association');?></a></li>
                        <li class="li02"><a href="#serpane1"><i class="fa fa-clock-o"></i> <?php esc_html_e('Latest','association');?></a></li>
                
                </ul>
                
                <ul id="serinfo">
                
                
                        <li id="serpane0">
                            <?php $popular_query = new WP_Query(array(
                                'showposts' => $posts,
								'ignore_sticky_posts' => 1,
                                'meta_key' => 'post_views_count',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC'
                            )); 
                            while ($popular_query->have_posts()) : $popular_query->the_post(); if(has_post_format('aside')){ } else {?>
                                <?php include( get_template_directory() . '/post-types/tab-post.php'); ?>
                            <?php } endwhile; ?><?php wp_reset_postdata(); ?>
                        </li>
                
                        <li id="serpane1">	
                            <?php $latest_query = new WP_Query(array(
                                'showposts' => $posts,
								'ignore_sticky_posts' => 1,
                                'orderby' => 'post_date'
                            )); 
                            while ($latest_query->have_posts()) : $latest_query->the_post();if(has_post_format('aside')){ } elseif(has_post_format('quote')){ }else {
                            ?>	
                                <?php include( get_template_directory() . '/post-types/tab-post.php'); ?>
                            <?php } endwhile; ?>	<?php wp_reset_postdata(); ?>
                        </li>
                
                </ul>
            
            </div>
            <div class="clearfix"></div> 





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
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Recent Posts', 'post_type' => 'all', 'categories' => 'all', 'posts' => 4, 'show_excerpt' => null);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('posts')); ?>"><?php esc_html_e('Number of posts:','association'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('posts')); ?>" name="<?php echo esc_attr($this->get_field_name('posts')); ?>" value="<?php echo esc_attr($instance['posts']); ?>" />
		</p>
		

	<?php }
}
?>