<?php
/*
Plugin Name:	Oxygen Rank Math
Plugin URI:		https://github.com/srikat/oxygen-rank-math
Description:	Enables Rank Math to analyze content added via Oxygen editor.
Version:		1.0.1
Author:			Sridhar Katakam
Author URI:		https://wpdevdesign.com
License:		GPL-2.0+
License URI:	http://www.gnu.org/licenses/gpl-2.0.txt

This plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

This plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with This plugin. If not, see {URI to Plugin License}.
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'admin_enqueue_scripts', 'orm_load_rank_math_integration' );
/**
 * Loads rank-math-integration.js on post.php admin pages.
 */
function orm_load_rank_math_integration() {

	// if Oxygen is not active, abort.
	if ( ! function_exists( 'oxygen_vsb_current_user_can_access' ) ) {
		return;
	}

	// if Rank Math is not active, abort.
	if ( ! class_exists( 'RankMath' ) ) {
		return;
	}

	global $pagenow;
	global $post;

	// save global $post to restore later.
	$saved_post = $post;

	// exclude templates.
	if ( is_object( $post ) && 'ct_template' === $post->post_type ) {
		return;
	}

	if ( 'post.php' === $pagenow && ! is_null( $post ) ) {
		wp_enqueue_script( 'rank-math-integration', plugin_dir_url( __FILE__ ) . 'assets/js/rank-math-integration.js', array( 'rank-math-post-metabox' ), false, true );

		wp_localize_script( 'rank-math-integration', 'rm_data', array(
			'oxygen_markup' => do_shortcode( get_post_meta( $post->ID, 'ct_builder_shortcodes', true ) )
		) );
	}

	// restore original global post
	$post = $saved_post;

}
