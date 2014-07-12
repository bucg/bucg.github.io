<?php 
  
/* Theme Setup Functions */   
  
function evolve_after_setup() {

add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' ); 
add_image_size( 'post-thumbnail', 680, 330, true );
add_image_size( 'slider-thumbnail', 400, 280, true );
add_image_size( 'tabs-img', 50, 50, true);
add_editor_style('editor-style.css');

$evl_width_px = evl_get_option('evl_width_px', '1200');

define( 'HEADER_IMAGE_WIDTH', apply_filters( 'evolve_header_image_width', $evl_width_px ) );
define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'evolve_header_image_height', 170 ) );

define( 'HEADER_TEXTCOLOR', '' );

define( 'NO_HEADER_TEXT', true );

add_theme_support( 'custom-header' );

$evl_custom_background = evl_get_option('evl_width_layout','fixed');

if ($evl_custom_background == "fixed") { 
$defaults = array(
	'default-color'          => 'e5e5e5',
  'default-image'          => ''
);
add_theme_support('custom-background',$defaults);
}

add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

load_theme_textdomain( 'evolve', get_template_directory() . '/languages' );

register_nav_menu( 'primary-menu', __( 'Primary Menu', 'evolve' ) );
  
$evl_layout = evl_get_option('evl_layout','2cr');
$evl_width_layout = evl_get_option('evl_width_layout','fixed');

global $content_width;

if ($evl_layout == "2cl" || $evl_layout == "2cr" ) { 
if ( ! isset( $content_width ) )
	$content_width = 610;
}
if ( ($evl_layout == "3cl" || $evl_layout == "3cr" ) ||
 ($evl_layout == "3cm" )
) {
if ( ! isset( $content_width ) )
	$content_width = 506;
}
if ( $evl_layout == "1c" ) {
if ( ! isset( $content_width ) )
	$content_width = 955;
}    
  
}  
add_action( 'after_setup_theme', 'evolve_after_setup' );
	
    
/**
 * Functions - Evolve gatekeeper
 *
 * This file defines a few constants variables, loads up the core Evolve file, 
 * and finally initialises the main WP Evolve Class.
 *
 * @package EvoLve
 * @subpackage Functions
 */

/* Blast you red baron! Initialise WP Evolve */
	get_template_part( 'library/evolve' );
	WPevolve::init();

get_template_part( 'library/functions/options-backup' );
get_template_part( 'library/functions/tabs-widget' );

/* evltruncate */

function evltruncate ($str, $length=10, $trailing='..')
{
 $length-=mb_strlen($trailing);
 if (mb_strlen($str)> $length)
	  {
 return mb_substr($str,0,$length).$trailing;
  }
 else
  {
 $res = $str;
  }
 return $res;
} 


/* Get first image */

function evlget_first_image() {
 global $post, $posts;
 $first_img = '';
 $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
 if(isset($matches[1][0])){
 $first_img = $matches [1][0];
 return $first_img;
 }  
}  

// Tiny URL

function evolve_tinyurl($url) {
    $response = esc_url(wp_remote_retrieve_body(wp_remote_get('http://tinyurl.com/api-create.php?url='.$url)));
    return $response;
}


// Similar Posts 

function evlsimilar_posts() {

$post = '';
$orig_post = $post;
global $post;

$evloptions = get_option('evolve'); if ($evloptions['evl_similar_posts'] == "category") { 
$matchby = get_the_category($post->ID);
$matchin = 'category';
} else {
$matchby = wp_get_post_tags($post->ID);
$matchin = 'tag'; }


if ($matchby) {
	$matchby_ids = array();
	foreach($matchby as $individual_matchby) $matchby_ids[] = $individual_matchby->term_id;

	$args=array(
		$matchin.'__in' => $matchby_ids,
		'post__not_in' => array($post->ID),
		'showposts'=>5, // Number of related posts that will be shown.
		'ignore_sticky_posts'=>1
	);  

	$my_query = new wp_query($args);
	if( $my_query->have_posts() ) {
_e( '<div class="similar-posts"><h5>Similar posts</h5><ul>', 'evolve' );
		while ($my_query->have_posts()) {
			$my_query->the_post();
		?>
			<li>
      
     <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
<?php

if ( get_the_title() ){ $title = the_title('', '', false);
echo evltruncate($title, 40, '...'); }else{ echo "Untitled"; }


 ?></a>

  <?php if ( get_the_content() ) { ?> &mdash; <small><?php $postexcerpt = get_the_content();
$postexcerpt = apply_filters('the_content', $postexcerpt);
$postexcerpt = str_replace(']]>', ']]&gt;', $postexcerpt);
$postexcerpt = strip_tags($postexcerpt);
$postexcerpt = strip_shortcodes($postexcerpt);

echo evltruncate($postexcerpt, 60, '...');
 ?></small> <?php } ?>
      
      </li>
		<?php
		}
		echo '</ul></div>';
	}
}
$post = $orig_post;
wp_reset_query();   

}

function evlfooter_hooks() { ?>


<?php if (is_page_template('contact.php')): 
$status_gmap = evl_get_option('evl_status_gmap','1');

if($status_gmap): ?><script type="text/javascript" src="http<?php echo (is_ssl())? 's' : ''; ?>://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false&amp;language=<?php echo substr(get_locale(), 0, 2); ?>"></script>

	<?php
 $evl_gmap_address = evl_get_option('evl_gmap_address', 'Via dei Fori Imperiali');
 $evl_gmap_type = evl_get_option('evl_gmap_type', 'hybrid');
 $evl_map_zoom_level = evl_get_option('evl_map_zoom_level', '18');
 $evl_map_scrollwheel = evl_get_option('evl_map_scrollwheel', '0');
 $evl_map_scale = evl_get_option('evl_map_scale', '0');
 $evl_map_zoomcontrol = evl_get_option('evl_map_zoomcontrol', '0');
 $evl_map_pin = evl_get_option('evl_map_pin', '0');
 $evl_map_pop = evl_get_option('evl_map_popup', '0');
  $evl_gmap_address = addslashes($evl_gmap_address);
	$addresses = explode('|', $evl_gmap_address);
	$markers = '';
	if($evl_map_pop == '0') {
		$map_popup = "false";
	} else {
		$map_popup = "true";
	}
	foreach($addresses as $address_string) {
		$markers .= "{
			address: '{$address_string}',
			html: {
				content: '{$address_string}',
				popup: {$map_popup}
			}
		},";
	}
	?>

