<?php get_header(); 
$themnific_redux = get_option( 'themnific_redux' );?>
	
<div class="page-header p-border">

  <?php if(empty($themnific_redux['tmnf-header-image']['url'])) {} else { ?>
      
          <img class="page-header-img" src="<?php echo esc_url($themnific_redux['tmnf-header-image']['url']);?>" alt="<?php the_title(); ?>"/>
          
  <?php }  ?>
    
    <div class="titlewrap container">
    
        <h1 class="entry-title dekoline"><?php esc_html_e( (is_product_category()) ? single_cat_title( '', true ) : "Shop",'association');?></h1>

    </div>
    
</div>

<div class="container top-fix postbarLeft woo-tmnf">

	<div id="content" class="eightcol first">
     
     	<div id="woo-inn" class="ghost">
    
			<?php woocommerce_content(); ?>
            
        </div>    

	</div><!-- #content -->
    
     <div id="sidebar"  class="fourcol woocommerce woocommerce-sidebar">
    
    	<?php if ( is_active_sidebar( 'tmnf-shop-sidebar' ) ) { ?>
        
            <div class="widgetable">
            
                <div class="sidewrap">
    
                <?php dynamic_sidebar("tmnf-shop-sidebar") ?>
                
                </div>
            
            </div>
        
        <?php } ?>
           
    </div><!-- #sidebar -->

<?php get_footer(); ?>