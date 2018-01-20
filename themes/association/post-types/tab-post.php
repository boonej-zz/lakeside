<div class="tab-post item p-border">

<?php if (function_exists('wp_review_show_total')) wp_review_show_total(); ?>

  <?php if ( has_post_thumbnail()) : ?>
  
       <a href="<?php association_permalink(); ?>" title="<?php the_title(); ?>" >
       
          <?php the_post_thumbnail( 'association_tabs'); ?>
          
       </a>
       
  <?php endif; ?>
      
  <h4><a href="<?php association_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
  
  <p class="meta"><?php echo association_icon() ?></p>
  
  <?php association_meta_date();?>

</div>