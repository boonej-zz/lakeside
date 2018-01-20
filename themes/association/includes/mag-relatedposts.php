			<h3 class="uppercase"><?php esc_html_e('Related Posts','association');?></h3>
            <ul class="related">
				
			<?php
			$backup = $post;
			$tags = wp_get_post_tags($post->ID);
			if ($tags) { $tag_ids = array();
				foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

				$args=array(
					'tag__in' => $tag_ids,
					'post__not_in' => array($post->ID),
					'showposts'=>3, // Number of related posts that will be shown.
					'ignore_sticky_posts'=>1
				);
				$my_query = new wp_query($args);
				if( $my_query->have_posts() ) { echo ''; while ($my_query->have_posts()) { $my_query->the_post();if(has_post_format('aside')){ } else {
			?>
            <li class="item">
                        
				<?php if ( has_post_thumbnail()) : ?>
            	
                	<?php echo association_icon();?>
                
                     <a href="<?php association_permalink(); ?>" title="<?php the_title();?>" >
                     
                            <?php the_post_thumbnail( 'association_folio4',array('class' => "grayscale grayscale-fade")); ?>
                            
                     </a>
                     
                <?php endif; ?>
                    
                <h4><a href="<?php association_permalink(); ?>" title="<?php the_title(); ?>"><?php echo the_title(); ?></a></h4>

			</li>
			<?php }
					}
					echo '';
				}
			}
			$post = $backup;
			wp_reset_postdata(); 
			?>
		</ul>
		<div class="clearfix"></div>