<script type='text/javascript'>  
	jQuery(document).ready(function($) {
		jQuery('#gmap').goMap({
			address: '<?php echo $addresses[0]; ?>',
			maptype: '<?php echo $evl_gmap_type; ?>',
			zoom: <?php echo $evl_map_zoom_level; ?>,
			scrollwheel: <?php if($evl_map_scrollwheel): ?>false<?php else: ?>true<?php endif; ?>,
			scaleControl: <?php if($evl_map_scale): ?>false<?php else: ?>true<?php endif; ?>,
			navigationControl: <?php if($evl_map_zoomcontrol): ?>false<?php else: ?>true<?php endif; ?>,
	        <?php if(!$evl_map_pin): ?>markers: [<?php echo $markers; ?>],<?php endif; ?>
		});
	});
	</script>
<?php endif; ?>  
<?php endif; ?>  

<script type="text/javascript" charset="utf-8">
var $jx = jQuery.noConflict();
  $jx("div.post").mouseover(function() {
    $jx(this).find("span.edit-post").css('visibility', 'visible');
  }).mouseout(function(){
    $jx(this).find("span.edit-post").css('visibility', 'hidden');
  });
  
    $jx("div.type-page").mouseover(function() {
    $jx(this).find("span.edit-page").css('visibility', 'visible');
  }).mouseout(function(){
    $jx(this).find("span.edit-page").css('visibility', 'hidden');
  });
  
      $jx("div.type-attachment").mouseover(function() {
    $jx(this).find("span.edit-post").css('visibility', 'visible');
  }).mouseout(function(){
    $jx(this).find("span.edit-post").css('visibility', 'hidden');
  });
  
  $jx("li.comment").mouseover(function() {
    $jx(this).find("span.edit-comment").css('visibility', 'visible');
  }).mouseout(function(){
    $jx(this).find("span.edit-comment").css('visibility', 'hidden');
  });
</script> 


<?php $evl_sticky_header = evl_get_option('evl_sticky_header','1'); if ( $evl_sticky_header == "1" ) { ?>  

<script type="text/javascript" charset="utf-8"> 
//
//
// 
// Sticky Header
//
//
//             
  
jQuery(document).ready(function($) {
	if(jQuery('.sticky-header').length >= 1) {
		jQuery(window).scroll(function() {
		     var header = jQuery(document).scrollTop();
		     var headerHeight = jQuery('.menu-header').height();

	       if(header > headerHeight) {
		     	jQuery('.sticky-header').addClass('sticky');
		     	jQuery('.sticky-header').fadeIn();
		     } else {
		     	jQuery('.sticky-header').removeClass('sticky');
		     	jQuery('.sticky-header').hide();
		     }
		});
	}
}); 
</script>
  
<?php }	?> 


<?php $evl_animatecss = evl_get_option('evl_animatecss', '1');  
 
if ($evl_animatecss == "1") { ?> 

<script type="text/javascript" charset="utf-8">
//
//
// 
// Animated Buttons
//
//
//      
var $animated = jQuery.noConflict();
$animated('.post-more').hover(
       function(){ $animated(this).addClass('animated pulse') },
       function(){ $animated(this).removeClass('animated pulse') }
)   
$animated('.read-more').hover(
       function(){ $animated(this).addClass('animated pulse') },
       function(){ $animated(this).removeClass('animated pulse') }
)
$animated('#submit').hover(
       function(){ $animated(this).addClass('animated pulse') },
       function(){ $animated(this).removeClass('animated pulse') }
)
$animated('input[type="submit"]').hover(
       function(){ $animated(this).addClass('animated pulse') },
       function(){ $animated(this).removeClass('animated pulse') }
)

</script>

<?php } ?>


<?php 

$evl_carousel_slider = evl_get_option('evl_carousel_slider', '1'); 

if ($evl_carousel_slider == "1"):

$evl_carousel_speed = evl_get_option('evl_carousel_speed', '3500'); if (empty($evl_carousel_speed)): $evl_carousel_speed = '3500'; endif; ?>

<script type="text/javascript" charset="utf-8">
var $s = jQuery.noConflict();
	$s(function(){ 
$s('#slides') 
  .anythingSlider({autoPlay: true,delay: <?php echo $evl_carousel_speed; ?>,}) 
  })
</script>

<?php endif; ?> 


<?php 

$evl_bootstrap_speed = evl_get_option('evl_bootstrap_speed', '7000'); if (empty($evl_bootstrap_speed)): $evl_bootstrap_speed = '7000'; endif;

$evl_parallax_slider = evl_get_option('evl_parallax_slider_support', '1'); 

if ($evl_parallax_slider == "1"):

$evl_parallax_speed = evl_get_option('evl_parallax_speed', '4000'); if (empty($evl_parallax_speed)): $evl_parallax_speed = '4000'; endif;

?>

<script type="text/javascript" charset="utf-8">
var $par = jQuery.noConflict(); 
  $par('#da-slider').cslider({
					autoplay	: true,
					bgincrement	: 450,
          interval	: <?php echo $evl_parallax_speed; ?>
				});

</script>

<?php endif; ?>

<script type="text/javascript" charset="utf-8">
var $carousel = jQuery.noConflict();
$carousel('#myCarousel').carousel({
interval: 7000
})
$carousel('#carousel-nav a').click(function(q){
q.preventDefault();
targetSlide = $carousel(this).attr('data-to')-1;
$carousel('#myCarousel').carousel(targetSlide);
$carousel(this).addClass('active').siblings().removeClass('active');
});

$carousel('#bootstrap-slider').carousel({
interval: <?php echo $evl_bootstrap_speed; ?>
})
$carousel('#carousel-nav a').click(function(q){
q.preventDefault();
targetSlide = $carousel(this).attr('data-to')-1;
$carousel('#bootstrap-slider').carousel(targetSlide);
$carousel(this).addClass('active').siblings().removeClass('active');
});
    
// $('#carousel-rel a').click(function(q){
//         console.log('Clicked');
//         targetSlide = (parseInt($('#carousel-rel a.active').data('to')) + 1) % 3;
//         console.log('targetSlide');
//         $('#carousel-rel a[data-to='+ targetSlide +']').addClass('active').siblings().removeClass('active');
//     });
</script>



<?php } 

function evolve_hexDarker($hex,$factor = 30)
      {
        $new_hex = '';
        
        $base['R'] = hexdec($hex{0}.$hex{1});
        $base['G'] = hexdec($hex{2}.$hex{3});
        $base['B'] = hexdec($hex{4}.$hex{5});
        
        foreach ($base as $k => $v)
                {
                $amount = $v / 100;
                $amount = round($amount * $factor);
                $new_decimal = $v - $amount;
        
                $new_hex_component = dechex($new_decimal);
                if(strlen($new_hex_component) < 2)
                        { $new_hex_component = "0".$new_hex_component; }
                $new_hex .= $new_hex_component;
                }
                
        return $new_hex;        
        } 
        
        
