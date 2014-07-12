<?php 

/* Basic plugin definitions */

define('EVL_VERSION', '0.9');

/* Make sure we don't expose any info if called directly */

if ( !function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a little plugin, don't mind me.";
	exit;
}

/* If the user can't edit theme options, no use running this plugin */

add_action('init', 'evolve_rolescheck' );

function evolve_rolescheck () {
	if ( current_user_can( 'edit_theme_options' ) ) {
		// If the user can edit theme options, let the fun begin!
		add_action( 'admin_menu', 'evolve_add_page');
		add_action( 'admin_init', 'evolve_init' );
		add_action( 'admin_init', 'evolve_mlu_init' );
	}
}   

/* Loads the file for option sanitization */

add_action('init', 'evolve_load_sanitization' );

function evolve_load_sanitization() {
	get_template_part( 'library/functions/options-sanitize' );
}

/* 
 * Creates the settings in the database by looping through the array
 * we supplied in options.php.  This is a neat way to do it since
 * we won't have to save settings for headers, descriptions, or arguments.
 *
 * Read more about the Settings API in the WordPress codex:
 * http://codex.wordpress.org/Settings_API
 *
 */

function evolve_init() {

	// Include the required files
	get_template_part( 'library/functions/options-interface' );
	get_template_part( 'library/functions/options-medialibrary-uploader' );
	
	// Loads the options array from the theme
	if ( $optionsfile = locate_template( array('options.php') ) ) {
		get_template_part( $optionsfile );
	}
	else if (file_exists( dirname( __FILE__ ) . '/options.php' ) ) {
    require_once dirname( __FILE__ ) . '/options.php';
	}
	
	$evolve_settings = get_option('evolve');
	
	// Updates the unique option id in the database if it has changed
	evolve_option_name();
	
	// Gets the unique id, returning a default if it isn't defined
	if ( isset($evolve_settings['id']) ) {
		$option_name = $evolve_settings['id'];
	}
	else {
		$option_name = 'evolve';
	}
	
	// If the option has no saved data, load the defaults
	if ( ! get_option($option_name) ) {
		evolve_setdefaults();
	}
	
	// Registers the settings fields and callback
	if (!isset( $_POST['evolve-backup-import'] )) {
		register_setting( 'evolve', $option_name, 'evolve_validate' );
	}
}

/* 
 * Adds default options to the database if they aren't already present.
 * May update this later to load only on plugin activation, or theme
 * activation since most people won't be editing the options.php
 * on a regular basis.
 *
 * http://codex.wordpress.org/Function_Reference/add_option
 *
 */

function evolve_setdefaults() {
	
	$evolve_settings = get_option('evolve');

	// Gets the unique option id
	$option_name = $evolve_settings['id'];
	
	/* 
	 * Each theme will hopefully have a unique id, and all of its options saved
	 * as a separate option set.  We need to track all of these option sets so
	 * it can be easily deleted if someone wishes to remove the plugin and
	 * its associated data.  No need to clutter the database.  
	 *
	 */
	
	if ( isset($evolve_settings['knownoptions']) ) {
		$knownoptions =  $evolve_settings['knownoptions'];
		if ( !in_array($option_name, $knownoptions) ) {
			array_push( $knownoptions, $option_name );
			$evolve_settings['knownoptions'] = $knownoptions;
			update_option('evolve', $evolve_settings);
		}
	} else {
		$newoptionname = array($option_name);
		$evolve_settings['knownoptions'] = $newoptionname;
		update_option('evolve', $evolve_settings);
	}
	
	// Gets the default options data from the array in options.php
	$options = evolve_options();
	
	// If the options haven't been added to the database yet, they are added now
	$values = evl_get_default_values();
	
	if ( isset($values) ) {
		add_option( $option_name, $values ); // Add option with default settings
	}
}

/* Add a subpage called "Theme Options" to the appearance menu. */

if ( !function_exists( 'evolve_add_page' ) ) {
function evolve_add_page() {

global $evlthemename;
    
  $page = add_theme_page("Theme Options", "Theme Options", 'edit_theme_options', 'theme_options', 'evltheme_options_do_page');
	
	// Adds actions to hook in the required css and javascript
	add_action("admin_print_styles-$page",'evolve_load_styles');
	add_action("admin_print_scripts-$page", 'evolve_load_scripts');
	
}
}


/* Loads the CSS */

function evolve_load_styles() {
	wp_enqueue_style('theme-options', EVL_DIRECTORY.'css/theme-options.css');
	wp_enqueue_style('color-picker', EVL_DIRECTORY.'css/colorpicker.css');
  wp_enqueue_style('thickbox', site_url() . '/' . WPINC . '/js/thickbox/thickbox.css');
  wp_enqueue_style('google-fonts', "http://fonts.googleapis.com/css?family=Oswald:r,b|Cabin:r,b,i");
}	

