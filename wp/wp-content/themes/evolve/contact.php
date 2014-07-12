<?php
/**
 * Template Name: Contact 
 *
 * @package EvoLve
 * @subpackage Template
 */
 
 get_header(); 
 $evl_recaptcha_public = evl_get_option('evl_recaptcha_public','');
 $evl_recaptcha_private = evl_get_option('evl_recaptcha_private','');
 $evl_email_address = evl_get_option('evl_email_address','');
 $evl_sent_email_header = evl_get_option('evl_sent_email_header',get_bloginfo('name')); 
?>  

<?php 

//If the form is submitted
if(isset($_POST['submit'])) {
	//Check to make sure that the name field is not empty
	if(trim($_POST['contact_name']) == '' || trim($_POST['contact_name']) == 'Name (required)') {
		$hasError = true;
	} else {
		$name = trim($_POST['contact_name']);
	}

	//Subject field is not required
	if(function_exists('stripslashes')) {
		$subject = stripslashes(trim($_POST['url']));
	} else {
		$subject = trim($_POST['url']);
	}

	//Check to make sure sure that a valid email address is submitted
	if(trim($_POST['email']) == '' || trim($_POST['email']) == 'Email (required)')  {
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	//Check to make sure comments were entered
	if(trim($_POST['msg']) == '' || trim($_POST['msg']) == 'Message') {
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['msg']));
		} else {
			$comments = trim($_POST['msg']);
		}
	}

	if((function_exists('recaptcha_get_html')) && ($evl_recaptcha_public && $evl_recaptcha_private)) {
		$resp = recaptcha_check_answer ($evl_recaptcha_private,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
		if(!$resp->is_valid) {
			$hasError = true;
		}
	}   

	//If there is no error, send the email
	if(!isset($hasError)) {
  
		$name = wp_filter_kses( $name );
		$email = wp_filter_kses( $email );
		$subject = wp_filter_kses( $subject );
		$comments = wp_filter_kses( $comments );  
  
		$emailTo = $evl_email_address; //Put your own email address here
    $emailFrom = $sent_email_header;    
		$body = __('Name:', 'evolve')." $name \n\n";
		$body .= __('Email:', 'evolve')." $email \n\n";
		$body .= __('Subject:', 'evolve')." $subject \n\n";
		$body .= __('Comments:', 'evolve')."\n $comments";
		$headers .= 'Reply-To: ' . $name . ' <' . $email . '>' . "\r\n";
    
    if($evl_sent_email_header) {
    $headers .= 'From: '. $emailFrom . ' <' . $email . '>' . "\r\n";
    } else {
    $headers .= 'From: '. $emailTo . ' <' . $email . '>' . "\r\n";
    }      

		$mail = wp_mail($emailTo, $subject, $body, $headers);
		
		$emailSent = true;
	}
	if($emailSent == true) {
		$_POST['contact_name'] = '';
		$_POST['email'] = '';
		$_POST['url'] = '';
		$_POST['msg'] = '';
	}    
}
?>
    
    			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed full-width contact-page">
  
  
  
  
  
    <?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>

				<!--BEGIN .hentry-->
				<div id="post-<?php the_ID(); ?>" class="<?php semantic_entries(); ?>"> 
				<h1 class="entry-title"><?php if ( get_the_title() ){ the_title(); }else{ } ?></h1>  
                    
                    <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>
       
						<?php edit_post_link( __( 'EDIT', 'evolve' ), '<span class="edit-page">', '</span>' ); ?>
            
				
                    <?php endif; ?>

					<!--BEGIN .entry-content .article-->
					<div class="entry-content article">
						<?php the_content(); ?>
            
            	<?php if(isset($hasError)) { //If errors are found ?>
					<div class="alert alert-danger"><i class="fa fa-ban"></i> <?php echo __("Please check if you've filled all the fields with valid information. Thank you.", 'evolve'); ?></div>
					<br />
				<?php } ?>

				<?php if(isset($emailSent) && $emailSent == true) { //If email is sent ?>
					<div class="alert alert-success"><i class="fa fa-check"></i> <?php echo __('Thank you', 'evolve'); ?> <strong><?php echo $name;?></strong> <?php echo __('for using my contact form! Your email was successfully sent!', 'evolve'); ?></div></div>
					<br />
				<?php } ?>
			</div>
			<form action="" method="post">
					
					<div id="comment-input">

						<div class="col-sm-4 col-md-4 padding-l"><input type="text" name="contact_name" id="author" value="<?php if(isset($_POST['contact_name']) && !empty($_POST['contact_name'])) { echo $_POST['contact_name']; } ?>" placeholder="<?php echo __('Name (required)', 'evolve'); ?>" size="22" tabindex="1" aria-required="true" class="input-name"></div>

						<div class="col-sm-4 col-md-4 padding-l"><input type="text" name="email" id="email" value="<?php if(isset($_POST['email']) && !empty($_POST['email'])) { echo $_POST['email']; } ?>" placeholder="<?php echo __('Email (required)', 'evolve'); ?>" size="22" tabindex="2" aria-required="true" class="input-email"></div>
					                     
						<div class="col-sm-4 col-md-4 padding-l"><input type="text" name="url" id="url" value="<?php if(isset($_POST['url']) && !empty($_POST['url'])) { echo $_POST['url']; } ?>" placeholder="<?php echo __('Subject', 'evolve'); ?>" size="22" tabindex="3" class="input-website"></div>
						
					</div>
          
          <div class="clearfix"></div>
					
					<div id="comment-textarea" class="col-md-12">
						
						<textarea name="msg" id="comment" cols="39" rows="4" tabindex="4" class="textarea-comment" placeholder="<?php echo __('Message', 'evolve'); ?>"><?php if(isset($_POST['msg']) && !empty($_POST['msg'])) { echo $_POST['msg']; } ?></textarea>
					
					</div>
          
          <div class="clearfix"></div>

					<?php if((function_exists('recaptcha_get_html')) && ($evl_recaptcha_public && $evl_recaptcha_private)): ?>

					<div id="comment-recaptcha">

					<?php echo recaptcha_get_html($evl_recaptcha_public); ?>

					</div>

					<?php endif; ?>
					
					<div id="comment-submit">

						<p><div><input name="submit" type="submit" id="submit" tabindex="5" value="<?php echo __('Send Message', 'evolve'); ?>"></div></p>			
					</div>

			</form>
            
            
            
            
            
					<!--END .entry-content .article-->
          <div class="clearfix"></div> 
					
          
             

					<!-- Auto Discovery Trackbacks
					<?php trackback_rdf(); ?>
					-->
				<!--END .hentry-->
				</div>
        
               <?php $evl_share_this = evl_get_option('evl_share_this','single'); if (($evl_share_this == "all")) { 
        evolve_sharethis();  } ?>
        
				<?php comments_template( '', true ); ?>

			<?php endwhile; endif; ?> 
  
  
  
  
  
 	<!--END #primary .hfeed-->
			</div> 
  
  

	<?php get_footer(); ?>