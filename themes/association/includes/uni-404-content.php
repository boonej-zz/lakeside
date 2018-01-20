		<div class="sixcol first">

                <h3><?php esc_html_e('Pages','association');?></h3>

                <ul class="error"><?php wp_list_pages("title_li=&depth=2"); ?></ul>

            </div>
            
          	<div class="sixcol">
            
               	<h3><?php esc_html_e('Categories','association');?></h3>
                
				<ul class="error"><?php wp_list_categories("title_li=&depth=2"); ?></ul>
                
            </div>            

            <div class="hrlineB"></div>

                <h3><?php esc_html_e('All Blog Posts','association');?>:</h3>

                <ul><?php $archive_query = new WP_Query('showposts=1000');
while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?>

                        </a>
                    </li>

                    <?php endwhile; ?>
                </ul>