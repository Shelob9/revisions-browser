<?php
/**
 * Plugin Name: Revision Browser
 * Plugin URI: https://github.com/Shelob9/revisions-browser
 * Description: Browse single post revisions via WP REST API.
 * Author: shelob9, mrahmadawais
 * Version: 0.1.1
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package RBR
 */

// Enqueue the script.
add_action( 'wp_enqueue_scripts', 'revisions_browser' );

/**
 * Main function for revision browser.
 *
 * @since  0.1.0
 */
function revisions_browser(){
	// Dont' show to non editors.
	if ( ! current_user_can( 'edit_posts' ) ) {
		return;
	}

	// Let's just do single post view because POC.
	if ( ! is_single() ) {
		return;
	}

	wp_enqueue_script( 'revision-browser', plugin_dir_url(__FILE__) . '/revision-browser.js', [ 'jquery' ] );

	$selectors = wp_parse_args( get_theme_support( 'revision-browser-selectors' ), array(
		'content' => 'entry-content',
		'title'   => 'entry-title',
	) );

	// This is bad UI I know. Pull requests welcome.
	$links = sprintf( '<p style="color:#fff;background-color:#000;" id="revision-browser-nav">%s <a href="#" id="revision-browser-next">%s</a> <a href="#" id="revision-browser-prev">%s</a>', esc_html__( 'Revisions' ), esc_html__( 'Next' ), esc_html__( 'Previous' ) );

	global  $post;
	if ( ! is_object( $post ) ) {
		return;
	}

	// Building the URL.
	$api = add_query_arg( array(
		'_wpnonce' => wp_create_nonce( 'wp_rest' ),
		'context'  => 'view'
	), rest_url( sprintf( 'wp/v2/posts/%d/revisions', $post->ID ) )  );

	// REVBROWSER object.
	wp_localize_script( 'revision-browser', 'REVBROWSER', [
		'api'     => esc_url( $api ),
		'nonce'   => wp_create_nonce( 'wp_rest' ),
		'content' => $selectors[ 'content' ],
		'title'   => $selectors[ 'title' ],
		'links'   => $links,
	]);
};


