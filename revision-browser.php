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
function revisions_browser() {
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
	$links = sprintf( '
		<style>
			#revision-browser-nav {
				padding:2rem;
				margin:1rem 0;
				color:#fff;
				background-color:#000;
				text-align:center;
			}
			#revision-browser-heading {
				font-size: 3rem;
				margin: 0 0 1.5rem;
			}
			#revision-browser-heading > span {
				color:goldenrod;
			}
			#revision-browser-nav a {
				color:goldenrod;
				margin:3rem;
			}
		</style>

		<div id="revision-browser-nav">
			<h3 id="revision-browser-heading">%s <span></span></h3>
			<div>
				<a href="#" id="revision-browser-prev">%s</a>
				<a href="#" id="revision-browser-next">%s</a>
			</div>
		</div>',
		esc_html__( 'REVISIONS: ' ), esc_html__( '← PREVIOUS' ), esc_html__( 'LATEST REVISION!' ) );

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


