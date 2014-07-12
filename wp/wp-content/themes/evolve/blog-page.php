<?php
/**
 * Template Name: Blog
 *
 * @package EvoLve
 * @subpackage Template
 */

get_header();
$first = "";
?>


       <?php 
       
       global $authordata;
       $xyz = ""; 
       $options = get_option('evolve'); 
 		   $evl_layout = evl_get_option('evl_layout','2cl'); 
	     $evl_post_layout = evl_get_option('evl_post_layout','two');  
 		   $evl_nav_links = evl_get_option('evl_nav_links','after'); 
 		   $evl_header_meta = evl_get_option('evl_header_meta','single_archive'); 
       $evl_excerpt_thumbnail = evl_get_option('evl_excerpt_thumbnail','0'); 
	     $evl_share_this = evl_get_option('evl_share_this','single'); 
 	     $evl_post_links = evl_get_option('evl_post_links','after'); 
 	     $evl_similar_posts = evl_get_option('evl_similar_posts','disable'); 
       
       if ($evl_layout == "1c") {  
       $imagewidth = "960";
       } elseif ($evl_layout == "2cl" || $evl_layout == "2cr") {
	     $imagewidth = "620";
       } else {
       $imagewidth = "506";
       }
 
 		  if (($evl_layout == "1c"))    
  
    { ?>
  
  
  <?php } else { ?>

  <?php $options = get_option('evolve');
  
  if(get_post_meta($post->ID, 'evolve_full_width', true) == 'yes'):
  
  else:
  
  if (($evl_layout == "3cm" || $evl_layout == "3cl" || $evl_layout == "3cr")) { ?>   
  
  <?php get_sidebar('2'); ?>
  
  
  <?php } ?>
  
  <?php endif; ?>
  
    <?php } ?>

		<?php get_template_part( 'content', 'blog' ); ?>
      
      
 <?php  
   if (($evl_layout == "1c"))  
  
  
    { ?>
  
  
  <?php } else { ?>


<?php wp_reset_query(); if(get_post_meta($post->ID, 'evolve_full_width', true) == 'yes'):
  
  else:       

get_sidebar(); 

endif; ?>

    <?php } ?>

<?php get_footer(); ?>

