<div class="item p-border">

  <?php if ( has_post_thumbnail()) : ?>
  
       <a class="alink" href="<?php association_permalink(); ?>" title="<?php the_title(); ?>" >
       
       		<?php echo association_icon();?>
       
          	<?php the_post_thumbnail( 'association_tabs',array('class' => "tranz grayscale grayscale-fade")); ?>
          
       </a>
       
  <?php endif; ?>
      
  <h4><a href="<?php association_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
   
   <p class="teaser"><span class="date"><?php the_time(get_option('date_format')); ?></span> <?php echo association_excerpt( get_the_excerpt(), '80'); ?><span class="hellip">...</span></p>

</div>