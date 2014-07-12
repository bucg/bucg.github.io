<?php
/**
 * Template: Footer.php
 *
 * @package EvoLve
 * @subpackage Template
 */
?>
		<!--END #content-->
		</div>
    
    	<!--END .container-->
	</div> 
  
  

      	<!--END .content-->
	</div> 
  
  

  
     <!--BEGIN .content-bottom--> 
  <div class="content-bottom">
  
       	<!--END .content-bottom-->
  </div>
			
		<!--BEGIN .footer-->
		<div class="footer">
    
    
   	<!--BEGIN .container-->
	<div class="container container-footer">    
  
  <?php $evl_widgets_footer = evl_get_option('evl_widgets_num','disable');

// if Footer widgets exist

  if (($evl_widgets_footer  == "") || ($evl_widgets_footer  == "disable"))  
{ } else { ?>

<?php 

$evl_footer_css = '';

if ($evl_widgets_footer == "one") { $evl_footer_css = 'widget-one-column col-sm-6'; }

if ($evl_widgets_footer == "two") { $evl_footer_css = 'col-sm-6 col-md-6'; }

if ($evl_widgets_footer == "three") { $evl_footer_css = 'col-sm-6 col-md-4'; }

if ($evl_widgets_footer == "four") { $evl_footer_css = 'col-sm-6 col-md-3'; }

?> 


  <div class="widgets-back-inside row"> 
  
    <div class="<?php echo $evl_footer_css; ?>">
    	<?php	if ( !dynamic_sidebar( 'footer-1' ) ) : ?>
      <?php endif; ?>
      </div>
     
     <div class="<?php echo $evl_footer_css; ?>"> 
      <?php	if ( !dynamic_sidebar( 'footer-2' ) ) : ?>
      <?php endif; ?>
      </div>
    
    <div class="<?php echo $evl_footer_css; ?>">  
	    <?php	if ( !dynamic_sidebar( 'footer-3' ) ) : ?>
      <?php endif; ?>
      </div>      
    
    
    <div class="<?php echo $evl_footer_css; ?>">  
    	<?php	if ( !dynamic_sidebar( 'footer-4' ) ) : ?>
      <?php endif; ?>
      </div>
      
      </div>

        

    
    <?php } ?>


<div class="clearfix"></div> 
  
  <?php $footer_content = evl_get_option('evl_footer_content','<p id=\"copyright\"><span class=\"credits\"><a href=\"http://theme4press.com/evolve-multipurpose-wordpress-theme/\">evolve</a> theme by Theme4Press&nbsp;&nbsp;&bull;&nbsp;&nbsp;Powered by <a href=\"http://wordpress.org\">WordPress</a></span></p>'); 
 if ($footer_content === false) $footer_content = '';
 echo do_shortcode($footer_content);
?>   


 

  
  

			<!-- Theme Hook -->
      
      <?php evlfooter_hooks(); ?> 
      
		  

          	<!--END .container-->  
	</div> 



 
		
		<!--END .footer-->
		</div>

<!--END body-->  



  <?php $evl_pos_button = evl_get_option('evl_pos_button','right');
  if ($evl_pos_button == "disable" || $evl_pos_button == "") { ?>
  
   <?php } else { ?>
   
     <div id="backtotop"><a href="#top" id="top-link"></a></div>   

<?php } ?>

<?php $evl_custom_background = evl_get_option('evl_custom_background','0'); if ($evl_custom_background == "1") { ?>
</div>
<?php } ?>

<?php wp_footer(); ?> 

</body>
<!--END html(kthxbye)-->
</html>