/* Loads the javascript */

function evolve_load_scripts() {

	// Inline scripts from options-interface.php
	add_action('admin_head', 'evl_admin_head');
	
	// Enqueued scripts
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-tabs');  
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('color-picker', EVL_DIRECTORY.'js/colorpicker.js', array('jquery'));
	wp_enqueue_script('options-custom', EVL_DIRECTORY.'js/options-custom.js', array('jquery'));
  wp_enqueue_script('of-medialibrary-uploader', EVL_DIRECTORY .'js/medialibrary-uploader.js', array( 'jquery', 'thickbox' ) );
	wp_enqueue_script('media-upload' );
  wp_enqueue_script('myjquerycookie', EVL_DIRECTORY .'js/jquery-cookie.js', false);

}

function evl_admin_head() {

	// Hook to add custom scripts
	do_action( 'evolve_custom_scripts' );
}

/* 
 * Builds out the options panel.
 *
 * If we were using the Settings API as it was likely intended we would use
 * do_settings_sections here.  But as we don't want the settings wrapped in a table,
 * we'll call our own custom evolve_fields.  See options-interface.php
 * for specifics on how each individual field is generated.
 *
 * Nonces are provided using the settings_fields()
 *
 */

if ( !function_exists( 'evltheme_options_do_page' ) ) {

function evltheme_options_do_page() {
	$return = evolve_fields();
	settings_errors('theme_options');
  
  $evlthemename = "evolve";
  
	?>
    
	<div class="wrap">
  
<a href="http://theme4press.com/evolve-multipurpose-wordpress-theme/" target="_blank"><img style="margin-bottom:20px;float:left;position:relative;top:10px;" width="827" height="133" border="0" alt="evolve - Multipurpose WordPress Theme" src="<?php echo get_template_directory_uri(); ?>/library/functions/images/evolve.jpg"></a>  

<a href="http://wordpress.org/themes/evolve" target="_blank"><img style="margin:20px 0;float:left;" width="645" height="27" border="0" alt="evolve on wordpress" src="<?php echo get_template_directory_uri(); ?>/library/functions/images/rate.png"></a>

			<div style="float:left;margin-left:20px;">
      <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Ftheme4press&amp;width&amp;height=62&amp;colorscheme=light&amp;show_faces=false&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=142475515795503" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:62px;" allowTransparency="true"></iframe>
			</div>
 

  <form id="default_setting_form" method="post" action="options.php" enctype="multipart/form-data">
  
   <div id="t4p_container" style="clear:left;">
   
   
<div id="header">
        <div class="logo">
				<h3><img width="135" height="28" src="<?php echo get_template_directory_uri(); ?>/library/functions/images/logo.png" alt="evolve"></h3>
				<span><?php $evlthemedata = wp_get_theme(); echo $evlthemedata['Version']; ?></span>
			</div>                
        <div class="icon-option"></div>  
			<div class="clear"></div>
		</div> 
    
    	<div id="support-links">
			<ul>
      <li class="home"><a title="Theme Homepage" target="_blank" href="http://theme4press.com/evolve-multipurpose-wordpress-theme/">Theme Homepage</a></li>
      <li class="docs"><a title="Documentation" target="_blank" href="http://theme4press.com/evolve-documentation/">Documentation</a></li>
      <li class="support"><a title="Support Forum" target="_blank" href="http://www.theme4press.com/support/">Support Forum</a></li>
			</ul>
      <input type="submit" class="submit-button button-primary" name="update" value="Save All Changes" />
		</div>

    <div id="tabs" style="clear:both;">   
    <ul class="tabNavigation">
        <li class="layout"><a href="#section-evl-tab-1">General</a></li>
        <li class="header"><a href="#section-evl-tab-4">Header</a></li>        
        <li class="footer"><a href="#section-evl-tab-5">Footer</a></li>
        <li class="typography"><a href="#section-evl-tab-6">Typography</a></li>
        <li class="styling"><a href="#section-evl-tab-10">Styling</a></li>
        <li class="post"><a href="#section-evl-tab-2">Blog</a></li>
        <li class="connect"><a href="#section-evl-tab-3">Social Media Links</a></li>
        <li class="contentboxes"><a href="#section-evl-tab-15">Front Page Content Boxes</a></li>        
        <li class="bootstrap"><a href="#section-evl-tab-14">Bootstrap Slider</a></li>        
        <li class="parallax"><a href="#section-evl-tab-8">Parallax Slider</a></li>
        <li class="posts"><a href="#section-evl-tab-9">Posts Slider</a></li>
        <li class="contact"><a href="#section-evl-tab-13">Contact</a></li>
        <li class="nav"><a href="#section-evl-tab-7">Extra</a></li>
        <li class="css"><a href="#section-evl-tab-11">Custom CSS</a></li>
        <li class="backup"><a href="#section-evl-tab-12">Backup</a></li>
    </ul>
    
    


   <div class="tabContainer">



   

		<form action="options.php" method="post"> 
		<?php settings_fields('evolve'); ?>



		<?php echo $return[0]; /* Settings */ ?>
        
        <?php /* Bottom buttons */ ?>
        
        
        
        
            <div style="clear:both;"></div>  
    
       <div class="save_bar"> 		
				<input type="submit" class="submit-button button-primary" name="update" value="Save All Changes" />   
        <input id="t4pform-reset" name="reset" type="submit" value="Options Reset" class="button submit-button reset-button" onclick="return confirm( 'Click OK to reset all options. All settings will be lost!' );" />
                       

		</form>

</div>
        
     
</form>

 <!-- / #container -->
</div>
</div><!-- / .wrap --> 

<?php
}
}

