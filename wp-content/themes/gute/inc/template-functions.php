<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package gute
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function gute_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'gute_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function gute_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'gute_pingback_header' );


if ( ! function_exists( 'gute_inline_css' ) ) :
function gute_inline_css() {
    $header_textcolor = get_theme_mod( 'header_textcolor', '000000');
        $style = '';
   
                // archive header style 
      if ($header_textcolor != '000000' ){
                $style .= '.site-branding a.text-logo,.site-description{color:#'.$header_textcolor.'}';
         }
 


        wp_add_inline_style( 'gute-style', $style );
}
add_action( 'wp_enqueue_scripts', 'gute_inline_css' );
endif;
