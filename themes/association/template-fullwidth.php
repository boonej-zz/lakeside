<?php
/*
Template Name: Full Width
*/
?>
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

<div class="container full-width">

    <div id="core">
            
        <div class="entry entryfull">
            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <?php the_content(); ?>
            
            <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . esc_html__( 'Pages:','association') . '</span>', 'after' => '</div>' ) ); ?>
            
            <?php endwhile; endif; ?>
            
        </div>
    
    <div class="clearfix"></div>
    
    </div>

</div>
    
<?php get_footer(); ?>