<div <?php post_class('item normal tranz'); ?>> 

<div class="item_inn tranz p-border ghost rad">

    <h2 class="posttitle"><a href="<?php association_permalink(); ?>"><?php the_title(); ?></a></h2>
        
    <div class="entryhead">
    
        <?php if (function_exists('wp_review_show_total')) wp_review_show_total(); ?>
        
        <div class="imgwrap">
        
        <?php echo association_icon();?>
            
		<?php 	
        
            $themnific_redux = get_option( 'themnific_redux' );
            $single_featured = get_post_meta($post->ID, 'themnific_single_featured', true);
        
            if(has_post_format('video')){
        
                include( get_template_directory() . '/functions/theme-video.php');
            
            }elseif(has_post_format('audio')){
            } else {
                if($themnific_redux['post-image-dis'] == '1');
                else{
                   
                    if ($single_featured == 'No')  {
                    } else { ?>
                        
                            <?php the_post_thumbnail('association_classic',array('class' => 'standard grayscale grayscale-fade'));  ?>
                        
                        <?php }; 
                    
                }
            }
            
        ?>
        
        </div>
    
    </div><!-- end .entryhead -->
                
    <div class="meta_full_wrap p-border ghost <?php $themnific_redux = get_option( 'themnific_redux' ); if($themnific_redux['post-meta-dis'] == '1') echo 'association_hide' ?>">
    
        <?php association_meta_full();  association_meta_cat(); ?>
     
    </div>
    
    <div class="entry">
    
        <?php
        
            the_content(); 
            
            wp_link_pages( array( 'before' => '<div class="page-link"><span>' . esc_html__( 'Pages:','association') . '</span>', 'after' => '</div>' ) );
        
        ?>
        
        <div class="clearfix"></div>
        
    </div><!-- end .entry -->

    <?php 
    
        include( get_template_directory() . '/single-info.php');
        
        include( get_template_directory() . '/includes/mag-postad.php');
        
        comments_template(); 
        
    ?>
    
</div><!-- end .item_inn -->
    
</div><!-- end .item -->