function evolve_filter_wp_title( $title ) {
    
    global $page, $paged;
    
    // Get the Site Name
    $site_name = get_bloginfo( 'name' );
    // Prepend name
    $filtered_title = $site_name . $title;
    // Get the Site Description
        $site_description = get_bloginfo( 'description' );
    // If site front page, append description
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        // Append Site Description to title
        $filtered_title .= ' - ' .$site_description;
        
    }
    if ( $paged >= 2 || $page >= 2 ) {
        $filtered_title .= ' - ' . sprintf( __( 'Page %s', 'pure-line' ), max( $paged, $page ) );
        }
    // Return the modified title
    return $filtered_title;
}
// Hook into 'wp_title'
add_filter( 'wp_title', 'evolve_filter_wp_title' );


function evolve_enqueue_comment_reply() {
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { 
                wp_enqueue_script( 'comment-reply' ); 
        }
    }
    add_action( 'wp_enqueue_scripts', 'evolve_enqueue_comment_reply' );


 // Share This Buttons

function evolve_sharethis() { ?>
    <div class="share-this">
          <a rel="nofollow" class="tipsytext" title="<?php _e( 'Share on Twitter', 'evolve' ); ?>" target="_blank" href="http://twitter.com/intent/tweet?status=<?php the_title(); ?>+&raquo;+<?php echo esc_url(evolve_tinyurl(get_permalink())); ?>"><i class="fa fa-twitter"></i></a>
          <a rel="nofollow" class="tipsytext" title="<?php _e( 'Share on Facebook', 'evolve' ); ?>" target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title(); ?>"><i class="fa fa-facebook"></i></a>
          <a rel="nofollow" class="tipsytext" title="<?php _e( 'Share on Google Plus', 'evolve' ); ?>" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa fa-google-plus"></i></a>
          <a rel="nofollow" class="tipsytext" title="<?php _e( 'Share on Pinterest', 'evolve' ); ?>" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>"><i class="fa fa-pinterest"></i></a>
          <a rel="nofollow" class="tipsytext" title="<?php _e( 'Share by Email', 'evolve' ); ?>" target="_blank" href="http://www.addtoany.com/email?linkurl=<?php the_permalink(); ?>&linkname=<?php the_title(); ?>"><i class="fa fa-envelope"></i></a>
          <a rel="nofollow" class="tipsytext" title="<?php _e( 'More options', 'evolve' ); ?>" target="_blank" href="http://www.addtoany.com/share_save#url=<?php the_permalink(); ?>&linkname=<?php the_title(); ?>"><i class="fa fa-share"></i></a>
          </div>
<?php } 


/* 
 * This is an example of how to add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 */

add_action('evolve_custom_scripts', 'evolve_custom_scripts');

function evolve_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#evl_show_slide1').click(function() {
  		jQuery('#section-evl_slide1_img').fadeToggle(400);
      jQuery('#section-evl_slide1_title').fadeToggle(400);
      jQuery('#section-evl_slide1_desc').fadeToggle(400);
      jQuery('#section-evl_slide1_button').fadeToggle(400);
	});
	
	if (jQuery('#evl_show_slide1:checked').val() !== undefined) {
		jQuery('#section-evl_slide1_img').show();
    jQuery('#section-evl_slide1_title').show();
    jQuery('#section-evl_slide1_desc').show();
    jQuery('#section-evl_slide1_button').show();
	}
  
 	jQuery('#evl_show_slide2').click(function() {
  		jQuery('#section-evl_slide2_img').fadeToggle(400);
      jQuery('#section-evl_slide2_title').fadeToggle(400);
      jQuery('#section-evl_slide2_desc').fadeToggle(400);
      jQuery('#section-evl_slide2_button').fadeToggle(400);
	});
	
	if (jQuery('#evl_show_slide2:checked').val() !== undefined) {
		jQuery('#section-evl_slide2_img').show();
    jQuery('#section-evl_slide2_title').show();
    jQuery('#section-evl_slide2_desc').show();
    jQuery('#section-evl_slide2_button').show();
	}
  
 	jQuery('#evl_show_slide3').click(function() {
  		jQuery('#section-evl_slide3_img').fadeToggle(400);
      jQuery('#section-evl_slide3_title').fadeToggle(400);
      jQuery('#section-evl_slide3_desc').fadeToggle(400);
      jQuery('#section-evl_slide3_button').fadeToggle(400);
	});
	
	if (jQuery('#evl_show_slide3:checked').val() !== undefined) {
		jQuery('#section-evl_slide3_img').show();
    jQuery('#section-evl_slide3_title').show();
    jQuery('#section-evl_slide3_desc').show();
    jQuery('#section-evl_slide3_button').show();
	}  
  
 	jQuery('#evl_show_slide4').click(function() {
  		jQuery('#section-evl_slide4_img').fadeToggle(400);
      jQuery('#section-evl_slide4_title').fadeToggle(400);
      jQuery('#section-evl_slide4_desc').fadeToggle(400);
      jQuery('#section-evl_slide4_button').fadeToggle(400);
	});
	
	if (jQuery('#evl_show_slide4:checked').val() !== undefined) {
		jQuery('#section-evl_slide4_img').show();
    jQuery('#section-evl_slide4_title').show();
    jQuery('#section-evl_slide4_desc').show();
    jQuery('#section-evl_slide4_button').show();
	}  
  
 	jQuery('#evl_show_slide5').click(function() {
  		jQuery('#section-evl_slide5_img').fadeToggle(400);
      jQuery('#section-evl_slide5_title').fadeToggle(400);
      jQuery('#section-evl_slide5_desc').fadeToggle(400);
      jQuery('#section-evl_slide5_button').fadeToggle(400);
	});
	
	if (jQuery('#evl_show_slide5:checked').val() !== undefined) {
		jQuery('#section-evl_slide5_img').show();
    jQuery('#section-evl_slide5_title').show();
    jQuery('#section-evl_slide5_desc').show();
    jQuery('#section-evl_slide5_button').show();
	}  
  
	jQuery('#evl_bootstrap_slide1').click(function() {
  		jQuery('#section-evl_bootstrap_slide1_img').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide1_title').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide1_desc').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide1_button').fadeToggle(400);
	});
	
	if (jQuery('#evl_bootstrap_slide1:checked').val() !== undefined) {
		jQuery('#section-evl_bootstrap_slide1_img').show();
    jQuery('#section-evl_bootstrap_slide1_title').show();
    jQuery('#section-evl_bootstrap_slide1_desc').show();
    jQuery('#section-evl_bootstrap_slide1_button').show();
	}
  
 	jQuery('#evl_bootstrap_slide2').click(function() {
  		jQuery('#section-evl_bootstrap_slide2_img').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide2_title').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide2_desc').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide2_button').fadeToggle(400);
	});
	
	if (jQuery('#evl_bootstrap_slide2:checked').val() !== undefined) {
		jQuery('#section-evl_bootstrap_slide2_img').show();
    jQuery('#section-evl_bootstrap_slide2_title').show();
    jQuery('#section-evl_bootstrap_slide2_desc').show();
    jQuery('#section-evl_bootstrap_slide2_button').show();
	}
  
 	jQuery('#evl_bootstrap_slide3').click(function() {
  		jQuery('#section-evl_bootstrap_slide3_img').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide3_title').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide3_desc').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide3_button').fadeToggle(400);
	});
	
	if (jQuery('#evl_bootstrap_slide3:checked').val() !== undefined) {
		jQuery('#section-evl_bootstrap_slide3_img').show();
    jQuery('#section-evl_bootstrap_slide3_title').show();
    jQuery('#section-evl_bootstrap_slide3_desc').show();
    jQuery('#section-evl_bootstrap_slide3_button').show();
	}  
  
 	jQuery('#evl_bootstrap_slide4').click(function() {
  		jQuery('#section-evl_bootstrap_slide4_img').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide4_title').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide4_desc').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide4_button').fadeToggle(400);
	});
	
	if (jQuery('#evl_bootstrap_slide4:checked').val() !== undefined) {
		jQuery('#section-evl_bootstrap_slide4_img').show();
    jQuery('#section-evl_bootstrap_slide4_title').show();
    jQuery('#section-evl_bootstrap_slide4_desc').show();
    jQuery('#section-evl_bootstrap_slide4_button').show();
	}  
  
 	jQuery('#evl_bootstrap_slide5').click(function() {
  		jQuery('#section-evl_bootstrap_slide5_img').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide5_title').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide5_desc').fadeToggle(400);
      jQuery('#section-evl_bootstrap_slide5_button').fadeToggle(400);
	});
	
	if (jQuery('#evl_bootstrap_slide5:checked').val() !== undefined) {
		jQuery('#section-evl_bootstrap_slide5_img').show();
    jQuery('#section-evl_bootstrap_slide5_title').show();
    jQuery('#section-evl_bootstrap_slide5_desc').show();
    jQuery('#section-evl_bootstrap_slide5_button').show();
	}    
	
});
</script>   

