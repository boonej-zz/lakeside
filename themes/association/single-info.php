<div class="postinfo">    

<?php	

	$themnific_redux = get_option( 'themnific_redux' );
	the_tags( '<p class="taggs"><i class="icon-tag-empty"></i> ', ' ', '</p><div class="clearfix"></div>');

	// author
	if($themnific_redux['post-author-dis'] == '1');
	else {
	get_template_part('/includes/mag-authorinfo','single');
	echo '';}
	

	// prev/next	
	if($themnific_redux['post-nextprev-dis'] == '1');
	else {
	get_template_part('/includes/mag-nextprev','single');
	echo '<div class="clearfix"></div>';}


	// related
	if($themnific_redux['post-related-dis'] == '1');
	else {
	get_template_part('/includes/mag-relatedposts','single');}

	
?>
            
</div>

<div class="clearfix"></div>
 			
            

                        
