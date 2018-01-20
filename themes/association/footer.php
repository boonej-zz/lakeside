
</div><!-- /.container -->

	<div id="footer_fix"></div>

       <div id="footer">
        
            <div class="container woocommerce"> 
            
            	<div class="footerhead"> 
            
					<?php $themnific_redux = get_option( 'themnific_redux' ); if(empty($themnific_redux['footer-logo']['url'] )) {  } 
                            
                        else { ?>
                                    
                            <a class="logo" href="<?php echo esc_url(home_url('/')); ?>/">
                            
                                <img class="tranz" src="<?php echo esc_url($themnific_redux['footer-logo']['url']);?>" alt="<?php bloginfo('name'); ?>"/>
                                    
                            </a>
                            
                    <?php } ?>
                    
                    <?php if($themnific_redux['tmnf-footer-text']) { echo '<h2 class="description clearfix">'. esc_attr($themnific_redux['tmnf-footer-text']). '</h2>'; } ?>
                    
                    <?php if ( function_exists('has_nav_menu') && has_nav_menu('bottom-menu') ) {wp_nav_menu( array( 'depth' => 1, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_class' => 'bottom-menu', 'menu_id' => '' , 'theme_location' => 'bottom-menu') );}  ?>
            	
                </div><!-- /.footerhead -->

                
            	<div class="clearfix"></div>
            
                <?php include( get_template_directory() . '/includes/uni-bottombox.php');?>
                
                <div class="clearfix"></div>
        
                <div id="copyright">
                    
                        <?php $themnific_redux = get_option( 'themnific_redux' );if(empty($themnific_redux['tmnf-footer-editor'])){} else { echo '<p>' . esc_html($themnific_redux['tmnf-footer-editor']).'</p>'; } ?>
                          
                </div> 
            
            </div>
                
        </div><!-- /#footer  -->
    
</div><!-- /.wrapper  -->

<div id="curtain" class="tranz">
	
	<?php get_search_form();?>
    
    <a class='curtainclose rad' href="#" ><i class="fa fa-times"></i></a>
    
</div>
    
<div class="scrollTo_top ribbon rad">

    <a title="Scroll to top" href="#">
    
    	<i class="fa fa-chevron-up"></i> 
        
    </a>
    
</div>

<?php wp_footer(); ?>

</body>
</html>