<?php } 

/* Bootstrap Slider */

function evolve_bootstrap() {

    $imagepathfolder = get_template_directory_uri() . '/library/media/images/';
    
    $evl_bootstrap_slide_1 = evl_get_option('evl_bootstrap_slide1','1');
    $evl_bootstrap_slide_2 = evl_get_option('evl_bootstrap_slide2','1');
    $evl_bootstrap_slide_3 = evl_get_option('evl_bootstrap_slide3','1');
    $evl_bootstrap_slide_4 = evl_get_option('evl_bootstrap_slide4','1');
    $evl_bootstrap_slide_5 = evl_get_option('evl_bootstrap_slide5','1');    
    
if ($evl_bootstrap_slide_1 == "1" || $evl_bootstrap_slide_2 == "1" || $evl_bootstrap_slide_3 == "1" || $evl_bootstrap_slide_4 == "1" || $evl_bootstrap_slide_5 == "1") {    

    echo "<div id='bootstrap-slider' class='carousel slide' data-ride='carousel'>";
    echo "<div class='carousel-inner'>"; 
}    

if ($evl_bootstrap_slide_1 == "1") {

      $evl_bootstrap_slide1_title = evl_get_option('evl_bootstrap_slide1_title','Super Awesome WP Theme');if ($evl_bootstrap_slide1_title === false) $evl_bootstrap_slide1_title = '';   
      $evl_bootstrap_slide1_desc = evl_get_option('evl_bootstrap_slide1_desc','Absolutely free of cost theme with amazing design and premium features which will impress your visitors');if ($evl_bootstrap_slide1_desc === false) $evl_bootstrap_slide1_desc = '';
      $evl_bootstrap_slide1_button = evl_get_option('evl_bootstrap_slide1_button','<a class="button" href="#">Learn more</a>');if ($evl_bootstrap_slide1_button === false) $evl_bootstrap_slide1_button = '';
      $evl_bootstrap_slide1_img = evl_get_option('evl_bootstrap_slide1_img', $imagepathfolder . 'bootstrap-slider/1.jpg');if ($evl_bootstrap_slide1_img === false) $evl_bootstrap_slide1_img = '';
      
      echo "<div class='item active'>";
      
      echo "<img class='img-responsive' src='".$evl_bootstrap_slide1_img."' alt='' />";
      
      echo "<div class='carousel-caption'>";    

      echo "<h2>".esc_attr($evl_bootstrap_slide1_title)."</h2>";

      echo "<p>".esc_attr($evl_bootstrap_slide1_desc)."</p>";

      echo do_shortcode($evl_bootstrap_slide1_button);

      echo "</div></div>";

}

if ($evl_bootstrap_slide_2 == "1") {

      $evl_bootstrap_slide2_title = evl_get_option('evl_bootstrap_slide2_title','Bootstrap and Font Awesome Ready');if ($evl_bootstrap_slide2_title === false) $evl_bootstrap_slide2_title = '';   
      $evl_bootstrap_slide2_desc = evl_get_option('evl_bootstrap_slide2_desc','Built-in Bootstrap Elements let you do amazing things with your website');if ($evl_bootstrap_slide2_desc === false) $evl_bootstrap_slide2_desc = '';
      $evl_bootstrap_slide2_button = evl_get_option('evl_bootstrap_slide2_button','<a class="button" href="#">Learn more</a>');if ($evl_bootstrap_slide2_button === false) $evl_bootstrap_slide2_button = '';
      $evl_bootstrap_slide2_img = evl_get_option('evl_bootstrap_slide2_img', $imagepathfolder . 'bootstrap-slider/2.jpg');if ($evl_bootstrap_slide2_img === false) $evl_bootstrap_slide2_img = '';
      
      echo "<div class='item'>";   
      
      echo "<img class='img-responsive' src='".$evl_bootstrap_slide2_img."' alt='' />"; 
      
      echo "<div class='carousel-caption'>";

      echo "<h2>".esc_attr($evl_bootstrap_slide2_title)."</h2>";

      echo "<p>".esc_attr($evl_bootstrap_slide2_desc)."</p>";

      echo do_shortcode($evl_bootstrap_slide2_button);      

      echo "</div></div>";

}

if ($evl_bootstrap_slide_3 == "1") {

      $evl_bootstrap_slide3_title = evl_get_option('evl_bootstrap_slide3_title','Easy to use control panel');if ($evl_bootstrap_slide3_title === false) $evl_bootstrap_slide3_title = '';   
      $evl_bootstrap_slide3_desc = evl_get_option('evl_bootstrap_slide3_desc','Select of 500+ Google Fonts, choose layout as you need, set up your social links');if ($evl_bootstrap_slide3_desc === false) $evl_bootstrap_slide3_desc = '';
      $evl_bootstrap_slide3_button = evl_get_option('evl_bootstrap_slide3_button','<a class="button" href="#">Learn more</a>');if ($evl_bootstrap_slide3_button === false) $evl_bootstrap_slide3_button = '';
      $evl_bootstrap_slide3_img = evl_get_option('evl_bootstrap_slide3_img', $imagepathfolder . 'bootstrap-slider/3.jpg');if ($evl_bootstrap_slide3_img === false) $evl_bootstrap_slide3_img = '';
      
      echo "<div class='item'>"; 
      
      echo "<img class='img-responsive' src='".$evl_bootstrap_slide3_img."' alt='' />";
      
      echo "<div class='carousel-caption'>";               

      echo "<h2>".esc_attr($evl_bootstrap_slide3_title)."</h2>";

      echo "<p>".esc_attr($evl_bootstrap_slide3_desc)."</p>";

      echo do_shortcode($evl_bootstrap_slide3_button);  

      echo "</div></div>";

}


if ($evl_bootstrap_slide_4 == "1") {

      $evl_bootstrap_slide4_title = evl_get_option('evl_bootstrap_slide4_title','Fully responsive theme');if ($evl_bootstrap_slide4_title === false) $evl_bootstrap_slide4_title = '';   
      $evl_bootstrap_slide4_desc = evl_get_option('evl_bootstrap_slide4_desc','Adaptive to any screen depending on the device being used to view the site');if ($evl_bootstrap_slide4_desc === false) $evl_bootstrap_slide4_desc = '';
      $evl_bootstrap_slide4_button = evl_get_option('evl_bootstrap_slide4_button','<a class="button" href="#">Learn more</a>');if ($evl_bootstrap_slide4_button === false) $evl_bootstrap_slide4_button = '';
      $evl_bootstrap_slide4_img = evl_get_option('evl_bootstrap_slide4_img', $imagepathfolder . 'bootstrap-slider/4.jpg');if ($evl_bootstrap_slide4_img === false) $evl_bootstrap_slide4_img = '';
      
      echo "<div class='item'>";    
      
      echo "<img class='img-responsive' src='".$evl_bootstrap_slide4_img."' alt='' />";   
      
      echo "<div class='carousel-caption'>";         

      echo "<h2>".esc_attr($evl_bootstrap_slide4_title)."</h2>";

      echo "<p>".esc_attr($evl_bootstrap_slide4_desc)."</p>";

      echo do_shortcode($evl_bootstrap_slide4_button);
      
      echo "</div></div>";      

}


if ($evl_bootstrap_slide_5 == "1") {

      $evl_bootstrap_slide5_title = evl_get_option('evl_bootstrap_slide5_title','Unlimited color schemes');if ($evl_bootstrap_slide5_title === false) $evl_bootstrap_slide5_title = '';   
      $evl_bootstrap_slide5_desc = evl_get_option('evl_bootstrap_slide5_desc','Upload your own logo, change background color or images, select links color which you love - it\'s limitless');if ($evl_bootstrap_slide5_desc === false) $evl_bootstrap_slide5_desc = '';
      $evl_bootstrap_slide5_button = evl_get_option('evl_bootstrap_slide5_button','<a class="button" href="#">Learn more</a>');if ($evl_bootstrap_slide5_button === false) $evl_bootstrap_slide5_button = '';
      $evl_bootstrap_slide5_img = evl_get_option('evl_bootstrap_slide5_img', $imagepathfolder . 'bootstrap-slider/5.jpg');if ($evl_bootstrap_slide5_img === false) $evl_bootstrap_slide5_img = '';
      
      echo "<div class='item'>";    
      
      echo "<img class='img-responsive' src='".$evl_bootstrap_slide5_img."' alt='' />";  
      
      echo "<div class='carousel-caption'>";          

      echo "<h2>".esc_attr($evl_bootstrap_slide5_title)."</h2>";

      echo "<p>".esc_attr($evl_bootstrap_slide5_desc)."</p>";

      echo do_shortcode($evl_bootstrap_slide5_button);

      echo "</div></div>";
} 

if ($evl_bootstrap_slide_1 == "1" || $evl_bootstrap_slide_2 == "1" || $evl_bootstrap_slide_3 == "1" || $evl_bootstrap_slide_4 == "1" || $evl_bootstrap_slide_5 == "1") {

echo "</div><a class='left carousel-control' href='#bootstrap-slider' data-slide='prev'><img src='".get_template_directory_uri()."/library/media/images/left-ar.png' /></a>
<a class='right carousel-control' href='#bootstrap-slider' data-slide='next'><img src='".get_template_directory_uri()."/library/media/images/right-ar.png' /></a></div>";

}

}

