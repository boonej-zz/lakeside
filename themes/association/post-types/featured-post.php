

  <?php if ( has_post_thumbnail()) : ?>
  
       <a class="alink" href="<?php association_permalink(); ?>" title="<?php the_title(); ?>" >
       
       		<?php echo association_icon();?>
       
          	<?php the_post_thumbnail( 'association_tabs',array('class' => "tranz grayscale grayscale-fade")); ?>
          
       </a>
       
  <?php endif; ?>

<div class="fea-post item">
      
  <h4><a href="<?php association_permalink(); ?>" title="<?php the_title(); ?>"><?php echo the_title(); ?></a></h4>
  
  
                        
   <?php association_meta_cat()?>
   
   <p class="teaser"><?php echo association_excerpt( get_the_excerpt(), '130'); ?></p>
   
   <?php association_meta_more()?>

</div>