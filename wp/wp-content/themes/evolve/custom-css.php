<?php $options = get_option('evolve');
$template_url = get_template_directory_uri(); 

  $evl_layout = evl_get_option('evl_layout','2cl');
  $evl_width_layout = evl_get_option('evl_width_layout','fixed');
  $evl_content_back = evl_get_option('evl_content_back','light');
  $evl_menu_back_color = evl_get_option('evl_menu_back_color','');
  $evl_menu_back = evl_get_option('evl_menu_back','light');
  $evl_custom_main_color = evl_get_option('evl_header_footer_back_color','');
  $evl_main_pattern = evl_get_option('evl_pattern','pattern_8.png');
  $evl_scheme_widgets = evl_get_option('evl_scheme_widgets','#595959');
  $evl_post_layout = evl_get_option('evl_post_layout','two');
  $evl_pos_logo = evl_get_option('evl_pos_logo','left');
  $evl_pos_button = evl_get_option('evl_pos_button','right');
  $evl_custom_background = evl_get_option('evl_custom_background','1');
  $evl_tagline_pos = evl_get_option('evl_tagline_pos','next');    
  $evl_widget_background = evl_get_option('evl_widget_background','0');
  $evl_widget_background_image = evl_get_option('evl_widget_background_image','0');
  $evl_menu_background = evl_get_option('evl_disable_menu_back','0');
  $evl_social_color = evl_get_option('evl_social_color_scheme','#999999');
  $evl_social_icons_size = evl_get_option('evl_social_icons_size','normal');
  $evl_button_color_1 = evl_get_option('evl_button_1','');
  $evl_button_color_2 = evl_get_option('evl_button_2','');
  $evl_scheme_background = evl_get_option('evl_scheme_background', '');
  $evl_scheme_background_100 = evl_get_option('evl_scheme_background_100', '0');
  $evl_scheme_background_repeat = evl_get_option('evl_scheme_background_repeat', 'repeat');
  $evl_general_link = evl_get_option('evl_general_link', '#7a9cad');
  $evl_animatecss = evl_get_option('evl_animatecss', '1');  
  $evl_gmap_address = evl_get_option('evl_gmap_address', '');
  $evl_status_gmap = evl_get_option('evl_status_gmap', '');
  $evl_gmap_width = evl_get_option('evl_gmap_width', '100%');
  $evl_gmap_height = evl_get_option('evl_gmap_height', '415px');
  $evl_width_px = evl_get_option('evl_width_px', '1200');
  $evl_content_box1_icon_color = evl_get_option('evl_content_box1_icon_color', '#faa982');  
  $evl_content_box2_icon_color = evl_get_option('evl_content_box2_icon_color', '#8fb859');
  $evl_content_box3_icon_color = evl_get_option('evl_content_box3_icon_color', '#78665e');    
  $evl_min_width_px = $evl_width_px + 20;
  $evolve_css_data = '';
  
  if($evl_width_px && ($evl_width_layout == "fixed")) { 
  $evolve_css_data .= ' 
  @media (min-width: '.$evl_min_width_px.'px) {
  .container, #wrapper {
    width: '.$evl_width_px.'px!important;
  }
}';
} else {
 $evolve_css_data .= ' 
  @media (min-width: '.$evl_min_width_px.'px) {
  .container {
    width: '.$evl_width_px.'px!important;
  }  
  .menu-back .container {
    width: 100%!important;padding-left:0px!important;padding-right:0px!important;
  }
}'; 
}  

$evolve_css_data .= '';

  
if($evl_gmap_address && $evl_status_gmap):
 $evolve_css_data .= '#gmap{width:'.$evl_gmap_width.';margin:0 auto;';
	if($evl_gmap_height):
	$evolve_css_data .= 'height:'.$evl_gmap_height;
	else:
	$evolve_css_data .= 'height:415px;';
	endif;
  $evolve_css_data .= '}';    
	endif;
 
 