/* Parallax Slider */

function evolve_parallax() {

    $imagepathfolder = get_template_directory_uri() . '/library/media/images/';

    echo "<div id='da-slider' class='da-slider'>";
      
    $evl_slide_1 = evl_get_option('evl_show_slide1','1');
    $evl_slide_2 = evl_get_option('evl_show_slide2','1');
    $evl_slide_3 = evl_get_option('evl_show_slide3','1');
    $evl_slide_4 = evl_get_option('evl_show_slide4','1');
    $evl_slide_5 = evl_get_option('evl_show_slide5','1');

if ($evl_slide_1 == "1") {

      $evl_slide1_title = evl_get_option('evl_slide1_title','Super Awesome WP Theme');if ($evl_slide1_title === false) $evl_slide1_title = '';   
      $evl_slide1_desc = evl_get_option('evl_slide1_desc','Absolutely free of cost theme with amazing design and premium features which will impress your visitors');if ($evl_slide1_desc === false) $evl_slide1_desc = '';
      $evl_slide1_button = evl_get_option('evl_slide1_button','<a class="da-link" href="#">Learn more</a>');if ($evl_slide1_button === false) $evl_slide1_button = '';
      $evl_slide1_img = evl_get_option('evl_slide1_img', $imagepathfolder . 'parallax/6.png');if ($evl_slide1_img === false) $evl_slide1_img = '';
      
      echo "<div class='da-slide'>";    

      echo "<h2>".esc_attr($evl_slide1_title)."</h2>";

      echo "<p>".esc_attr($evl_slide1_desc)."</p>";

      echo do_shortcode($evl_slide1_button);

      echo "<div class='da-img'><img class='img-responsive' src='".$evl_slide1_img."' alt='' /></div>";

      echo "</div>";

}

if ($evl_slide_2 == "1") {

      $evl_slide2_title = evl_get_option('evl_slide2_title','Bootstrap and Font Awesome Ready');if ($evl_slide2_title === false) $evl_slide2_title = '';   
      $evl_slide2_desc = evl_get_option('evl_slide2_desc','Built-in Bootstrap Elements let you do amazing things with your website');if ($evl_slide2_desc === false) $evl_slide2_desc = '';
      $evl_slide2_button = evl_get_option('evl_slide2_button','<a class="da-link" href="#">Learn more</a>');if ($evl_slide2_button === false) $evl_slide2_button = '';
      $evl_slide2_img = evl_get_option('evl_slide2_img', $imagepathfolder . 'parallax/5.png');if ($evl_slide2_img === false) $evl_slide2_img = '';
      
      echo "<div class='da-slide'>";    

      echo "<h2>".esc_attr($evl_slide2_title)."</h2>";

      echo "<p>".esc_attr($evl_slide2_desc)."</p>";

      echo do_shortcode($evl_slide2_button);

      echo "<div class='da-img'><img class='img-responsive' src='".$evl_slide2_img."' alt='' /></div>";

      echo "</div>";

}

if ($evl_slide_3 == "1") {

      $evl_slide3_title = evl_get_option('evl_slide3_title','Easy to use control panel');if ($evl_slide3_title === false) $evl_slide3_title = '';   
      $evl_slide3_desc = evl_get_option('evl_slide3_desc','Select of 500+ Google Fonts, choose layout as you need, set up your social links');if ($evl_slide3_desc === false) $evl_slide3_desc = '';
      $evl_slide3_button = evl_get_option('evl_slide3_button','<a class="da-link" href="#">Learn more</a>');if ($evl_slide3_button === false) $evl_slide3_button = '';
      $evl_slide3_img = evl_get_option('evl_slide3_img', $imagepathfolder . 'parallax/4.png');if ($evl_slide3_img === false) $evl_slide3_img = '';
      
      echo "<div class='da-slide'>";    

      echo "<h2>".esc_attr($evl_slide3_title)."</h2>";

      echo "<p>".esc_attr($evl_slide3_desc)."</p>";

      echo do_shortcode($evl_slide3_button);

      echo "<div class='da-img'><img class='img-responsive' src='".$evl_slide3_img."' alt='' /></div>";

      echo "</div>";

}


if ($evl_slide_4 == "1") {

      $evl_slide4_title = evl_get_option('evl_slide4_title','Fully responsive theme');if ($evl_slide4_title === false) $evl_slide4_title = '';   
      $evl_slide4_desc = evl_get_option('evl_slide4_desc','Adaptive to any screen depending on the device being used to view the site');if ($evl_slide4_desc === false) $evl_slide4_desc = '';
      $evl_slide4_button = evl_get_option('evl_slide4_button','<a class="da-link" href="#">Learn more</a>');if ($evl_slide4_button === false) $evl_slide4_button = '';
      $evl_slide4_img = evl_get_option('evl_slide4_img', $imagepathfolder . 'parallax/1.png');if ($evl_slide4_img === false) $evl_slide4_img = '';
      
      echo "<div class='da-slide'>";    

      echo "<h2>".esc_attr($evl_slide4_title)."</h2>";

      echo "<p>".esc_attr($evl_slide4_desc)."</p>";

      echo do_shortcode($evl_slide4_button);

      echo "<div class='da-img'><img class='img-responsive' src='".$evl_slide4_img."' alt='' /></div>";

      echo "</div>";

}


if ($evl_slide_5 == "1") {

      $evl_slide5_title = evl_get_option('evl_slide5_title','Unlimited color schemes');if ($evl_slide5_title === false) $evl_slide5_title = '';   
      $evl_slide5_desc = evl_get_option('evl_slide5_desc','Upload your own logo, change background color or images, select links color which you love - it\'s limitless');if ($evl_slide5_desc === false) $evl_slide5_desc = '';
      $evl_slide5_button = evl_get_option('evl_slide5_button','<a class="da-link" href="#">Learn more</a>');if ($evl_slide5_button === false) $evl_slide5_button = '';
      $evl_slide5_img = evl_get_option('evl_slide5_img', $imagepathfolder . 'parallax/3.png');if ($evl_slide5_img === false) $evl_slide5_img = '';
      
      echo "<div class='da-slide'>";    

      echo "<h2>".esc_attr($evl_slide5_title)."</h2>";

      echo "<p>".esc_attr($evl_slide5_desc)."</p>";

      echo do_shortcode($evl_slide5_button);

      echo "<div class='da-img'><img class='img-responsive' src='".$evl_slide5_img."' alt='' /></div>";

      echo "</div>";

}
echo "<nav class='da-arrows'><span class='da-arrows-prev'></span><span class='da-arrows-next'></span></nav></div>";

}

