<?php get_header();  

association_count_views(get_the_ID());

$sidebar_opt = get_post_meta($post->ID, 'themnific_sidebar', true);
	
?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="container container_alt">

<div id="core">

<?php if(has_post_format('quote'))  {
	include( get_template_directory() . '/post-types/post-quote-post.php' );
	} else {?>  
      
    <div <?php post_class(); ?>  itemscope itemtype="http://schema.org/Article"> 
    
    	<div class="postbar postbar<?php echo esc_attr($sidebar_opt) ?>">
    
            <div id="content" class="eightcol first rad">
            
            	<div class="blogger aq_row">
                
            	<?php include( get_template_directory() . '/single-content.php'); ?>
                
                </div>
                   
            </div><!-- end #content -->
        
        	<?php if($sidebar_opt == 'None'){ } else { get_sidebar();} ?>
       
		</div><!-- end .sidebar_opt -->
    
    </div> 

<?php }?>
   
</div> 
   
    <?php endwhile; else: ?>
    
    <?php endif; ?>
   
<?php get_footer(); ?>