/** 
 * Validate Options.
 *
 * This runs after the submit/reset button has been clicked and
 * validates the inputs.
 *
 * @uses $_POST['reset']
 * @uses $_POST['update']
 */
function evolve_validate( $input ) {

	/*
	 * Restore Defaults.
	 *
	 * In the event that the user clicked the "Restore Defaults"
	 * button, the options defined in the theme's options.php
	 * file will be added to the option for the active theme.
	 */
	 
	if ( isset( $_POST['reset'] ) ) {
  
	add_settings_error( 'theme_options', 'restore_defaults', __( '<div id="t4p-popup-reset" class="t4p-save-popup"><div class="t4p-save-reset">Options Reset</div></div>', 'evolve' ), 'updated fade' );
	 return evl_get_default_values();
	}

	/*
	 * Udpdate Settings.
	 */
	 
	if ( isset( $_POST['update'] ) ) {
		$clean = array();
		$options = evolve_options();
		foreach ( $options as $option ) {

			if ( ! isset( $option['id'] ) ) {
				continue;
			}

			if ( ! isset( $option['type'] ) ) {
				continue;
			}

			$id = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $option['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST
			if ( 'checkbox' == $option['type'] && ! isset( $input[$id] ) ) {
				$input[$id] = '0';
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST
			if ( 'multicheck' == $option['type'] && ! isset( $input[$id] ) ) {
				foreach ( $option['options'] as $key => $value ) {
					$input[$id][$key] = '0';
				}
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if ( has_filter( 'evl_sanitize_' . $option['type'] ) ) {
				$clean[$id] = apply_filters( 'evl_sanitize_' . $option['type'], $input[$id], $option );
			}
		}

		add_settings_error( 'theme_options', 'save_options', __( '<div id="t4p-popup-save" class="t4p-save-popup"><div class="t4p-save-reset">Options Updated</div></div>', 'evolve' ), 'updated fade' );
		return $clean;
	}

	/*
	 * Request Not Recognized.
	 */
	
	return evl_get_default_values();
}

/**
 * Format Configuration Array.
 *
 * Get an array of all default values as set in
 * options.php. The 'id','std' and 'type' keys need
 * to be defined in the configuration array. In the
 * event that these keys are not present the option
 * will not be included in this function's output.
 *
 * @return    array     Rey-keyed options configuration array.
 *
 * @access    private
 */
 
function evl_get_default_values() {
	$output = array();
	$config = evolve_options();
	foreach ( (array) $config as $option ) {
		if ( ! isset( $option['id'] ) ) {
			continue;
		}
		if ( ! isset( $option['std'] ) ) {
			continue;
		}
		if ( ! isset( $option['type'] ) ) {
			continue;
		}
		if ( has_filter( 'evl_sanitize_' . $option['type'] ) ) {
			$output[$option['id']] = apply_filters( 'evl_sanitize_' . $option['type'], $option['std'], $option );
		}
	}
	return $output;
}

/**
 * Add Theme Options menu item to Admin Bar.
 */
 
add_action( 'wp_before_admin_bar_render', 'evolve_adminbar' );

function evolve_adminbar() {
	
	global $wp_admin_bar;
	
	$wp_admin_bar->add_menu( array(
		'parent' => 'appearance',
		'id' => 'evl_theme_options',
		'title' => __( 'Theme Options', 'evolve' ),
		'href' => admin_url( 'themes.php?page=theme_options' )
  ));
}

if ( ! function_exists( 'evl_get_option' ) ) {

	/**
	 * Get Option.
	 *
	 * Helper function to return the theme option value.
	 * If no value has been saved, it returns $default.
	 * Needed because options are 
    as serialized strings.
	 */
	 
	function evl_get_option( $name, $default = false ) {
		$config = get_option( 'evolve' );

		if ( ! isset( $config['id'] ) ) {
			return $default;
		}

		$options = get_option( $config['id'] );

		if ( isset( $options[$name] ) ) {
			return $options[$name];
		}

		return $default;
	}
}