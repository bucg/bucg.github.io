<?php
/**
 * Template: Index.php
 *
 * @package EvoLve
 * @subpackage Template
 */

get_header();
?>



    <?php $xyz = ""; 
    $evl_layout = evl_get_option('evl_layout','2cl');
    $evl_post_layout = evl_get_option('evl_post_layout','two');
    $evl_nav_links = evl_get_option('evl_nav_links','after');
    $evl_header_meta = evl_get_option('evl_header_meta','single_archive');
    $evl_excerpt_thumbnail = evl_get_option('evl_excerpt_thumbnail','0');
    $evl_share_this = evl_get_option('evl_share_this','single');
    $evl_post_links = evl_get_option('evl_post_links','after');
    $evl_similar_posts = evl_get_option('evl_similar_posts','disable');
    $evl_featured_images = evl_get_option('evl_featured_images','1');
    
    
  if (($evl_layout == "1c"))  
  
  
    { ?>
  
  
  <?php } else { ?>

  <?php $options = get_option('evolve');
  
  if((is_page() || is_single()) && get_post_meta($post->ID, 'evolve_full_width', true) == 'yes'): 
  
  else:
  
  if ($evl_layout == "3cm" || $evl_layout == "3cl" || $evl_layout == "3cr") { ?> 
  
  <?php get_sidebar('2'); ?>     
  
  <?php } ?>
  
  <?php endif; ?>
  
    <?php } ?>  



			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="<?php if ($evl_layout == "1c") {echo ' col-md-12';} 
      
      else {echo ' col-xs-12 col-sm-6'; if (($evl_layout == "2cr" && ($evl_post_layout == "two") || $evl_layout == "2cl" && ($evl_post_layout == "two"))) { echo ' col-md-8';}  if (($evl_layout == "3cm" || $evl_layout == "3cl" || $evl_layout == "3cr")) {echo ' col-md-6';} else {echo ' col-md-8'; }  if ( is_single() || is_page() ) { echo ' col-single';  } } ?>
      
      <?php
      $content_css = '';
    	if(get_post_meta($post->ID, 'evolve_full_width', true) == 'yes'):        
			$content_css = ' full-width';
		  echo $content_css;endif;?>">
      

      <?php 
      $evl_breadcrumbs = evl_get_option('evl_breadcrumbs','1'); 
      if ($evl_breadcrumbs == "1"):     
      if (!is_home() || !is_front_page()): evolve_breadcrumb();
      endif;            
      endif; ?>
     
 
 <!---------------------- 
 ---- attachment begin
 ----------------------->  


 <?php if (is_attachment()) { ?>
      
      
     <?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
				
				<!--BEGIN .hentry-->
				<div id="post-<?php the_ID(); ?>" class="<?php semantic_entries(); ?>">

            <?php $options = get_option('evolve'); if (($evl_header_meta == "") || ($evl_header_meta == "single_archive")) 
        { ?>
        
        <h1 class="entry-title"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment" class="attach-font"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php if ( get_the_title() ){ the_title();
 } ?></h1>
        
        
        	
	<!--BEGIN .entry-meta .entry-header-->
					<div class="entry-meta entry-header">
          <a href="<?php the_permalink() ?>"><span class="published updated"><?php the_time(get_option('date_format')); ?></span></a>
 
          <?php if ( comments_open() ) : ?>           
          <span class="comment-count"><?php comments_popup_link( __( 'Leave a Comment', 'evolve' ), __( '1 Comment', 'evolve' ), __( '% Comments', 'evolve' ) ); ?></span>
          <?php else : // comments are closed 
           endif; ?>
         
          
          <span class="author vcard">
          
          <?php $evl_author_avatar = evl_get_option('evl_author_avatar','0');
          if ($evl_author_avatar == "1") { echo get_avatar( get_the_author_meta('email'), '30' ); } ?>
          
          

          <?php _e( 'By', 'evolve' ); ?> <strong><?php printf( '<a class="url fn" href="' . get_author_posts_url( $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( 'View all posts by %s', $authordata->display_name ) . '">' . get_the_author() . '</a>' ) ?></strong></span>
						
						<?php edit_post_link( __( 'edit', 'evolve' ), '<span class="edit-post">', '</span>' ); ?>

					<!--END .entry-meta .entry-header-->
                    </div>
                    
                     <?php } else { ?>
                    
                    <h1 class="entry-title"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h1>
                    
                     <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>
       
				    <?php edit_post_link( __( 'EDIT', 'evolve' ), '<span class="edit-post edit-attach">', '</span>' ); ?>
                    <?php endif; ?>

                    <?php } ?>
					
					<!--BEGIN .entry-content .article-->
					<div class="entry-content article">
				
     
							<?php if ( wp_attachment_is_image() ) :
	$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
	foreach ( $attachments as $k => $attachment ) {
		if ( $attachment->ID == $post->ID )
			break;
	}
	$k++;
	// If there is more than 1 image attachment in a gallery
	if ( count( $attachments ) > 1 ) {
		if ( isset( $attachments[ $k ] ) )
			// get the URL of the next image attachment
			$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
		else
			// or get the URL of the first image attachment
			$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	} else {
		// or, if there's only 1 image attachment, get the URL of the image
		$next_attachment_url = wp_get_attachment_url();
	}
?>
						<p class="attachment" align="center"><a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" class="single-gallery-image"><?php
							echo wp_get_attachment_image( $post->ID, $size='medium' ); // filterable image width with, essentially, no limit for image height.
						?></a></p>

						
			
              
              <div class="navigation-links single-page-navigation clearfix row">
<div class="col-sm-6 col-md-6 nav-previous"><?php previous_image_link ( false, '<div class="btn btn-left icon-arrow-left icon-big">Previous Image</div>' ); ?></div>              
	<div class="col-sm-6 col-md-6 nav-next"><?php next_image_link ( false, '<div class="btn btn-right icon-arrow-right icon-big">Next Image</div>' ); ?></div>
	
<!--END .navigation-links-->
	</div>
  
  
<?php else : ?>
						<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
<?php endif; ?>

<div class="entry-caption"><?php if ( !empty( $post->post_excerpt ) ) the_excerpt(); ?></div>
         
			

					 <!--END .entry-content .article-->
           <div class="clearfix"></div> 
					</div>
				<!--END .hentry-->
				</div>

         <?php $options = get_option('evolve'); if (($evl_share_this == "single_archive") || ($evl_share_this == "all")) { 
        evolve_sharethis();  } else { ?> <div class="margin-40"></div> <?php }?>
        
        
				<?php comments_template( '', true ); ?>
                
				<?php endwhile; else : ?>

				<!--BEGIN #post-0-->
				<div id="post-0" class="<?php semantic_entries(); ?>">
					<h1 class="entry-title">Not Found</h1>

					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p>Sorry, no attachments matched your criteria.</p>
					<!--END .entry-content-->
					</div>
				<!--END #post-0-->
				</div>
        
         <!---------------------- 
 ---- attachment end
 ----------------------->  

			<?php endif; ?>      

 <!---------------------- 
 ---- single post begin
 ----------------------->     
      
 <?php } elseif (is_single()) { ?>
 
 
 <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                
                 <?php $options = get_option('evolve'); if (($evl_post_links == "before") || ($evl_post_links == "both")) { ?>
          
          
         <span class="nav-top">
				<?php get_template_part( 'navigation', 'index' ); ?>
        </span>
        
        <?php } ?> 

				<!--BEGIN .hentry-->
				<div id="post-<?php the_ID(); ?>" class="<?php semantic_entries(); ?> col-md-12">
					



          <?php $options = get_option('evolve'); if (($evl_header_meta == "") || ($evl_header_meta == "single") || ($evl_header_meta == "single_archive")) 
        { ?>  <h1 class="entry-title"><?php if ( get_the_title() ){ the_title(); } ?></h1>
        
        
					<!--BEGIN .entry-meta .entry-header-->
					<div class="entry-meta entry-header">
          <a href="<?php the_permalink() ?>"><span class="published updated"><?php the_time(get_option('date_format')); ?></span></a>
 
          <?php if ( comments_open() ) : ?>           
          <span class="comment-count"><?php comments_popup_link( __( 'Leave a Comment', 'evolve' ), __( '1 Comment', 'evolve' ), __( '% Comments', 'evolve' ) ); ?></span>
          <?php else : // comments are closed 
           endif; ?>
         
          
          <span class="author vcard">
          
          <?php $evl_author_avatar = evl_get_option('evl_author_avatar','0');
          if ($evl_author_avatar == "1") { echo get_avatar( get_the_author_meta('email'), '30' );
          
          } ?>
          
          

          <?php _e( 'Written by', 'evolve' ); ?> <strong><?php printf( '<a class="url fn" href="' . get_author_posts_url( $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( 'View all posts by %s', $authordata->display_name ) . '">' . get_the_author() . '</a>' ) ?></strong></span>
						
						
            				    <?php edit_post_link( __( 'edit', 'evolve' ), '<span class="edit-post">', '</span>' ); ?>
					<!--END .entry-meta .entry-header-->
                    </div>   <?php } else { ?>
                    
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    
                     <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>
       
						<?php edit_post_link( __( 'EDIT', 'evolve' ), '<span class="edit-post edit-attach">', '</span>' ); ?>
            
                        				    
				
                    <?php endif; ?>

                    <?php } ?>
                 
      
			<!--BEGIN .entry-content .article-->
					<div class="entry-content article">
						<?php the_content( __('READ MORE &raquo;', 'evolve' ) ); ?>
            <?php wp_link_pages( array( 'before' => '<div id="page-links"><p>' . __( '<strong>Pages:</strong>', 'evolve' ), 'after' => '</p></div>' ) ); ?>
					<!--END .entry-content .article-->
					
          <div class="clearfix"></div> 
          </div>
          
          
						<!--BEGIN .entry-meta .entry-footer-->
                    <div class="entry-meta entry-footer row">
                    <div class="col-md-6">
                    
                    	<?php if ( evolve_get_terms( 'cats' ) ) { ?>
                    	<div class="entry-categories"> <?php echo evolve_get_terms( 'cats' ); ?></div>
                      <?php } ?>
						<?php if ( evolve_get_terms( 'tags' ) ) { ?>
                                                <div class="entry-tags"> <?php echo evolve_get_terms( 'tags' ); ?></div>
                        <?php } ?>
					<!--END .entry-meta .entry-footer-->
          
          </div>
          
          <div class="col-md-6">          
           <?php $options = get_option('evolve'); if (($evl_share_this == "") || ($evl_share_this == "single") || ($evl_share_this == "single_archive")  || ($evl_share_this == "all")) { 
        evolve_sharethis(); } else { ?> <div class="margin-40"></div> <?php }?>
        </div>
        
                    </div>
                    
                    
                                   
                    <!-- Auto Discovery Trackbacks
					<?php trackback_rdf(); ?>
					-->
				<!--END .hentry-->
				</div>
        
     
        
        
        
        
<?php $options = get_option('evolve'); if (($evl_similar_posts == "") || ($evl_similar_posts == "disable")) {} else {
evlsimilar_posts(); } ?>  

       
        <?php $options = get_option('evolve'); if (($evl_post_links == "") || ($evl_post_links == "after") || ($evl_post_links == "both")) { ?>
               
				<?php get_template_part( 'navigation', 'index' ); ?>

        
        <?php } ?>   

				<?php comments_template( '', true ); ?>
                
				<?php endwhile; else : ?>

				<!--BEGIN #post-0-->
				<div id="post-0" class="<?php semantic_entries(); ?>">
					<h1 class="entry-title"><?php _e( 'Not Found', 'evolve' ); ?></h1>
          
          

					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'evolve' ); ?></p>
						<?php get_search_form(); ?>
					<!--END .entry-content-->
					</div>
				<!--END #post-0-->
				</div>

			<?php endif; ?>

 <!---------------------- 
 ---- single post end
 -----------------------> 


 <!---------------------- 
 ---- home/date/category/tag/search/author begin
 ----------------------->         
      
      <?php } elseif (is_home() || is_date() || is_category() || is_tag() || is_search() || is_author()) { ?>
 
 
 
 <!---------------------- 
 ---- 2 or 3 columns begin
 ----------------------->
 

 
      <?php if (is_date()) { ?> 
      
      
      	<?php /* If this is a daily archive */ if ( is_day() ) { ?>
				<h2 class="page-title archive-title"><?php _e( 'Daily archives for', 'evolve' ); ?> <span class="daily-title updated"><?php the_time( 'F jS, Y' ); ?></span></h2>
        				<?php /* If this is a monthly archive */ } elseif ( is_month() ) { ?>
				<h2 class="page-title archive-title"><?php _e( 'Monthly archives for', 'evolve' ); ?> <span class="monthly-title updated"><?php the_time( 'F, Y' ); ?></span></h2>
				<?php /* If this is a yearly archive */ } elseif ( is_year() ) { ?>
				<h2 class="page-title archive-title"><?php _e( 'Yearly archives for', 'evolve' ); ?> <span class="yearly-title updated"><?php the_time( 'Y' ); ?></span></h2>
				<?php } ?>
        
      <?php } elseif (is_category()) { ?> 
    <h2 class="page-title archive-title"><?php _e( 'Posts in category', 'evolve' ); ?> <span id="category-title"><?php single_cat_title(); ?></span></h2>

      
       <?php } elseif (is_tag()) { ?> 
       <h2 class="page-title archive-title"><?php _e( 'Posts tagged', 'evolve' ); ?> <span id="tag-title"><?php single_tag_title(); ?></span></h2>
       
       
       <?php } elseif (is_search()) { ?>
       
       
       <h2 class="page-title search-title"><?php _e( 'Search results for', 'evolve' ); ?> <?php echo '<span class="search-term">'.the_search_query().'</span>'; ?></h2>
       
          <?php } elseif (is_author()) { ?>
       
       
       <h2 class="page-title archive-title"><?php _e( 'Posts by', 'evolve' ); ?> <span class="author-title"><?php the_post(); echo $authordata->display_name; rewind_posts(); ?></span></h2>
       
       <?php } ?>
 
  <?php $options = get_option('evolve'); if ($evl_post_layout == "two" || $evl_post_layout == "three") { ?>      
    
    
       <?php if (($evl_nav_links == "before") || ($evl_nav_links == "both")) { ?>
          
          
        
				   <span class="nav-top">
				<?php get_template_part( 'navigation', 'index' ); ?>
        </span>
        
        <?php } else {?> 
        
        <?php } ?>         
    
   
      
			<?php if ( have_posts() ) : ?>
      
      
 
      
      
                <?php while ( have_posts() ) : the_post(); ?>
        
        
				<!--BEGIN .hentry-->
				<div id="post-<?php the_ID(); ?>" class="<?php semantic_entries(); if ($evl_post_layout == "two") { echo ' col-md-6 odd'.($xyz++%2); } else { echo ' col-md-4 odd'.($xyz++%3); } ?> <?php if (has_post_format( array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'),'')) { echo 'formatted-post'; } ?> margin-40">
        
        
        
          <?php $options = get_option('evolve'); if (($evl_header_meta == "") || ($evl_header_meta == "single_archive")) 
        { ?>
        
					<h1 class="entry-title">
          
          
         
          <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
<?php
if ( get_the_title() ){ $title = the_title('', '', false);
echo evltruncate($title, 40, '...'); } ?></a> 
          
          
          
          </h1>

					<!--BEGIN .entry-meta .entry-header-->
					<div class="entry-meta entry-header">
          <a href="<?php the_permalink() ?>"><span class="published updated"><?php the_time(get_option('date_format')); ?></span></a>
          <span class="author vcard">
 
          <?php _e( 'Written by', 'evolve' ); ?> <strong><?php printf( '<a class="url fn" href="' . get_author_posts_url( $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( 'View all posts by %s', $authordata->display_name ) . '">' . get_the_author() . '</a>' ) ?></strong></span>
						
						 <?php edit_post_link( __( 'edit', 'evolve' ), '<span class="edit-post">', '</span>' ); ?>

					<!--END .entry-meta .entry-header-->
                    </div>
                    
                  <?php } else { ?>
                    
                    <h1 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
<?php
if ( get_the_title() ){ $title = the_title('', '', false);
echo evltruncate($title, 40, '...'); }
 ?></a> </h1>
                    
                     <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>
       
						<?php edit_post_link( __( 'EDIT', 'evolve' ), '<span class="edit-post edit-attach">', '</span>' ); ?>
            
            
				
                    <?php endif; ?>

                    <?php } ?> 

					<!--BEGIN .entry-content .article-->
					<div class="entry-content article">
          
          
          <?php if ($evl_featured_images == "1") { ?>
          
            <?php          
if(has_post_thumbnail()) {
	echo '<span class="thumbnail-post"><a href="'; the_permalink(); echo '">';the_post_thumbnail('post-thumbnail'); echo '  
  <div class="mask"> 
     <div class="icon"></div> 
     </div>  
  
  </a></span>';
  
     } else {

                      $image = evlget_first_image(); 
                        if ($image):
                      echo '<span class="thumbnail-post"><a href="'; the_permalink(); echo'"><img src="'.$image.'" alt="';the_title();echo'" />
                       <div class="mask"> 
     <div class="icon"></div> 
     </div> 
     </a></span>';
                      
                       else:                         
                      echo '<span class="thumbnail-post"><a href="'; the_permalink(); echo'"><img src="'.get_template_directory_uri().'/library/media/images/no-thumbnail.jpg" alt="';the_title();echo'" />
                       <div class="mask"> 
     <div class="icon"></div> 
     </div> 
     </a></span>'; 
                      
                       endif;
               } ?>
               <?php } ?>
               

          
          <?php $postexcerpt = get_the_content();
$postexcerpt = apply_filters('the_content', $postexcerpt);
$postexcerpt = str_replace(']]>', ']]&gt;', $postexcerpt);
$postexcerpt = strip_tags($postexcerpt);
$postexcerpt = strip_shortcodes($postexcerpt);

echo evltruncate($postexcerpt, 350, ' [...]');
 ?>
          
          
          <div class="entry-meta entry-footer">
          
          <div class="read-more btn btn-right icon-arrow-right">
           <a href="<?php the_permalink(); ?>"><?php _e('READ MORE', 'evolve' ); ?></a> 
           </div>
          
           <?php if ( comments_open() ) : ?>           
          <span class="comment-count"><?php comments_popup_link( __( 'Leave a Comment', 'evolve' ), __( '1 Comment', 'evolve' ), __( '% Comments', 'evolve' ) ); ?></span>
          <?php else : // comments are closed 
           endif; ?>
          </div>

					<!--END .entry-content .article-->
          <div class="clearfix"></div> 
					</div>
          
          

				<!--END .hentry-->
				</div>   
        
        <?php $i='';$i++; ?> 

				<?php endwhile; ?>
				<?php get_template_part( 'navigation', 'index' ); ?>
				<?php else : ?>
        
        
        
        <?php if (is_search()) { ?>
        
        
        	<!--BEGIN #post-0-->
				<div id="post-0" class="<?php semantic_entries(); ?>">
					<h1 class="entry-title"><?php _e( 'Your search for', 'evolve' ); ?> "<?php echo the_search_query(); ?>" <?php _e( 'did not match any entries', 'evolve' ); ?></h1>
					
					<!--BEGIN .entry-content-->
					<div class="entry-content">
				<br />
						<p><?php _e( 'Suggestions:', 'evolve' ); ?></p>
						<ul>
							<li><?php _e( 'Make sure all words are spelled correctly.', 'evolve' ); ?></li>
							<li><?php _e( 'Try different keywords.', 'evolve' ); ?></li>
							<li><?php _e( 'Try more general keywords.', 'evolve' ); ?></li>
						</ul>
					<!--END .entry-content-->
					</div>
				<!--END #post-0-->
				</div>
        
        <?php } else { ?>

				<!--BEGIN #post-0-->
				<div id="post-0" class="<?php semantic_entries(); ?>">
					<h1 class="entry-title"><?php _e( 'Not Found', 'evolve' ); ?></h1>

					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'evolve' ); ?></p>
							<!--END .entry-content-->
					</div>
				<!--END #post-0-->
				</div>   
        
        <?php } ?>

			<?php endif; ?>
           
      
<!---------------------- 
 -----------------------
 -----------------------  
 ---- 2 or 3 columns end
 -----------------------
 -----------------------
 ----------------------->  
 
 
 <!---------------------- 
 -----------------------
 -----------------------  
 ---- 1 column begin
 -----------------------
 -----------------------
 -----------------------> 
  
  
  <?php } else { ?>    
     
      <?php  if (($evl_nav_links == "before") || ($evl_nav_links == "both")) { ?>
          
          
        
				   <span class="nav-top">
				<?php get_template_part( 'navigation', 'index' ); ?>
        </span>
        
        <?php } else {?> 
        
        <?php } ?> 
         

      
			<?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                
                
                  


				<!--BEGIN .hentry-->
				<div id="post-<?php the_ID(); ?>" class="<?php semantic_entries(); ?> <?php if (has_post_format( array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'),'') || is_sticky()) { echo 'formatted-post formatted-single margin-40'; } ?>">
					


          <?php  if (($evl_header_meta == "") || ($evl_header_meta == "single_archive")) 
        { ?>
        
        <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php if ( get_the_title() ){ the_title();} ?></a></h1>
        
					<!--BEGIN .entry-meta .entry-header-->
					<div class="entry-meta entry-header">
          <a href="<?php the_permalink() ?>"><span class="published updated"><?php the_time(get_option('date_format')); ?></span></a>
          
           <?php if ( comments_open() ) : ?>           
          <span class="comment-count"><a href="<?php comments_link(); ?>"><?php comments_popup_link( __( 'Leave a Comment', 'evolve' ), __( '1 Comment', 'evolve' ), __( '% Comments', 'evolve' ) ); ?></a></span>
          <?php else : // comments are closed 
           endif; ?>
          
          <span class="author vcard">
          
          <?php $evl_author_avatar = evl_get_option('evl_author_avatar','0');
          if ($evl_author_avatar == "1") { echo get_avatar( get_the_author_meta('email'), '30' );
          
          } ?>
          
          

          <?php _e( 'Written by', 'evolve' ); ?> <strong><?php printf( '<a class="url fn" href="' . get_author_posts_url( $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( 'View all posts by %s', $authordata->display_name ) . '">' . get_the_author() . '</a>' ) ?></strong></span>
						
						
						
            <?php edit_post_link( __( 'edit', 'evolve' ), '<span class="edit-post">', '</span>' ); ?>
					<!--END .entry-meta .entry-header-->
                    </div>
                    
                    <?php } else { ?>
                    
                    <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php if ( get_the_title() ){ the_title();} ?></a></h1>
                    
                     <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>
       
						<?php edit_post_link( __( 'EDIT', 'evolve' ), '<span class="edit-post edit-attach">', '</span>' ); ?>
            
				
                    <?php endif; ?>

                    <?php } ?>

					<!--BEGIN .entry-content .article-->
					<div class="entry-content article">
          
          
         
           
           <?php if ($evl_featured_images == "1") { ?> 
           
             <?php          
if(has_post_thumbnail()) {
	echo '<span class="thumbnail-post"><a href="'; the_permalink(); echo '">';the_post_thumbnail('post-thumbnail'); echo '  
  <div class="mask"> 
     <div class="icon"></div> 
     </div>  
  
  </a></span>';
  
     } else {

                      $image = evlget_first_image(); 
                        if ($image):
                      echo '<span class="thumbnail-post"><a href="'; the_permalink(); echo'"><img src="'.$image.'" alt="';the_title();echo'" />
                       <div class="mask"> 
     <div class="icon"></div> 
     </div> 
     </a></span>';
                      
                       else:                         
                      echo '<span class="thumbnail-post"><a href="'; the_permalink(); echo'"><img src="'.get_template_directory_uri().'/library/media/images/no-thumbnail.jpg" alt="';the_title();echo'" />
                       <div class="mask"> 
     <div class="icon"></div> 
     </div> 
     </a></span>'; 
                      
                       endif;
               } ?>
               <?php } ?>
               
                  <?php if (($evl_excerpt_thumbnail == "1")) { ?>
          
          <?php the_excerpt();?>
 
          
           <div class="read-more btn btn-right icon-arrow-right">
           <a href="<?php the_permalink(); ?>"><?php _e('READ MORE', 'evolve' ); ?></a>
           </div>
           
          <?php } else { ?>
          
          
						<?php the_content( __('READ MORE &raquo;', 'evolve' ) ); ?>
            
            <?php wp_link_pages( array( 'before' => '<div id="page-links"><p>' . __( '<strong>Pages:</strong>', 'evolve' ), 'after' => '</p></div>' ) ); ?>
            
            <?php } ?>
						
					<!--END .entry-content .article--> 
          <div class="clearfix"></div>                     
					</div>
          
          
          
					<!--BEGIN .entry-meta .entry-footer-->
         
                     <div class="entry-meta entry-footer row">
                    <div class="col-md-6">
                     <?php if ( evolve_get_terms( 'cats' ) ) { ?>
                    	<div class="entry-categories"> <?php echo evolve_get_terms( 'cats' ); ?></div>
                      <?php } ?>
						<?php if ( evolve_get_terms( 'tags' ) ) { ?>
                        
                        <div class="entry-tags"> <?php echo evolve_get_terms( 'tags' ); ?></div>
                        <?php } ?>
					<!--END .entry-meta .entry-footer-->
                         </div>
                         
                         <div class="col-md-6">
          <?php  if (($evl_share_this == "single_archive") || ($evl_share_this == "all")) { 
        evolve_sharethis();  } else { ?> <div class="margin-40"></div> <?php }?>
                         </div>
                    </div>
                   
				<!--END .hentry-->
				</div>
        
        
       
      
         
      <?php comments_template(); ?>  
       

				<?php endwhile; ?>
        
        
        <?php  if (($evl_nav_links == "") || ($evl_nav_links == "after") || ($evl_nav_links == "both")) { ?>
          
          
        
				<?php get_template_part( 'navigation', 'index' ); ?>
        
        <?php } else {?>
        
        <?php } ?>
        
				<?php else : ?>

		     <?php if (is_search()) { ?>
        
        
        	<!--BEGIN #post-0-->
				<div id="post-0" class="<?php semantic_entries(); ?>">
			
    		<h1 class="entry-title"><?php _e( 'Your search for', 'evolve' ); ?> "<?php echo the_search_query(); ?>" <?php _e( 'did not match any entries', 'evolve' ); ?></h1>
					
					<!--BEGIN .entry-content-->
					<div class="entry-content">
				<br />
						<p><?php _e( 'Suggestions:', 'evolve' ); ?></p>
						<ul>
							<li><?php _e( 'Make sure all words are spelled correctly.', 'evolve' ); ?></li>
							<li><?php _e( 'Try different keywords.', 'evolve' ); ?></li>
							<li><?php _e( 'Try more general keywords.', 'evolve' ); ?></li>
						</ul>
					<!--END .entry-content-->
					</div>
				<!--END #post-0-->
				</div>
        
        <?php } else { ?>

				<!--BEGIN #post-0-->
				<div id="post-0" class="<?php semantic_entries(); ?>">
					<h1 class="entry-title"><?php _e( 'Not Found', 'evolve' ); ?></h1>

					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'evolve' ); ?></p>
            
            
            
							<!--END .entry-content-->
					</div>
				<!--END #post-0-->
				</div>   
        
        <?php } ?>

			<?php endif; ?>
      
      
      
      <?php } ?>
      
 <!---------------------- 
 -----------------------
 -----------------------  
 ---- 1 column end
 -----------------------
 -----------------------
 ----------------------->       
      
<!---------------------- 
  -----------------------
  -----------------------
  ---- home/date/category/tag/search/author end
  -----------------------
  -----------------------
  -----------------------> 
      
      <?php } elseif (is_page()) { ?>
      
      
      <?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>

				<!--BEGIN .hentry-->
				<div id="post-<?php the_ID(); ?>" class="<?php semantic_entries(); ?>"> 
				<h1 class="entry-title"><?php if ( get_the_title() ){ the_title(); } ?></h1>  
                    
                    <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>
       
						<?php edit_post_link( __( 'EDIT', 'evolve' ), '<span class="edit-page">', '</span>' ); ?>
            
				
                    <?php endif; ?>

                    

					<!--BEGIN .entry-content .article-->
					<div class="entry-content article">
						<?php the_content( __('READ MORE &raquo;', 'evolve' ) ); ?>
					<!--END .entry-content .article-->
          <div class="clearfix"></div> 
					</div>
          
             

					<!-- Auto Discovery Trackbacks
					<?php trackback_rdf(); ?>
					-->
				<!--END .hentry-->
				</div>
        
               <?php  if (($evl_share_this == "all")) { 
        evolve_sharethis();  } ?>
        
				<?php comments_template( '', true ); ?>

			<?php endwhile; endif; ?>
   
   
   
      <?php } elseif (is_404()) { ?>
     
     	<!--BEGIN #post-0-->
				<div id="post-0" class="<?php semantic_entries(); ?>">
           <h1 class="entry-title"><?php _e( 'Not Found', 'evolve' ); ?></h1>

					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'evolve' ); ?></p>
            
            
					<!--END .entry-content-->
					</div>
				<!--END #post-0-->
				</div> 
      
        
      
      <?php } ?>


			<!--END #primary .hfeed-->
			</div>
      
      <?php 
  if (($evl_layout == "1c"))  
  
  
    { ?>
  
  
  <?php } else { ?>  

  <?php if((is_page() || is_single()) && get_post_meta($post->ID, 'evolve_full_width', true) == 'yes'):
  
  else: ?> 

<?php get_sidebar(); ?>

<?php endif; ?>

<?php } ?>

<?php get_footer(); ?>