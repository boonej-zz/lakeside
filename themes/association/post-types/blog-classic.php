          	<div <?php post_class('item normal tranz'); ?>>
    
            	<div class="item_inn p-border tranz ghost">
                        
                    <div class="entryhead">
                    
                        <?php if (function_exists('wp_review_show_total')) wp_review_show_total(); ?>
                        
                        <div class="imgwrap">
                        
                        <?php echo association_icon();?>
                            
                        <?php 	
                        
                            $themnific_redux = get_option( 'themnific_redux' );	
                            $single_featured = get_post_meta(get_the_ID(), 'themnific_single_featured', true);
                        
                            if($themnific_redux['post-image-dis'] == '1');
                                else{
                                   
                                    if ($single_featured == 'No')  {
                                    } else { ?>
                                        <a href="<?php association_permalink(); ?>">
                                            <?php the_post_thumbnail('association_blog',array('class' => 'standard grayscale grayscale-fade'));  ?>
                                        </a>
                                        <?php }; 
                            }
                            
                        ?>
                        
                        </div>
                    
                    </div><!-- end .entryhead -->
        
                    <h2 class="posttitle"><a href="<?php association_permalink(); ?>"><?php the_title(); ?></a></h2> 

					<div class="entry">
                    
						 <p class="teaser"><span class="date"><?php the_time(get_option('date_format')); ?></span> <?php echo association_excerpt( get_the_excerpt(), '190'); ?><span class="hellip">...</span></p>
                    
                    	<?php association_meta_more(); ?>
                    	
                    </div>
                
                </div><!-- end .item_inn -->
                
                <div class="meta_full_wrap p-border ghost">
                
					<?php 
                    echo '<p class="meta_full meta">';
                    echo get_avatar( get_the_author_meta('ID'), '25' );
                    esc_html_e('Written by:','association'); 
                    the_author_posts_link();
                    echo '</p>';
                    ?>
                
                 	<?php association_meta_full(); ?>
                 
                </div>
        
            </div>