/* Front Page Content Boxes */

function evolve_content_boxes() {


$evl_content_boxes = evl_get_option('evl_content_boxes','1');

if ($evl_content_boxes == "1") {   

      echo "<div class='content-boxes'>"; 

      $evl_content_box1_title = evl_get_option('evl_content_box1_title','Beautifully Simple');if ($evl_content_box1_title === false) $evl_content_box1_title = '';   
      $evl_content_box1_desc = evl_get_option('evl_content_box1_desc','Clean and modern theme with smooth and pixel perfect design');if ($evl_content_box1_desc === false) $evl_content_box1_desc = '';
      $evl_content_box1_button = evl_get_option('evl_content_box1_button','<a class="read-more btn" href="#">Learn more</a>');if ($evl_content_box1_button === false) $evl_content_box1_button = '';
      $evl_content_box1_icon = evl_get_option('evl_content_box1_icon', 'fa-cube');if ($evl_content_box1_icon === false) $evl_content_box1_icon = '';
      
      echo "<div class='col-sm-12 col-md-4 content-box content-box-1'>";
      
      echo "<i class='fa ".$evl_content_box1_icon."'/></i>";
      
      echo "<h2>".esc_attr($evl_content_box1_title)."</h2>";

      echo "<p>".do_shortcode($evl_content_box1_desc)."</p>";

      echo do_shortcode($evl_content_box1_button);

      echo "</div>";





      $evl_content_box2_title = evl_get_option('evl_content_box2_title','Easy Customizable');if ($evl_content_box2_title === false) $evl_content_box2_title = '';   
      $evl_content_box2_desc = evl_get_option('evl_content_box2_desc','Over a hundred theme options ready to make your website unique');if ($evl_content_box2_desc === false) $evl_content_box2_desc = '';
      $evl_content_box2_button = evl_get_option('evl_content_box2_button','<a class="read-more btn" href="#">Learn more</a>');if ($evl_content_box2_button === false) $evl_content_box2_button = '';
      $evl_content_box2_icon = evl_get_option('evl_content_box2_icon', 'fa-circle-o-notch');if ($evl_content_box2_icon === false) $evl_content_box2_icon = '';
      
      echo "<div class='col-sm-12 col-md-4 content-box content-box-2'>";   
      
      echo "<i class='fa ".$evl_content_box2_icon."'/></i>"; 
      
      echo "<h2>".esc_attr($evl_content_box2_title)."</h2>";

      echo "<p>".do_shortcode($evl_content_box2_desc)."</p>";

      echo do_shortcode($evl_content_box2_button);      

      echo "</div>";





      $evl_content_box3_title = evl_get_option('evl_content_box3_title','Contact Form Ready');if ($evl_content_box3_title === false) $evl_content_box3_title = '';   
      $evl_content_box3_desc = evl_get_option('evl_content_box3_desc','Built-In Contact Page with Google Maps is a standard for this theme');if ($evl_content_box3_desc === false) $evl_content_box3_desc = '';
      $evl_content_box3_button = evl_get_option('evl_content_box3_button','<a class="read-more btn" href="#">Learn more</a>');if ($evl_content_box3_button === false) $evl_content_box3_button = '';
      $evl_content_box3_icon = evl_get_option('evl_content_box3_icon', 'fa-send');if ($evl_content_box3_icon === false) $evl_content_box3_icon = '';
      
      echo "<div class='col-sm-12 col-md-4 content-box content-box-3'>"; 
      
      echo "<i class='fa ".$evl_content_box3_icon."'/></i>";
      
      echo "<h2>".esc_attr($evl_content_box3_title)."</h2>";

      echo "<p>".do_shortcode($evl_content_box3_desc)."</p>";

      echo do_shortcode($evl_content_box3_button);  

      echo "</div>";
      
      echo "</div><div class='clearfix'></div>";      
}

}

