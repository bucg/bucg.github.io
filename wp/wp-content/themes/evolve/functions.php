<?php

$evlthemename = "evolve";

if ( get_stylesheet_directory() == get_template_directory() ) {
	define('EVL_URL', get_template_directory() . '/library/functions/');
	define('EVL_DIRECTORY', get_template_directory_uri() . '/library/functions/');
} else {
	define('EVL_URL', get_template_directory() . '/library/functions/');
	define('EVL_DIRECTORY', get_template_directory_uri() . '/library/functions/');
}

get_template_part( 'library/functions/options-framework' );
get_template_part( 'library/functions/basic-functions' ); 
get_template_part( 'library/functions/options' );

?>