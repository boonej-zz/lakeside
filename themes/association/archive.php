<?php get_header();
$themnific_redux = get_option( 'themnific_redux' );?>
	
	<div class="page-header p-border">

		<?php if(empty($themnific_redux['tmnf-header-image']['url'])) {} else { ?>
            
                <img class="page-header-img" src="<?php echo esc_url($themnific_redux['tmnf-header-image']['url']);?>" alt="<?php the_title(); ?>"/>
                
        <?php }  ?>
          
          <div class="titlewrap container">
    
    	    <?php if (is_category()) { ?>
    			<h1 class="entry-title dekoline"><?php single_cat_title(); ?><br/>
    			<span><?php echo category_description(); ?> </span></h1>     
        
            <?php } elseif (is_day()) { ?>
            
    			<h1 class="entry-title dekoline"><?php the_time( get_option( 'date_format' ) ); ?><br/>
    			<span><?php esc_html_e('Archive','association');?></span></h1>  

            <?php } elseif (is_month()) { ?>
            
    			<h1 class="entry-title dekoline"><?php the_time( 'F, Y' ); ?><br/>
    			<span><?php esc_html_e('Archive','association');?></span></h1>  

            <?php } elseif (is_year()) { ?>
            
    			<h1 class="entry-title dekoline"><?php the_time( 'Y' ); ?><br/>
    			<span><?php esc_html_e('Archive','association');?></span></h1>  

            <?php } elseif (is_author()) { ?>
            
    			<h1 class="entry-title dekoline"><?php  $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); echo esc_attr($curauth->nickname);?><br/>
                <span><?php esc_html_e( 'Author','association' ); ?></span></h1> 
                
            <?php } elseif (is_tag()) { ?>
            
    			<h1 class="entry-title dekoline"><?php echo single_tag_title( '', true); ?><br/>
    			<span><?php esc_html_e('Tag Archive','association');?></span></h1>  
            
            <?php } ?>
		
          </div>
          
     </div>


<div class="container container_alt">

	<div id="core" class="index_blogger postbarLeft">

	<div id="content" class="eightcol first">

          <div class="blogger index_blogger aq_row">
          
                <?php if ( have_posts() ) : ?>	
                                    
                 <?php while ( have_posts() ) : the_post(); ?>
            
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
    
    </div><!-- end #core-->

<div class="clearfix"></div>

<?php get_footer(); ?>