class evolve_ThemeFrameworkMetaboxes {
	
	public function __construct()
	{
		global $data;
		$this->data = $data;

		add_action('add_meta_boxes', array($this, 'evolve_add_meta_boxes'));
		add_action('save_post', array($this, 'evolve_save_meta_boxes'));
	}

	public function evolve_add_meta_boxes()
	{
		$this->evolve_add_meta_box('evolve_post_options', 'Post Options', 'post');
		$this->evolve_add_meta_box('evolve_page_options', 'Page Options', 'page');
	}
	
	public function evolve_add_meta_box($id, $label, $post_type)
	{
	    add_meta_box( 
	        'evolve_' . $id,
	        $label,
	        array($this, $id),
	        $post_type
	    );
	}
	
	public function evolve_save_meta_boxes($post_id)
	{
		if(defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		
		foreach($_POST as $key => $value) {
			if(strstr($key, 'evolve_')) {
				update_post_meta($post_id, $key, $value);
			}
		}
	}

	public function evolve_post_options()
	{
		$data = $this->data;
    require_once( get_template_directory() . '/library/functions/page_options.php' );
	}

	public function evolve_page_options()
	{    
		require_once( get_template_directory() . '/library/functions/page_options.php' );
	}

	public function evolve_select($id, $label, $options, $desc = '')
	{
		global $post;
		
		$html = '';
		$html .= '<div class="evolve_metabox_field">';
			$html .= '<label for="evolve_' . $id . '">';
			$html .= $label;
			$html .= '</label>';
			$html .= '<div class="field">';
				$html .= '<select id="evolve_' . $id . '" name="evolve_' . $id . '">';
				foreach($options as $key => $option) {
					if(get_post_meta($post->ID, 'evolve_' . $id, true) == $key) {
						$selected = 'selected="selected"';
					} else {
						$selected = '';
					}
					
					$html .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
				}
				$html .= '</select>';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
		$html .= '</div>';
		
		echo $html;
	}
	
}

$metaboxes = new evolve_ThemeFrameworkMetaboxes;


/**
 * evolve_Walker_Nav_Menu
 */

class evolve_Walker_Nav_Menu extends Walker_Nav_Menu {
   /**
         * @see Walker::start_lvl()
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of page. Used for padding.
         */


        /**
         * @see Walker::start_el()
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item Menu item data object.
         * @param int $depth Depth of menu item. Used for padding.
         * @param int $current_page Menu item ID.
         * @param object $args
         */
        public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
                $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

                /**
                 * Dividers, Headers or Disabled
                 * =============================
                 * Determine whether the item is a Divider, Header, Disabled or regular
                 * menu item. To prevent errors we use the strcasecmp() function to so a
                 * comparison that is not case sensitive. The strcasecmp() function returns
                 * a 0 if the strings are equal.
                 */
                       $class_names = $value = '';

                        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
                        $classes[] = 'menu-item-' . $item->ID;

                        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

                        if ( $args->has_children )
                                $class_names .= ' dropdown';

                        if ( in_array( 'current-menu-item', $classes ) )
                                $class_names .= ' active';

                        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

                        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
                        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

                        $output .= $indent . '<li' . $id . $value . $class_names .'>';

                        $atts = array();
                        $atts['title'] = ! empty( $item->title )        ? $item->title        : '';
                        $atts['target'] = ! empty( $item->target )        ? $item->target        : '';
                        $atts['rel'] = ! empty( $item->xfn )                ? $item->xfn        : '';

