<?php get_header();
$themnific_redux = get_option( 'themnific_redux' );?>
	
	<div class="page-header p-border">

		<?php if(empty($themnific_redux['tmnf-header-image']['url'])) {} else { ?>
            
                <img class="page-header-img" src="<?php echo esc_url($themnific_redux['tmnf-header-image']['url']);?>" alt="<?php the_title(); ?>"/>
                
        <?php }  ?>
          
          <div class="titlewrap container">
          
              	<h1 class="entry-title dekoline" itemprop="headline"><?php echo esc_attr($s); ?><br/>
    			<span><?php esc_html_e('Search Results','association');?> </span></h1>
    
          </div>
          
     </div>


<div class="container container_alt">

<div id="core">
                        
	<div id="content" class="eightcol first">

          		<div class="blogger index_blogger aq_row">
              
                    <?php if ( have_posts() ) : ?>	
                                            
                         <?php while ( have_posts() ) : the_post(); ?>
                    
                                <?php include( get_template_directory() .  '/post-types/blog-classic.php'); ?>
                                
                         <?php endwhile; ?>
                         
                    <?php else : ?>
    
                        <div class="post item ghost">
                        
                        	<div class="item_inn f-border">
                                    
                                <div class="entry errorentry">
                            
                                	<h1 class="post entry-title"><?php esc_html_e('Sorry, no posts matched your criteria.','association');?></h1>
                                
									<?php get_search_form(); ?><br/>
                                    
                                    <h5><?php esc_html_e('Perhaps You will find something interesting from these lists...','association');?></h5>
                                    
                                    <?php include( get_template_directory() . '/includes/uni-404-content.php');?>
                                        
                                </div>
                                
                        	</div>
                                
                        </div>
                    
                    
                    <?php endif; ?>
                        
                </div><!-- end .blogger-->
                
                <div class="clearfix"></div>
                                
                <div class="pagination"><?php association_pagination('&laquo;', '&raquo;'); ?></div>
        
        </div><!-- end #content -->
        
       	<?php get_sidebar(); ?>
    
	<div class="clearfix"></div>
    
    </div><!-- end #core-->

<?php get_footer(); ?>