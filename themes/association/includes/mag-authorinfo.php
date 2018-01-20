		<?php 
		$user_description = get_the_author_meta( 'user_description', $post->post_author );
		if ( ! empty( $user_description ) ) { ?>
        <div class="postauthor vcard author rad" itemscope itemtype="http://data-vocabulary.org/Person">

        <?php 
		echo '<p class="authorline p-border">';
		echo get_avatar( get_the_author_meta('ID'), '30' );
		esc_html_e('Written by:','association'); 
		the_author_posts_link();
		echo '</p>';
		?>
 			<div class="authordesc"><?php the_author_meta('description'); ?></div>
            
		</div>
		<div class="clearfix"></div>
        <?php }  ?>