                        $atts['href'] = ! empty( $item->url ) ? $item->url : '';
  

                        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

                        $attributes = '';
                        foreach ( $atts as $attr => $value ) {
                                if ( ! empty( $value ) ) {
                                        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                                        $attributes .= ' ' . $attr . '="' . $value . '"';
                                }
                        }

                        $item_output = $args->before;

                        /*
                         * Glyphicons
                         * ===========
                         * Since the the menu item is NOT a Divider or Header we check the see
                         * if there is a value in the attr_title property. If the attr_title
                         * property is NOT null we apply it as the class name for the glyphicon.
                         */
                        $item_output .= '<a'. $attributes .'><span data-hover="'.$item->title.'">';

                        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                        $item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="arrow"></span></a>' : '</span></a>';
                        $item_output .= $args->after;

                        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
                
        }

        /**
         * Traverse elements to create list from elements.
         *
         * Display one element if the element doesn't have any children otherwise,
         * display the element and its children. Will only traverse up to the max
         * depth and no ignore elements under that depth.
         *
         * This method shouldn't be called directly, use the walk() method instead.
         *
         * @see Walker::start_el()
         * @since 2.5.0
         *
         * @param object $element Data object
         * @param array $children_elements List of elements to continue traversing.
         * @param int $max_depth Max depth to traverse.
         * @param int $depth Depth of current element.
         * @param array $args
         * @param string $output Passed by reference. Used to append additional content.
         * @return null Null on failure with no changes to parameters.
         */
        public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}

// Breadcrumbs //

function evolve_breadcrumb() {
        global $data,$post;
        if ( !is_front_page() ) {
        echo '<ul class="breadcrumbs">';
        
        
        echo '<li><a class="home" href="';
        echo home_url();
        echo '">'.__('Home', 'evolve');
        echo "</a></li>";
        

        $params['link_none'] = '';
        $separator = '';

        if (is_category()) {
            $category = get_the_category();
            $ID = $category[0]->cat_ID;
            echo is_wp_error( $cat_parents = get_category_parents($ID, TRUE, '', FALSE ) ) ? '' : '<li>'.$cat_parents.'</li>';
        }

        if (is_tax()) {
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            echo '<li>'.$term->name.'</li>';
        }

        if(is_home()) { echo '<li>'.$data['blog_title'].'</li>'; }
        if(is_page() && !is_front_page()) {
            $parents = array();
            $parent_id = $post->post_parent;
            while ( $parent_id ) :
                $page = get_page( $parent_id );
                if ( $params["link_none"] )
                    $parents[]  = get_the_title( $page->ID );
                else
                    $parents[]  = '<li><a href="' . get_permalink( $page->ID ) . '" title="' . get_the_title( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a></li>' . $separator;
                $parent_id  = $page->post_parent;
            endwhile;
            $parents = array_reverse( $parents );
            echo join( ' ', $parents );
            echo '<li>'.get_the_title().'</li>';
        }
        if(is_single()) {
            $categories_1 = get_the_category($post->ID);
            if($categories_1):
                foreach($categories_1 as $cat_1):
                    $cat_1_ids[] = $cat_1->term_id;
                endforeach;
                $cat_1_line = implode(',', $cat_1_ids);
            endif;
            $categories = get_categories(array(
                'include' => $cat_1_line,
                'orderby' => 'id'
            ));
            if ( $categories ) :
                foreach ( $categories as $cat ) :
                    $cats[] = '<li><a href="' . get_category_link( $cat->term_id ) . '" title="' . $cat->name . '">' . $cat->name . '</a></li>';
                endforeach;
                echo join( ' ', $cats );
            endif;
            echo '<li>'.get_the_title().'</li>';
        }
        if(is_tag()){ echo '<li>'."Tag: ".single_tag_title('',FALSE).'</li>'; }
        if(is_404()){ echo '<li>'.__("404 - Page not Found", 'evolve').'</li>'; }
        if(is_search()){ echo '<li>'.__("Search", 'evolve').'</li>'; }
        if(is_year()){ echo '<li>'.get_the_time('Y').'</li>'; }

        echo "</ul>";
        }
}


function evolve_posts_slider() { ?>


 <div id="slide_holder">    
 <div class="slide-container">

<ul id="slides">
		
    <?php $number_items = evl_get_option('evl_posts_number','5'); 
    
    $slider_content = evl_get_option('evl_posts_slider_content','recent');
    $slider_content_category = '';
    $slider_content_category = evl_get_option('evl_posts_slider_id','');

   if ($slider_content == "category" && !empty($slider_content_category) ) { $slider_content_ID = $slider_content_category; } else {$slider_content_ID = '';}

   $args = array(
   'cat'=> $slider_content_ID, 
   'showposts'=> $number_items,
   'ignore_sticky_posts' =>1,
   );
query_posts($args);
    
?>


<?php if (have_posts()) : $featured = new WP_Query($args); while($featured->have_posts()) : $featured->the_post(); ?>

<li class="slide">
          
<?php           
          
if(has_post_thumbnail()) {
	echo '<div class="featured-thumbnail"><a href="'; the_permalink(); echo '">';the_post_thumbnail('slider-thumbnail'); echo '</a></div>';
  
     } else {   $image = evlget_first_image(); 
                      if ($image):
                      echo '<div class="featured-thumbnail"><a href="'; the_permalink(); echo'"><img src="'.$image.'" alt="';the_title();echo'" /></a></div>';
                      endif;
               } ?> 

<h2 class="featured-title">
<a class="title" href="<?php the_permalink() ?>">
<?php
$title = the_title('', '', false);
echo evltruncate($title, 40, '...');
 ?></a> 
</h2> 


 

<p>
<?php $postexcerpt = get_the_content();
$postexcerpt = apply_filters('the_content', $postexcerpt);
$postexcerpt = str_replace(']]>', ']]&gt;', $postexcerpt);
$postexcerpt = strip_tags($postexcerpt);
$postexcerpt = strip_shortcodes($postexcerpt);

echo evltruncate($postexcerpt, 180, ' [...]');
 ?>
 
</p>  
<a class="post-more" href="<?php the_permalink(); ?>"><?php _e( 'Read more', 'evolve' ); ?></a>    
</li>       

<?php endwhile; ?> 


<?php else: ?>  
<li>
<?php _e( '<h2 style="color:#fff;">Oops, no posts to display! Please check your post slider Category (ID) settings</h2>', 'evolve' ); ?>
</li>

<?php endif; ?>    
<?php wp_reset_query(); ?>
 </ul>
 </div>  </div>
<?php } ?>