<?php
/**
 * Template: Sidebar.php
 *
 * @package EvoLve
 * @subpackage Template
 */
 
 $evl_layout = evl_get_option('evl_layout','2cl');
 
?>
        <!--BEGIN #secondary-2 .aside-->
        <div id="secondary-2" class="aside <?php if (($evl_layout == "1c")) {} if (($evl_layout == "3cm" || $evl_layout == "3cl" || $evl_layout == "3cr")) {echo 'col-xs-12 col-sm-6 col-md-3';} else {echo 'col-sm-6 col-md-4';} ?>">
    
			<?php	/* Widgetized Area */
					if ( !dynamic_sidebar( 'sidebar-2' )) : ?>



     <!--BEGIN #widget-pages-->
            
				<?php evlwidget_before_widget(); ?><?php evlwidget_before_title(); ?><?php _e( 'Pages', 'evolve' ); ?><?php evlwidget_after_title(); ?>
				<ul>
					<?php wp_list_pages('title_li='); ?> 
				</ul>
          <?php evlwidget_after_widget(); ?> 
            <!--END #widget-pages-->
			

                         <!--BEGIN #widget-categories-->
          
				<?php evlwidget_before_widget(); ?><?php evlwidget_before_title(); ?><?php _e( 'Categories', 'evolve' ); ?><?php evlwidget_after_title(); ?>
				<ul>
					<?php wp_list_categories( 'title_li=' ); ?>
				</ul>
                    <?php evlwidget_after_widget(); ?>    
                        <!--END #widget-categories-->
 
 
                            <!--BEGIN #widget-feeds-->
         
				<?php evlwidget_before_widget(); ?><?php evlwidget_before_title(); ?><?php _e( 'RSS Syndication', 'evolve' ); ?><?php evlwidget_after_title(); ?>
				<ul>
					<li><a href="<?php bloginfo( 'rss2_url' ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ), 1 ) ?> Posts RSS feed" rel="alternate" type="application/rss+xml"><?php _e( 'All posts', 'evolve' ); ?></a></li>
					<li><a href="<?php bloginfo( 'comments_rss2_url' ); ?>" title="<?php echo esc_html( bloginfo( 'name' ), 1 ) ?> Comments RSS feed" rel="alternate" type="application/rss+xml"><?php _e( 'All comments', 'evolve' ); ?></a></li>
				</ul>
                <?php evlwidget_after_widget(); ?> 
                     <!--END #widget-feeds-->

          
			<?php endif; /* (!function_exists('dynamic_sidebar') */ ?>
		<!--END #secondary-2 .aside-->
 
		</div>
    
