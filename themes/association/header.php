<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head><meta charset="<?php bloginfo( 'charset' ); ?>">

<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>

</head>

     
<body <?php body_class(); ?>>

<div class="wrapper <?php 
	$themnific_redux = get_option( 'themnific_redux' ); 
	if($themnific_redux['tmnf-uppercase'] == '1') echo 'upper ';

?>">

    <div id="header" class="tranz" itemscope itemtype="http://schema.org/WPHeader">
    
        <div class="container_alt">
        
        	<div class="header_inn boxshadow">
            
            	<div class="above-nav">
        
					<?php if($themnific_redux['tmnf-tagline'] == ''){echo'';} else { echo '<h2 class="tagline rad tranz">', esc_attr($themnific_redux['tmnf-tagline']),'</h2>' ;} ?>
                    
                    <a title="<?php esc_html_e('Search The Site','association');?>" class="searchtrigger" href="#" ><i class="fa fa-search"></i></a>
                    
                    <?php include( get_template_directory() . '/includes/uni-social.php');?>
                    
                    <span class="header-hr"></span>
                
                </div>
        
                <div class="clearfix"></div>
                
                <div id="titles" class="header-left tranz">
                    
                    <?php if(empty($themnific_redux['tmnf-main-logo']['url'])) { ?>
                        
                        <h1><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name');?></a></h1>
                            
                    <?php } 
                            
                        else { ?>
                                    
                            <a class="logo" href="<?php echo esc_url(home_url('/')); ?>">
                            
                                <img class="tranz" src="<?php echo esc_url($themnific_redux['tmnf-main-logo']['url']);?>" alt="<?php bloginfo('name'); ?>"/>
                                    
                            </a>
                            
                    <?php } ?>	
                
                </div><!-- end #titles  -->	
                    
                <a id="navtrigger" class="rad" href="#"><i class="fa fa-bars"></i></a>
    
                <div class="header-right">
                    
                    <nav id="navigation" class="rad tranz" itemscope itemtype="http://schema.org/SiteNavigationElement"> 
                    
                        <?php include( get_template_directory() . '/includes/mag-navigation.php'); ?>
                        
                    </nav>
                    
                    <div class="clearfix"></div>
                
                </div>
            
                <div class="clearfix"></div>
        
        	</div><!-- end .header_inn  -->
            
        </div><!-- end .container  -->
              
    </div><!-- end #header  -->