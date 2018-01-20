<div id="post-nav">
    <?php $prevPost = get_previous_post(true);// false = all categories
        if($prevPost) {
            $args = array(
                'posts_per_page' => 1,
                'include' => $prevPost->ID
            );
            $prevPost = get_posts($args);
            foreach ($prevPost as $post) {
                setup_postdata($post);
    ?>
        <div class="post-previous item tranz">
            <a class="previous" href="<?php association_permalink(); ?>"><small><?php esc_html_e('Previous Story','association');?></small><br/><?php the_title(); ?> </a>
            <a href="<?php association_permalink(); ?>"><?php the_post_thumbnail('association_folio',array('class' => "grayscale grayscale-fade")); ?></a>
            <i class="fa fa-chevron-left"></i>
        </div>
    <?php
                wp_reset_postdata();
            } //end foreach
        } // end if
         
        $nextPost = get_next_post(true);// false = all categories
        if($nextPost) {
            $args = array(
                'posts_per_page' => 1,
                'include' => $nextPost->ID
            );
            $nextPost = get_posts($args);
            foreach ($nextPost as $post) {
                setup_postdata($post);
    ?>
        <div class="post-next item tranz">
            <a class="next" href="<?php association_permalink(); ?>"><small><?php esc_html_e('Next Story','association');?></small><br/><?php the_title(); ?></a>
            <a href="<?php association_permalink(); ?>"><?php the_post_thumbnail('association_folio',array('class' => "grayscale grayscale-fade")); ?></a>
             <i class="fa fa-chevron-right"></i>
        </div>
    <?php
                wp_reset_postdata();
            } //end foreach
        } // end if
    ?>
</div>