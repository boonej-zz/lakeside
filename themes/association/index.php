<?php get_header();
$themnific_redux = get_option( 'themnific_redux' );?>
	
	<div class="page-header p-border">

		<?php if(empty($themnific_redux['tmnf-header-image']['url'])) {} else { ?>
            
                <img class="page-header-img" src="<?php echo esc_url($themnific_redux['tmnf-header-image']['url']);?>" alt="<?php the_title(); ?>"/>
                
        <?php }  ?>
          
          <div class="titlewrap container">
          
              <h1 class="uppercase"><?php esc_html_e('News','association');?></h1>
    
          </div>
          
     </div>

      

<div class="container">

<div id="core" class="index_blogger postbarLeft">
                        
	<div id="content" class="eightcol first">

          <div class="blogger aq_row">
          
                	<?php
						if ( get_query_var('paged') ) {
							$paged = get_query_var('paged');
						} else if ( get_query_var('page') ) {
							$paged = get_query_var('page');
						} else {
							$paged = 1;
						}
						query_posts( array( 'post_type' => 'post', 'paged' => $paged ) );
					?>
					<?php if (have_posts()) : ?>
                    
                    <?php  while ( have_posts() ) : the_post(); ?>
            
						<?php get_template_part('/post-types/blog-classic'); ?>
					
					<?php endwhile; ?>
                    
           	</div><!-- end latest posts section-->
            
            <div class="clearfix"></div>

					<div class="pagination"><?php association_pagination('&laquo;', '&raquo;'); ?></div>

					<?php else : ?>
			

                        <h1>Sorry, no posts matched your criteria.</h1>
                        <?php get_search_form(); ?><br/>
					<?php endif; ?>
    
    </div><!-- end #content -->
    
    <?php get_sidebar(); ?>
    
	<div class="clearfix"></div>
        
</div><!-- end #core -->

<div class="clearfix"></div>

<?php get_footer(); ?>