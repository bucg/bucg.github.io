<?php
/**
 * Template: Header.php 
 *
 * @package EvoLve
 * @subpackage Template
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!--BEGIN html-->
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>


<!--BEGIN head-->
<head profile="<?php evlget_profile_uri(); ?>">

	<title><?php wp_title('-', true); ?></title>

	<!-- Meta Tags -->
	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php wp_head(); ?>     
 
<!--END head-->  
</head>



<!--BEGIN body-->
<body <?php body_class(); ?>>

<?php $evl_custom_background = evl_get_option('evl_custom_background','1'); if ($evl_custom_background == "1") { ?>
<div id="wrapper">
<?php } ?>

<div id="top"></div>





	<!--BEGIN .header-->
		<div class="header">
    
    
	<!--BEGIN .container-->
	<div class="container container-header custom-header">
  
  
  <?php $evl_social_links = evl_get_option('evl_social_links','1'); if ( $evl_social_links == "1" ) { ?>
  
      <!--BEGIN #righttopcolumn-->  
  <div id="righttopcolumn"> 
                       
   <!--BEGIN #subscribe-follow-->
 
<div id="social">
<?php get_template_part('social-buttons', 'header'); ?></div> 

<!--END #subscribe-follow--> 
       
</div> 
  <!--END #righttopcolumn-->
  
  <?php } ?>
 
 <?php $evl_pos_logo = evl_get_option('evl_pos_logo','left'); if ($evl_pos_logo == "disable") { ?> 
  
  <?php } else { ?>
  
   <?php $evl_header_logo = evl_get_option('evl_header_logo', '');
    if ($evl_header_logo) {
        echo "<a href=".home_url()."><img id='logo-image' class='img-responsive' src=".$evl_header_logo." /></a>";
    }
      ?>   
     
     <?php } ?> 
     
     
      <?php 
       
     $tagline = '<div id="tagline">'.get_bloginfo( 'description' ).'</div>';
     
     $evl_tagline_pos = evl_get_option('evl_tagline_pos','next');
     
     if (($evl_tagline_pos !== "disable") && ($evl_tagline_pos == "above")) { 
 
     
     echo $tagline;
      
     } ?>
     
     
     <?php $evl_blog_title = evl_get_option('evl_blog_title','0'); if ($evl_blog_title == "0") { ?>
     
     <div id="logo"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ) ?></a></div>
     
          
     <?php } else { ?>			
      
      <?php } if (($evl_tagline_pos !== "disable") && (($evl_tagline_pos == "") || ($evl_tagline_pos == "next") || ($evl_tagline_pos == "under")))    
      {
			echo $tagline;
      
      } ?>

	<!--END .container-->
		</div>
    
    

    
    		<!--END .header-->
		</div>
    
    
    
  
  <div class="menu-container">
  
  
  
      <?php $evl_menu_background = evl_get_option('evl_disable_menu_back','1'); $evl_width_layout = evl_get_option('evl_width_layout','fixed'); if ( $evl_width_layout == "fluid" && $evl_menu_background == "1" ) { ?>
    
    <div class="fluid-width">
    
    <?php } ?>
  
  
  <div class="menu-header">  
  
  <!--BEGIN .container-menu-->
  <div class="container nacked-menu container-menu">

     <?php $evl_main_menu = evl_get_option('evl_main_menu','0'); if ($evl_main_menu == "1") { ?>
    <br /><br />
    
   <?php } else { ?>
   
   <div class="primary-menu">   
 <?php 
 
if ( has_nav_menu( 'primary-menu' ) ) { 
echo '<nav id="nav" class="nav-holder link-effect">';
 wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'nav-menu','fallback_cb' => 'wp_page_menu', 'walker' => new evolve_Walker_Nav_Menu() ) );
 } else { 
echo '<nav id="nav" class="nav-holder">';
wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'nav-menu','fallback_cb' => 'wp_page_menu') );} 
 ?>   
   </nav>  
   </div>      
       
  
  <?php $evl_searchbox = evl_get_option('evl_searchbox','1'); if ( $evl_searchbox == "1" ) { ?>
          
          <!--BEGIN #searchform-->
       <form action="<?php echo home_url(); ?>" method="get" class="searchform">         
         <div id="search-text-box">
  <label class="searchfield" id="search_label_top" for="search-text-top"><input id="search-text-top" type="text" tabindex="1" name="s" class="search" placeholder="<?php _e( 'Type your search', 'evolve' ); ?>" /></label> 
  </div>        
</form>

<div class="clearfix"></div> 

<!--END #searchform-->

<?php } ?>
            
          
          
          

<?php $evl_sticky_header = evl_get_option('evl_sticky_header','1'); if ( $evl_sticky_header == "1" ) {          

	// sticky header
		get_template_part('sticky-header');

	}	?>          
          
      
       
       <?php } ?>
       
       
             
       
       
       
       </div>
       
    </div>
          	
	<div class="menu-back">
  
                     

          <?php $evl_width_layout = evl_get_option('evl_width_layout','fixed'); if ( $evl_width_layout == "fluid" ) { ?>
    
    <div class="container">
    
    <?php } ?>
    
 	<?php $evl_slider_page_id = ''; $evl_bootstrap = evl_get_option('evl_bootstrap_slider','homepage');
	if(!is_home() && !is_front_page() && !is_archive()) {
		$evl_slider_page_id = $post->ID;
	}
	if(!is_home() && is_front_page()) {
		$evl_slider_page_id = $post->ID;
	}
	if(is_home() && !is_front_page()){
		$evl_slider_page_id = get_option('page_for_posts');
	}
	
	if(get_post_meta($evl_slider_page_id, 'evolve_slider_type', true) == 'bootstrap' || ($evl_bootstrap == "homepage" && is_front_page()) || $evl_bootstrap == "all" ):
     
  evolve_bootstrap();
       
  endif; ?>     
    
    
 	<?php $evl_slider_page_id = ''; $evl_parallax = evl_get_option('evl_parallax_slider','post');
	if(!is_home() && !is_front_page() && !is_archive()) {
		$evl_slider_page_id = $post->ID;
	}
	if(!is_home() && is_front_page()) {
		$evl_slider_page_id = $post->ID;
	}
	if(is_home() && !is_front_page()){
		$evl_slider_page_id = get_option('page_for_posts');
	}
	
	if(get_post_meta($evl_slider_page_id, 'evolve_slider_type', true) == 'parallax' || ($evl_parallax == "homepage" && is_front_page()) || $evl_parallax == "all" ):

  $evl_parallax_slider = evl_get_option('evl_parallax_slider_support', '1'); 

  if ($evl_parallax_slider == "1"):
  
  evolve_parallax();
  
  endif;
  
  endif; ?> 
  
  
  <?php $evl_posts_slider = evl_get_option('evl_posts_slider','post');
  
  if(get_post_meta($evl_slider_page_id, 'evolve_slider_type', true) == 'posts' || ($evl_posts_slider == "homepage" && is_front_page()) || $evl_posts_slider == "all" ):
  
  
  $evl_carousel_slider = evl_get_option('evl_carousel_slider', '1');
  
  if ($evl_carousel_slider == "1"):
  
  evolve_posts_slider(); 
  
  endif; 
  
  endif; ?>       
       


 <?php $evl_header_widgets_placement = evl_get_option('evl_header_widgets_placement', 'home');           
        
 if (((is_home() || is_front_page()) && $evl_header_widgets_placement == "home") || (is_single() && $evl_header_widgets_placement == "single") 
 
 || (is_page() && $evl_header_widgets_placement == "page") || ($evl_header_widgets_placement == "all")) { ?>
        
  
  
        
        
          <?php $evl_widgets_header = evl_get_option('evl_widgets_header','disable');

// if Header widgets exist

  if (($evl_widgets_header == "") || ($evl_widgets_header == "disable"))  
{ } else { ?>


<?php 

$evl_header_css = '';

if ($evl_widgets_header == "one") { $evl_header_css = 'widget-one-column col-sm-6'; }

if ($evl_widgets_header == "two") { $evl_header_css = 'col-sm-6 col-md-6'; }

if ($evl_widgets_header == "three") { $evl_header_css = 'col-sm-6 col-md-4'; }

if ($evl_widgets_header == "four") { $evl_header_css = 'col-sm-6 col-md-3'; }

?>
    
    <div class="container"> 
  <div class="widgets-back-inside row">  
  
    <div class="<?php echo $evl_header_css; ?>">
    	<?php	if ( !dynamic_sidebar( 'header-1' )) : ?>
      <?php endif; ?>
      </div> 
  
     <div class="<?php echo $evl_header_css; ?>"> 
      <?php	if ( !dynamic_sidebar( 'header-2' ) ) : ?>
      <?php endif; ?>
      </div>

    <div class="<?php echo $evl_header_css; ?>">  
	    <?php	if ( !dynamic_sidebar( 'header-3' ) ) : ?>
      <?php endif; ?>
      </div>   
 
    <div class="<?php echo $evl_header_css; ?>">  
    	<?php	if ( !dynamic_sidebar( 'header-4' ) ) : ?>
      <?php endif; ?>
      </div>
    
    </div>
    </div> 

   
     <?php } ?>
     
     <?php } else {} ?>

      
      </div>
      
    
      
      </div> 
      
    
      
      
         <?php $evl_width_layout = evl_get_option('evl_width_layout','fixed'); if ( $evl_width_layout == "fluid" ) { ?>
         
         </div>
     
   <?php } ?>        
       
             	<!--BEGIN .content-->
	<div class="content <?php semantic_body(); ?>">  
  
  <?php if (is_page_template('contact.php')): ?>
  <div class="gmap" id="gmap"></div>
  <?php endif; ?>
  
       	<!--BEGIN .container-->
	<div class="container container-center row">
  
		<!--BEGIN #content-->
		<div id="content">
    
    
  <?php if (is_home() || is_front_page()) { 
  
  evolve_content_boxes();  
  
  } ?>