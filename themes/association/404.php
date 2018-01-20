<?php get_header();
$themnific_redux = get_option( 'themnific_redux' );?>
	
<div class="page-header p-border">

    <?php if($themnific_redux['tmnf-header-image']['url']) { ?>
        
            <img class="page-header-img" src="<?php echo esc_url($themnific_redux['tmnf-header-image']['url']);?>" alt="<?php the_title(); ?>"/>
            
    <?php }  ?>
      
      <div class="titlewrap container">
      
          <h1 class="entry-title dekoline" itemprop="headline"><?php esc_html_e('Nothing found here','association');?></h1>

      </div>
      
  </div>

<div class="container container_alt error404 postbarLeft">

	<div id="core">

    	<div id="content" class="eightcol first">
        
        	<div class="page">
            
                <div class="item_inn tranz p-border ghost">
                
                    <div class="pageentry errorentry entry">
                    
                    	<h5><?php esc_html_e('Perhaps You will find something interesting from these lists...','association');?></h5>
                        
                        <?php include( get_template_directory() . '/includes/uni-404-content.php');?>
                    
                    </div>
                    
                </div><!-- .item_inn tranz p-border ghost -->
            
            </div>
            
    	</div><!-- #content -->

		<?php get_sidebar();?>
        
	</div>
    
<?php get_footer(); ?>