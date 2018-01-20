<?php get_header();
$themnific_redux = get_option( 'themnific_redux' );?>

<?php if ( has_post_thumbnail()){ ?>
      
      
    <div class="page-header p-border">
    
		<?php the_post_thumbnail('association_slider',array('class' => 'standard grayscale grayscale-fade'));?>
        
        <div class="titlewrap container">
        
            <h1 class="entry-title dekoline"><?php the_title(); ?></h1>
              
              <div class="page-crumbs">
                  <?php association_breadcrumbs()?>
              </div>
      
        </div>
      
    </div>
    

<?php } else { ?>
	
	<div class="page-header p-border">

		<?php if(empty($themnific_redux['tmnf-header-image']['url'])) {} else { ?>
            
                <img class="page-header-img" src="<?php echo esc_url($themnific_redux['tmnf-header-image']['url']);?>" alt="<?php the_title(); ?>"/>
                
        <?php }  ?>
          
          <div class="titlewrap container">
          
              <h1 class="entry-title dekoline"><?php the_title(); ?></h1>
              
              <div class="page-crumbs">
                  <?php association_breadcrumbs()?>
              </div>
    
          </div>
          
      </div>

      
<?php } ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


<div class="container container_alt">

<div id="core">

<div class="postbarLeft">

    <div id="content" class="eightcol first">
    
		<div <?php post_class(); ?>>
        
        	<div class="item_inn tranz p-border ghost">

                <div class="entry pageentry">
                    
                    <?php the_content(); ?>
                    
                    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . esc_html__( 'Pages:','association') . '</span>', 'after' => '</div>' ) ); ?>
                    
                    <?php the_tags( '<p class="tagssingle">','',  '</p>'); ?>
                        
                	<div class="clearfix"></div> 
                  
                	<?php comments_template(); ?>
                
                </div>       
            
            </div><!-- .item_inn tranz p-border ghost -->
            
		</div>


	<?php endwhile; else: ?>

		<p><?php esc_html_e('Sorry, no posts matched your criteria','association');?>.</p>

	<?php endif; ?>

                <div class="clearfix"></div>

	</div><!-- #content -->

	<div id="sidebar"  class="fourcol woocommerce">
    
    	<?php if ( is_active_sidebar( 'tmnf-sidebar-pages' ) ) { ?>
        
            <div class="widgetable">
    
                <?php dynamic_sidebar('tmnf-sidebar-pages') ?>
            
            </div>
            
		<?php } ?>
        
    </div><!-- #sidebar --> 
    
</div><!-- .postbarLeft -->

</div>

<?php get_footer(); ?>