if ($evl_animatecss == "1") { 
 $evolve_css_data .= ' 
 @media only screen and (min-width: 768px){
 .link-effect a:hover span,
.link-effect a:focus span {
	-webkit-transform: translateY(-100%);
	-moz-transform: translateY(-100%);
	transform: translateY(-100%); 
} }

.entry-content .thumbnail-post:hover img {
   -webkit-transform: scale(1.1,1.1);
   -moz-transform: scale(1.1,1.1);
   -o-transform: scale(1.1,1.1);
   -ms-transform: scale(1.1,1.1);
   transform: scale(1.1,1.1);
}
.entry-content .thumbnail-post:hover .mask {
   -ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";
   filter: alpha(opacity=100);
   opacity: 1;
}
.entry-content .thumbnail-post:hover div.icon {
   -ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";
   filter: alpha(opacity=100);
   opacity: 1;
   top:50%;
   margin-top:-21px;
   -webkit-transition-delay: 0.1s;
   -moz-transition-delay: 0.1s;
   -o-transition-delay: 0.1s;
   -ms-transition-delay: 0.1s;
   transition-delay: 0.1s;
}


';
}
 if ($evl_layout == "2cr") { 
  
  $evolve_css_data .= '/**
 * 2 column (aside)(content) fixed layout
 */

 @media (min-width: 768px) {
#primary {float:right;}  
     }

';
   
  } if ($evl_layout == "3cr") { 
  
 $evolve_css_data .= '/**
 * 3 column (aside)(aside)(content) fixed layout
 */

 #secondary, #secondary-2 { float: left; }
 #primary {float:right;}

';
  
  
 } if ($evl_layout == "3cl") { 
 
 $evolve_css_data .= '/**
 * 3 column (aside)(aside)(content) fixed layout
 */      

 #secondary, #secondary-2 { float: right; }

'; 
  
  
} if ($evl_layout == "3cm") { 

 $evolve_css_data .= '/**
 *  3 columns (aside)(content)(aside) fixed layout
 */    
#secondary { float: right; }
#secondary-2 { float: left; } 
';
  
  
} if ($evl_width_layout == "fluid") { 

 $evolve_css_data .= '/**
 * Basic 1 column (content)(aside) fluid layout
 * 
 * @package WPEvoLve
 * @subpackage Layouts
 * @beta
 */


#wrapper {margin:0;width:100%;}

'
;
 
  
} if ($evl_layout == "1c") { 
 
 $evolve_css_data .= '/**
 * 1 column (content) fixed layout
 * 
 * @package WPEvoLve
 * @subpackage Layouts
 * @beta
 */

'; 

} if ($evl_content_back == "dark") { 
 
 
 $evolve_css_data .= '/**
 * Dark content
 * 
 */

body {color:#ddd;}

.entry-title, .entry-title a {color:#ccc;text-shadow:0 1px 0px #000;}
.entry-title, .entry-title a:hover { color: #fff; }

input[type="text"], input[type="password"],input[type="email"], textarea {border:1px solid #111!important;}


#search-text-top {border-color: rgba(0, 0, 0, 0)!important;}

.entry-content img, .entry-content .wp-caption {background:#444;border: 1px solid #404040;}

#slide_holder, .similar-posts {background:rgba(0, 0, 0, 0.2);}

#slide_holder .featured-title a, #slide_holder .twitter-title {color:#ddd;}
#slide_holder .featured-title a:hover {color:#fff;}
#slide_holder .featured-title, #slide_holder .twitter-title, #slide_holder p {text-shadow:0 1px 1px #333;}

#slide_holder .featured-thumbnail {background:#444;border-color:#404040;}   

var, kbd, samp, code, pre {background-color:#505050;}
pre {border-color:#444;}

.post-more, .anythingSlider .arrow span {border-color: #222; border-bottom-color: #111;text-shadow: 0 1px 0 #111;
   color: #aaa;
    background: #505050;               
    background: -webkit-gradient(linear,left top,left bottom,color-stop(.2, #505050),color-stop(1, #404040));
    background: -moz-linear-gradient(center top,#505050 20%,#404040 100%);
    background: -o-linear-gradient(top, #505050,#404040) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#505050\', endColorstr=\'#404040\');
    -webkit-box-shadow:  0 1px 0 rgba(255, 255, 255, 0.3) inset,0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
    -moz-box-shadow:   0 1px 0 rgba(255, 255, 255, 0.3) inset,0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
    box-shadow:   0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
}
a.post-more:hover, .anythingSlider .arrow a:hover span {color:#fff;}
  

.social-title, #reply-title {color:#fff;text-shadow:0 1px 0px #222;}
#social {-webkit-box-shadow:none!important;-moz-box-shadow:none!important;-box-shadow:none!important;box-shadow:none!important;}

.menu-back {border-top-color:#515151;}

.page-title {text-shadow:0 1px 0px #111;}


.hentry .entry-header .comment-count a { background:none !important;-moz-box-shadow:none !important;}

.content-bottom {background:#353535;border-color:#303030; }

.entry-header a {color:#eee;}

.entry-meta {text-shadow:0 1px 0 #111;}

.edit-post a {-moz-box-shadow:0 0 2px #333;color:#333;text-shadow:0 1px 0 #fff;}

.entry-footer a:hover {color:#fff;}

.widget-content {  
  background: #484848;
    border-color: #404040;
    box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;
    -box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
    -webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
     -moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
    color: #FFFFFF;
}

.tab-holder .tabs li a {background:rgba(0, 0, 0, 0.05);}
.tab-holder .tabs li:last-child a {border-right: 1px solid #404040 !important;}
.tab-holder .tabs li a, .tab-holder .news-list li {-webkit-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;-moz-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;}
.tab-holder .tabs li.active a {background:#484848;border-color: #404040 rgba(0, 0, 0, 0) #484848 #404040 !important;color: #eee !important;}
.tab-holder .tabs-container {background:#484848;border: 1px solid #404040 !important;}
.tab-holder .news-list li .post-holder a {color: #eee !important;}
.tab-holder .news-list li:nth-child(2n) {background: rgba(0, 0, 0, 0.05);}
.tab-holder .news-list li {border-bottom: 1px solid #414141;}
.tab-holder .news-list img {background: #393939;border: 1px solid #333;}

.author.vcard .avatar {border-color:#222;}  

.tipsy-inner {-moz-box-shadow:0 0 2px #111;}

#secondary a, #secondary-2 a, .widget-title  {text-shadow:1px 1px 0px #000; }
#secondary a, #secondary-2 a {color: #eee;} 

h1, h2, h3, h4, h5, h6 {color: #eee;}

ul.breadcrumbs {background:#484848;border: 1px solid #404040;-webkit-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;-moz-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;}

ul.breadcrumbs li {color: #aaa;}
ul.breadcrumbs li a {color: #eee;}
ul.breadcrumbs li:after {color: rgba(255,255, 255, 0.2);}

.menu-container, .content, #wrapper {background:#555;}  

.widgets-back h3 {color:#fff !important;text-shadow:1px 1px 0px #000 !important;}
.widgets-back ul, .widgets-back ul ul, .widgets-back ul ul ul {list-style-image:url('.$template_url.'/library/media/images/dark/list-style-dark.gif) !important;}  

.widgets-back a:hover {color:orange}

.widgets-holder a {
    text-shadow: 0 1px 0 #000 !important;
}

#search-text, #search-text-top:focus, #respond input#author, #respond input#url, #respond input#email, #respond textarea {-moz-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.2);-webkit-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.2);-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.2);box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.2);}

.widgets-back .widget-title a {color:#fff !important;text-shadow:0 1px 3px #444 !important;}

.comment, .trackback, .pingback {text-shadow:0 1px 0 #000;background: #505050; border-color: #484848;}
.comment-header {background:#484848;border-bottom: 1px solid #484848;box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;}

.avatar {  background:#444444;border-color: #404040;}

#leave-a-reply {text-shadow:0 1px 1px #333333;}

.entry-content .read-more a, #page-links a {border-color: #222; border-bottom-color: #111;text-shadow: 0 1px 0 #111;
    color: #aaa;
    background: #505050;               
    background: -webkit-gradient(linear,left top,left bottom,color-stop(.2, #505050),color-stop(1, #404040));
    background: -moz-linear-gradient(center top,#505050 20%,#404040 100%);
    background: -o-linear-gradient(top, #505050,#404040);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#505050\', endColorstr=\'#404040\');
    -webkit-box-shadow:  1px 1px 0 rgba(255, 255, 255, 0.1) inset,0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
    -moz-box-shadow:  1px 1px 0 rgba(255, 255, 255, 0.1) inset,0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
    box-shadow:   1px 1px 0 rgba(255, 255, 255, 0.1) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);}

.share-this a { text-shadow:0 1px 0px #111; }
.share-this a:hover {color:#fff;}
.share-this strong {color:#999;border:1px solid #222;text-shadow:0 1px 0px #222;background:#505050;
background:-moz-linear-gradient(center top , #505050 20%, #404040 100%) repeat scroll 0 0 transparent;
   background: -webkit-gradient(linear,left top,left bottom,color-stop(.2, #505050),color-stop(1, #404040)) !important;
    background: -o-linear-gradient(top, #505050,#404040) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#505050\', endColorstr=\'#404040\');
-webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);
-moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);
-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);
box-shadow: 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);
}

.entry-content .read-more {text-shadow: 0 1px 0 #111111;}
.entry-header .comment-count a {color:#aaa;}

a.comment-reply-link {background:#484848;border: 1px solid #404040;
box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
-moz-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
-webkit-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);}
    
.share-this:hover strong {color:#fff;}

.page-navigation .nav-next, .single-page-navigation .nav-next, .page-navigation .nav-previous, .single-page-navigation .nav-previous {color:#777;}
.page-navigation .nav-previous a, .single-page-navigation .nav-previous a, .page-navigation .nav-next a, .single-page-navigation .nav-next a {color:#999999;text-shadow:0 1px 0px #333;}
.page-navigation .nav-previous a:hover, .single-page-navigation .nav-previous a:hover, .page-navigation .nav-next a:hover, .single-page-navigation .nav-next a:hover {color:#eee;}
.icon-big:before {color:#666;}
.page-navigation .nav-next:hover a, .single-page-navigation .nav-next:hover a, .page-navigation .nav-previous:hover a, .single-page-navigation .nav-previous:hover a, .icon-big:hover:before, .btn:hover, .btn:focus {color:#fff;}

/* Page Navi */

.wp-pagenavi a, .wp-pagenavi span {-moz-box-shadow:0 1px 2px #333;background:#555;color:#999999;text-shadow:0 1px 0px #333;}
.wp-pagenavi a:hover, .wp-pagenavi span.current {background:#333;color:#eee;}


#page-links a:hover {background:#333;color:#eee;}

blockquote {color:#bbb;text-shadow:0 1px 0px #000;border-color:#606060;}
blockquote:before, blockquote:after {color: #606060;}

table {background:#505050;border-color: #494949;}
thead, thead th, thead td {background:rgba(0, 0, 0, 0.1);color:#FFFFFF;text-shadow:0 1px 0px #000;}
thead {box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;}
th, td {border-bottom: 1px solid rgba(0, 0, 0, 0.1);border-top: 1px solid rgba(255, 255, 255, 0.02);}    

table#wp-calendar th, table#wp-calendar tbody tr td {color:#888;text-shadow:0 1px 0px #111;}
table#wp-calendar tbody tr td {border-right:1px solid #484848;border-top:1px solid #555;}
table#wp-calendar th {color:#fff;text-shadow:0 1px 0px #111;}
table#wp-calendar tbody tr td a {text-shadow:0 1px 0px #111;}
';




  } if ($evl_menu_back == "dark") { 
  

$evolve_css_data .= 'ul.nav-menu a {color:#fff;text-shadow:0 1px 0px #333; }

ul.nav-menu li.nav-hover ul { background: #505050; }

ul.nav-menu ul li a {border-bottom-color:#484848;}

ul.nav-menu ul li:hover > a, ul.nav-menu li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor > a  {border-top-color:#666!important;}

ul.nav-menu li.current-menu-ancestor li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor li.current-menu-parent > a {border-top-color:#666; }

ul.nav-menu ul {border: 1px solid #444; border-bottom:0;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 2px rgba(255, 255, 255, 0.3) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 2px rgba(255, 255, 255, 0.3) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 2px rgba(255, 255, 255, 0.3) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 2px rgba(255, 255, 255, 0.3) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
}

ul.nav-menu li {border-left-color: #444;border-right-color:  #666;}

.menu-header {background:#505050;
   background:url('.$template_url.'/library/media/images/dark/trans.png) 0px -7px repeat-x, -moz-linear-gradient(center top , #606060 20%, #505050 100%);
   background:url('.$template_url.'/library/media/images/dark/trans.png) 0px -7px repeat-x, -webkit-gradient(linear,left top,left bottom,color-stop(.2, #606060),color-stop(1, #505050)) !important;
    background: url('.$template_url.'/library/media/images/dark/trans.png) 0px -7px repeat-x,-o-linear-gradient(top, #606060,#505050) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#606060\', endColorstr=\'#505050\');
    -webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);
    color:#fff;text-shadow:0 1px 0px #000;
    border-color:#222;  
} 

body #header.sticky-header a.logo-url-text {color:#fff;}

ul.nav-menu ul { box-shadow: 0 1px 0 rgba(255, 255, 255, 0.05) inset, 0 0 2px rgba(255, 255, 255, 0.05) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1)!important;
-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.05) inset, 0 0 2px rgba(255, 255, 255, 0.05) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1)!important;
-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.05) inset, 0 0 2px rgba(255, 255, 255, 0.05) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1)!important;
-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.05) inset, 0 0 2px rgba(255, 255, 255, 0.05) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1)!important;
}

ul.nav-menu li.current-menu-item, ul.nav-menu li.current-menu-ancestor, ul.nav-menu li:hover {border-right-color:#666!important;}

ul.nav-menu > li.current-menu-item, ul.nav-menu > li.current-menu-ancestor, ul.nav-menu li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor > a {background-color:rgba(0, 0, 0, 0.1)!important;}


body #header.sticky-header {background: rgba(80, 80, 80, 0.95) !important;border-bottom: 1px solid rgba(0, 0, 0, 0.5);}
#wrapper .dd-container .dd-selected-text {background: rgba(0, 0, 0, 0.5);box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.1);}
.dd-option {
    border-bottom: 1px solid #404040!important;          
    }
#wrapper .dd-options li { border-bottom: 1px solid #404040 !important; }     
   #wrapper .dd-options {background:#444!important;border-color:#404040!important;}
    #wrapper .dd-container label, #wrapper .dd-container a {color: #eee!important;}
#wrapper .dd-options li a:hover,#wrapper .dd-options li.dd-option-selected a{background-color:#333 !important;color:#fff !important;}

#search-text-top:focus {-webkit-box-shadow:1px 1px 0px rgba(0,0,0,.9);-moz-box-shadow:1px 1px 0px rgba(0,0,0,.9);-box-shadow:1px 1px 0px rgba(0,0,0,.9);box-shadow:1px 1px 0px rgba(0,0,0,.9);}
';






 
 
 if (!empty($evl_menu_back_color)) {
 
 $evl_menu_back_color = substr($evl_menu_back_color,1); 
 
 $evolve_css_data .= 'ul.nav-menu li.nav-hover ul { background: #'.$evl_menu_back_color.'; }

ul.nav-menu ul li:hover > a, ul.nav-menu li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor > a  {border-top-color:#'.$evl_menu_back_color.'!important;}

ul.nav-menu li.current-menu-ancestor li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor li.current-menu-parent > a {border-top-color:#'.$evl_menu_back_color.'; }

ul.nav-menu ul {border: 1px solid #'.evolve_hexDarker($evl_menu_back_color).'; border-bottom:0;}

ul.nav-menu ul li a {border-color: #'.evolve_hexDarker($evl_menu_back_color).'!important;}

ul.nav-menu li {border-left-color: #'.evolve_hexDarker($evl_menu_back_color).';border-right-color:  #'.$evl_menu_back_color.';}

.menu-header {background:#'.$evl_menu_back_color.';
   background:url('.$template_url.'/library/media/images/dark/trans.png) 0px -10px repeat-x,-moz-linear-gradient(center top , #'.$evl_menu_back_color.' 20%, #'.evolve_hexDarker($evl_menu_back_color).' 100%);
   background:url('.$template_url.'/library/media/images/dark/trans.png) 0px -10px repeat-x,-webkit-gradient(linear,left top,left bottom,color-stop(.2, #'.$evl_menu_back_color.'),color-stop(1, #'.evolve_hexDarker($evl_menu_back_color).')) !important;
    background:url('.$template_url.'/library/media/images/dark/trans.png) 0px -10px repeat-x,-o-linear-gradient(top, #'.$evl_menu_back_color.',#'.evolve_hexDarker($evl_menu_back_color).') !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#'.$evl_menu_back_color.'\', endColorstr=\'#'.evolve_hexDarker($evl_menu_back_color).'\');
    border-color:#'.evolve_hexDarker($evl_menu_back_color).';  
} 

body #header.sticky-header {background:#'.$evl_menu_back_color.'!important;
    border-bottom-color:#'.evolve_hexDarker($evl_menu_back_color).';
}


ul.nav-menu li.current-menu-item, ul.nav-menu li.current-menu-ancestor, ul.nav-menu li:hover {border-right-color:#'.$evl_menu_back_color.'!important;}';

   
} } else {


 if (!empty($evl_menu_back_color)) {
 
 $evl_menu_back_color = substr($evl_menu_back_color,1); 
 
 $evolve_css_data .= 'ul.nav-menu li.nav-hover ul { background: #'.$evl_menu_back_color.'; }

ul.nav-menu ul li:hover > a, ul.nav-menu li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor > a  {border-top-color:#'.$evl_menu_back_color.'!important;}

ul.nav-menu li.current-menu-ancestor li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor li.current-menu-parent > a {border-top-color:#'.$evl_menu_back_color.'; }

ul.nav-menu ul {border: 1px solid '.evolve_hexDarker($evl_menu_back_color).'; border-bottom:0;
   }

ul.nav-menu li {border-left-color: '.evolve_hexDarker($evl_menu_back_color).';border-right-color:  #'.$evl_menu_back_color.';}

.menu-header {background:#'.$evl_menu_back_color.';
   background:url('.$template_url.'/library/media/images/trans.png) 0px -10px repeat-x,-moz-linear-gradient(center top , #'.$evl_menu_back_color.' 20%, #'.evolve_hexDarker($evl_menu_back_color).' 100%);
   background:url('.$template_url.'/library/media/images/trans.png) 0px -10px repeat-x,-webkit-gradient(linear,left top,left bottom,color-stop(.2, #'.$evl_menu_back_color.'),color-stop(1, #'.evolve_hexDarker($evl_menu_back_color).')) !important;
    background:url('.$template_url.'/library/media/images/trans.png) 0px -10px repeat-x,-o-linear-gradient(top, #'.$evl_menu_back_color.',#'.evolve_hexDarker($evl_menu_back_color).') !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#'.$evl_menu_back_color.'\', endColorstr=\'#'.evolve_hexDarker($evl_menu_back_color).'\');
    border-color:#'.evolve_hexDarker($evl_menu_back_color).';  
} 
ul.nav-menu li.current-menu-item, ul.nav-menu li.current-menu-ancestor, ul.nav-menu li:hover {border-right-color:#'.$evl_menu_back_color.'!important;}';   
}


     
 
} if (!empty($evl_custom_main_color)) { 

$evolve_css_data .= '
.header, .footer {background:'.$evl_custom_main_color.';}
';

} if ($evl_main_pattern != "none" ) { 

$evolve_css_data .= '
.header, .footer {background-image:url('.$template_url.'/library/media/images/pattern/'.$evl_main_pattern.');}
';


} if ($evl_scheme_widgets != "" ) {


$evl_scheme_color = substr($evl_scheme_widgets,1);     

$evolve_css_data .= '.menu-back {
 background-color:'.$evl_scheme_widgets.'; 
 background: -webkit-gradient(radial, center center, 0, center center, 460, from('.$evl_scheme_widgets.'), to(#'.evolve_hexDarker($evl_scheme_color,40).'));  
 background: -webkit-radial-gradient(circle, '.$evl_scheme_widgets.', #'.evolve_hexDarker($evl_scheme_color,40).');  
 background: -moz-radial-gradient(circle, '.$evl_scheme_widgets.', #'.evolve_hexDarker($evl_scheme_color,40).');  
 background: -o-radial-gradient(circle, '.$evl_scheme_widgets.', #'.evolve_hexDarker($evl_scheme_color,40).');
 background: -ms-radial-gradient(circle, '.$evl_scheme_widgets.', #'.evolve_hexDarker($evl_scheme_color,40).');
}
.da-dots span {background:#'.evolve_hexDarker($evl_scheme_color).'}
';
 } if ($evl_post_layout == "two") { 
  
  $evolve_css_data .= '/**
 * Posts Layout
 * 
 */   

   
.home .type-post .entry-content, .archive .type-post .entry-content, .search .type-post .entry-content, .page-template-blog-page-php .type-post .entry-content {font-size:13px;}
.entry-content {margin-top:25px;}
.home .odd0, .archive .odd0, .search .odd0, .page-template-blog-page-php .odd0 {clear:both;}
.home .odd1, .archive .odd1, .search .odd1, .page-template-blog-page-php .odd1{margin-right:0px;}
.home .entry-title, .entry-title a, .archive .entry-title, .search .entry-title, .page-template-blog-page-php .entry-title {font-size:120%!important;line-height:120%!important;margin-bottom:0;}
.home .entry-header, .archive .entry-header, .search .entry-header, .page-template-blog-page-php .entry-header {font-size:12px;padding:0;}
.home .published strong, .archive .published strong,  .search .published strong, .page-template-blog-page-php .published strong{font-size:15px;line-height:15px;}
.home .type-post .comment-count a, .archive .type-post .comment-count a, .search .type-post .comment-count a, .page-template-blog-page-php .type-post .comment-count a  {color:#bfbfbf;background:url('.$template_url.'/library/media/images/comment.png) 0 9px no-repeat;text-decoration:none;position:relative;bottom:-9px;border:none;padding:8px 10px 8px 18px;}
.home .hfeed, .archive .hfeed, .single .hfeed, .page .hfeed, .page-template-blog-page-php .hfeed {margin-right:0px;}
.home .type-post .entry-footer, .archive .type-post .entry-footer, .search .type-post .entry-footer, .page-template-blog-page-php .type-post .entry-footer {float:left;width:100%}
.home .type-post .comment-count, .archive .type-post .comment-count, .search .type-post .comment-count, .page-template-blog-page-php .type-post .comment-count {background:none!important;padding-right:0;}';
  
 } if ($evl_post_layout == "three") {
  
$evolve_css_data .= '/**
 * Posts Layout
 * 
 */       


.home .type-post .entry-content, .archive .type-post .entry-content, .search .type-post .entry-content, .page-template-blog-page-php .type-post .entry-content {font-size:13px;}
.entry-content {margin-top:25px;}
.home .odd0, .archive .odd0, .search .odd0, .page-template-blog-page-php .odd0 {clear:both;}
.home .odd2, .archive .odd2, .search .odd2, .page-template-blog-page-php .odd2 {margin-right:0px;}
.home .entry-title, .entry-title a, .archive .entry-title, .search .entry-title, .page-template-blog-page-php .entry-title {font-size:100%!important;line-height:100%!important;margin-bottom:0;}
.home .entry-header, .archive .entry-header, .search .entry-header, .page-template-blog-page-php .entry-header {font-size:12px;padding:0;}
.home .published strong, .archive .published strong, .search .published strong, .page-template-blog-page-php .published strong  {font-size:15px;line-height:15px;}
.home .type-post .comment-count a, .archive .type-post .comment-count a, .search .type-post .comment-count a, .page-template-blog-page-php .type-post .comment-count a   {color:#bfbfbf;background:url('.$template_url.'/library/media/images/comment.png) 0 9px no-repeat;text-decoration:none;position:relative;bottom:-9px;border:none;padding:8px 10px 8px 18px;}
.home .type-post .comment-count, .archive .type-post .comment-count, .search .type-post .comment-count, .page-template-blog-page-php .type-post .comment-count {background:none!important;padding-right:0;}';

} 

$blog_title = evl_get_option('evl_title_font');
if ($blog_title) {
 $evolve_css_data .= '#logo, #logo a {font:' . $blog_title['style'] . ' '.$blog_title['size'] . ' ' . $blog_title['face']. '; color:'.$blog_title['color'].';letter-spacing:-.03em;}';
}

$blog_tagline = evl_get_option('evl_tagline_font');
if ($blog_tagline) {
 $evolve_css_data .= '#tagline {font:' . $blog_tagline['style'] . ' '.$blog_tagline['size'] . ' ' . $blog_tagline['face']. '; color:'.$blog_tagline['color'].';}';
}

  if (($evl_tagline_pos !== "disable") && ($evl_tagline_pos == "under")) {
     $evolve_css_data .= '#tagline {clear:left;padding-top:10px;}';
     } 
     
     if (($evl_tagline_pos !== "disable") && ($evl_tagline_pos == "above")) { 
     $evolve_css_data .= '#tagline {padding-top:0px;}';
     }
     
$post_title = evl_get_option('evl_post_font');
if ($post_title) {
 $evolve_css_data .= '.entry-title, .entry-title a, .page-title {font:' . $post_title['style'] . ' '.$post_title['size'] . ' ' . $post_title['face']. '; color:'.$post_title['color'].'!important;}';
}     

$content_font = evl_get_option('evl_content_font');
if ($content_font) {
 $evolve_css_data .= 'body, input, textarea, .entry-content {font:' . $content_font['style'] . ' '.$content_font['size'] . ' ' . $content_font['face']. '!important; color:'.$content_font['color'].';line-height:1.5em;}
  body {color:'.$content_font['color'].'!important;}';
 
 }   
 
$heading_font = evl_get_option('evl_heading_font');
if ($heading_font) {
 $evolve_css_data .= 'h1, h2, h3, h4, h5, h6 {font-family:' . $heading_font['face']. '!important; color:'.$heading_font['color'].'} 
 #content h1, #content h2, #content h3, #content h4, #content h5, #content h6 { color:'.$heading_font['color'].'!important;}';
 }   
 
$menu_font = evl_get_option('evl_menu_font');
if ($menu_font) {
 $evolve_css_data .= 'ul.nav-menu a {font:' . $menu_font['style'] . ' '.$menu_font['size'] . ' ' . $menu_font['face']. '; color:'.$menu_font['color'].'!important;}';
 }   
 
$bootstrap_slide_title = evl_get_option('evl_bootstrap_slide_title_font');
if ($bootstrap_slide_title) {
 $evolve_css_data .= '#bootstrap-slider .carousel-caption h2 {font:' . $bootstrap_slide_title['style'] . ' '.$bootstrap_slide_title['size'] . ' ' . $bootstrap_slide_title['face']. '!important; color:'.$bootstrap_slide_title['color'].';}';
} 

$bootstrap_slide_desc = evl_get_option('evl_bootstrap_slide_desc_font');
if ($bootstrap_slide_desc) {
 $evolve_css_data .= '#bootstrap-slider .carousel-caption p {font:' . $bootstrap_slide_desc['style'] . ' '.$bootstrap_slide_desc['size'] . ' ' . $bootstrap_slide_desc['face']. '; color:'.$bootstrap_slide_desc['color'].';}';
}  
 
$parallax_slide_title = evl_get_option('evl_parallax_slide_title_font');
if ($parallax_slide_title) {
 $evolve_css_data .= '.da-slide h2 {font:' . $parallax_slide_title['style'] . ' '.$parallax_slide_title['size'] . ' ' . $parallax_slide_title['face']. '!important; color:'.$parallax_slide_title['color'].';}';
} 

$parallax_slide_desc = evl_get_option('evl_parallax_slide_desc_font');
if ($parallax_slide_desc) {
 $evolve_css_data .= '.da-slide p {font:' . $parallax_slide_desc['style'] . ' '.$parallax_slide_desc['size'] . ' ' . $parallax_slide_desc['face']. '; color:'.$parallax_slide_desc['color'].';}';
} 

$carousel_slide_title = evl_get_option('evl_carousel_slide_title_font');
if ($carousel_slide_title) {
 $evolve_css_data .= '#slide_holder .featured-title a {font:' . $carousel_slide_title['style'] . ' '.$carousel_slide_title['size'] . ' ' . $carousel_slide_title['face']. '!important; color:'.$carousel_slide_title['color'].';}';
} 

$carousel_slide_desc = evl_get_option('evl_carousel_slide_desc_font');
if ($carousel_slide_desc) {
 $evolve_css_data .= '#slide_holder p {font:' . $carousel_slide_desc['style'] . ' '.$carousel_slide_desc['size'] . ' ' . $carousel_slide_desc['face']. '; color:'.$carousel_slide_desc['color'].';}';
} 
 
if ($evl_pos_logo == "right") { 
 $evolve_css_data .= '#logo-image {float:right;margin:0 0 0 20px;}';
 } if ($evl_pos_button == "left") { 
 $evolve_css_data .= '#backtotop {left:3%;margin-left:0;}';
 } if ($evl_pos_button == "right") { 
 $evolve_css_data .= '#backtotop {right:3%;}';
 } if ($evl_pos_button == "middle" || $evl_pos_button == "") {
 $evolve_css_data .= '#backtotop {left:50%;}';

} if ($evl_custom_background == "1") {

$evolve_css_data .= '#wrapper {position:relative;margin:0 auto 30px auto !important;background:#f9f9f9;box-shadow:0 0 3px rgba(0,0,0,.2);}

#wrapper:before {bottom: -34px;
    background: url('.$template_url.'/library/media/images/shadow.png) no-repeat scroll center top!important;
    left: 0px;
    position: absolute;
    z-index: -1;
    height: 7px;
    bottom: -7px;
    content: "";
    width: 100%;
}
';  

} if ($evl_widget_background == "1") {

$evolve_css_data .= '#content h3.widget-title, h3.widget-title {color:#fff!important;text-shadow:1px 1px 0px #000;}
.widget-title-background {position:absolute;top:-1px;bottom:0px;left:-16px;right:-16px; 
-webkit-border-radius:3px 3px 0 0;-moz-border-radius:3px 3px 0 0;-border-radius:3px 3px 0 0;border-radius:3px 3px 0 0px;border:1px solid #222;
background:#505050;
background:-moz-linear-gradient(center top , #606060 20%, #505050 100%) repeat scroll 0 0 transparent;
   background: -webkit-gradient(linear,left top,left bottom,color-stop(.2, #606060),color-stop(1, #505050)) !important;
    background: -o-linear-gradient(top, #606060,#505050) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#606060\', endColorstr=\'#505050\');
-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);color:#fff;text-shadow:0 1px 0px #000;}';
}

 if ($evl_widget_background_image == "1") {

$evolve_css_data .= '.widget-content {background: none!important;border: none!important;-webkit-box-shadow:none!important;-moz-box-shadow:none!important;-box-shadow:none!important;box-shadow:none!important;}
.widget:after, .widgets-holder .widget:after {content:none!important;}';

} 

 if ($evl_menu_background == "1") {

$evolve_css_data .= '
.menu-header {filter:none;top:0;background: none!important;border: none!important;border-radius:0!important;-webkit-box-shadow:none!important;-moz-box-shadow:none!important;-box-shadow:none!important;box-shadow:none!important;}
.menu-header:before, .menu-header:after {content:none!important;}
ul.nav-menu li {border:none;}
ul.nav-menu li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor > a, ul.nav-menu li a:hover,ul.nav-menu li:hover > a {
    background: none;box-shadow:none;}
ul.nav-menu li.current-menu-item > a:after, ul.nav-menu li.current-menu-ancestor > a:after {content:none;}    
    ';

} 

if ($evl_layout == "2cr" && ($evl_post_layout == "one") || $evl_layout == "2cl" && ($evl_post_layout == "one")) { 
$evolve_css_data .= '
.col-md-8 {padding-left:15px;padding-right:15px;}';
}   

if (!empty($evl_general_link)) {     
$evolve_css_data .= '
a, .entry-content a:link, .entry-content a:active, .entry-content a:visited, #secondary a:hover, #secondary-2 a:hover {color:'.$evl_general_link.';}';
}   


if (!empty($evl_button_color_1)) {

$evl_button_color_1_border = substr($evl_button_color_1,1);     
$evolve_css_data .= '
.entry-content .read-more a, a.comment-reply-link {background:'.$evl_button_color_1.';border-color:#'.evolve_hexDarker($evl_button_color_1_border).'}';
} 


if (!empty($evl_button_color_2)) {

$evl_button_color_2_border = substr($evl_button_color_2,1);     
$evolve_css_data .= '
a.more-link, input[type="submit"], button, .button, input#submit {background:'.$evl_button_color_2.';border-color:#'.evolve_hexDarker($evl_button_color_2_border).'}';
}    

if( get_header_image() ) {   
$evolve_css_data .= '.header {padding:0;} .custom-header {padding:40px 20px 5px 20px!important;width: 985px;min-height:125px;background:url('.get_header_image().') top center no-repeat;border-bottom:0;}';

if ($evl_width_layout == "fluid") { 
$evolve_css_data .= '.header {padding:0;} .custom-header {padding:40px 20px 5px 20px!important;left:-20px;position:relative;min-height:125px;background:url('.get_header_image().') top center no-repeat;border-bottom:0;}';
} 
} 
  
if (!empty($evl_social_color)) {
$evolve_css_data .= '#rss, #email-newsletter, #facebook, #twitter, #instagram, #skype, #youtube, #flickr, #linkedin, #plus { color: '.$evl_social_color.';}';
} 

if (!empty($evl_social_icons_size)) {
$evolve_css_data .= '#rss, #email-newsletter, #facebook, #twitter, #instagram, #skype, #youtube, #flickr, #linkedin, #plus { font-size: '.$evl_social_icons_size.';}';
} 

if ($evl_scheme_background) {
$evolve_css_data .= '.menu-back { background-image: url('.$evl_scheme_background.');background-position:top center;}'; 
}

if ($evl_scheme_background_100 == '1') {
$evolve_css_data .= '.menu-back { background-attachment:fixed;background-position:center center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;}'; 
}

if ($evl_scheme_background_repeat) {
$evolve_css_data .= '.menu-back { background-repeat:'.$evl_scheme_background_repeat.';}'; 
}

if ($evl_content_box1_icon_color) {
$evolve_css_data .= '.content-box-1 i { color:'.$evl_content_box1_icon_color.';}'; 
}
if ($evl_content_box2_icon_color) {
$evolve_css_data .= '.content-box-2 i { color:'.$evl_content_box2_icon_color.';}'; 
}
if ($evl_content_box3_icon_color) {
$evolve_css_data .= '.content-box-3 i { color:'.$evl_content_box3_icon_color.';}'; 
}

$evolve_css_data .= '/* Extra small devices (phones, <768px) */
@media (max-width: 768px) { .da-slide h2, #bootstrap-slider .carousel-caption h2 {font-size:120%!important;letter-spacing:1px; }
#slide_holder .featured-title a {font-size:80%!important;letter-spacing:1px;} 
.da-slide p, #slide_holder p, #bootstrap-slider .carousel-caption p {font-size:90%!important; }
}

/* Small devices (tablets, 768px) */
@media (min-width: 768px) { .da-slide h2 {font-size:180%;letter-spacing:0; }
#slide_holder .featured-title a {font-size:120%;letter-spacing:0; }
.da-slide p, #slide_holder p {font-size:100%; }
}


/* Large devices (large desktops) */
@media (min-width: 992px) { .da-slide h2 {font-size:'.$parallax_slide_title['size'].';line-height:1em; } 
#slide_holder .featured-title a {font-size:'.$carousel_slide_title['size'].';line-height:1em;}
.da-slide p {font-size:'.$parallax_slide_desc['size'].'; }
#slide_holder p {font-size:'.$carousel_slide_desc['size'].';}
 }';

?>