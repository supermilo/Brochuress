<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

// Actions after theme activation
add_action( 'admin_init', 'us_theme_activation', 99 );
function us_theme_activation() {
	global $pagenow;
	if ( is_admin() AND $pagenow == 'themes.php' AND isset( $_GET['activated'] ) ) {
		// Set menu
		$user = wp_get_current_user();
		update_user_option( $user->ID, US_THEMENAME . '_cpt_in_menu_set', FALSE, TRUE );

		// Redirect to About the Theme page
		header( 'Location: ' . admin_url( 'admin.php?page=us-home' ) );
	}
}

// Hide some our metaboxes on Menus admin page
add_action( 'admin_head', 'us_include_cpt_to_menu', 99 );
function us_include_cpt_to_menu() {
	global $pagenow;
	if ( is_admin() AND $pagenow == 'nav-menus.php' ) {
		$already_set = get_user_option( US_THEMENAME . '_cpt_in_menu_set' );

		if ( ! $already_set ) {
			$hidden_meta_boxes = get_user_option( 'metaboxhidden_nav-menus' );

			if ( ! is_array( $hidden_meta_boxes ) ) {
				$hidden_meta_boxes = array();
			}

			if ( $hidden_meta_boxes !== FALSE ) {
				if ( ( $key = array_search( 'add-post-type-us_portfolio', $hidden_meta_boxes ) ) !== FALSE AND isset( $hidden_meta_boxes[$key] ) ) {
					unset( $hidden_meta_boxes[$key] );
				}
				if ( ( $key = array_search( 'add-us_portfolio_category', $hidden_meta_boxes ) ) === FALSE ) {
					$hidden_meta_boxes[] = 'add-us_portfolio_category';
				}
				if ( ( $key = array_search( 'add-us_portfolio_tag', $hidden_meta_boxes ) ) === FALSE ) {
					$hidden_meta_boxes[] = 'add-us_portfolio_tag';
				}

				$user = wp_get_current_user();
				update_user_option( $user->ID, 'metaboxhidden_nav-menus', $hidden_meta_boxes, TRUE );
				update_user_option( $user->ID, US_THEMENAME . '_cpt_in_menu_set', TRUE, TRUE );
			}
		}
	}
}

// Custom CSS for all admin pages
add_action( 'admin_print_scripts', 'us_enqueue_admin_css', 12 );
function us_enqueue_admin_css() {
	global $us_template_directory_uri;
	wp_enqueue_style( 'us-theme-admin', $us_template_directory_uri . '/common/admin/css/theme-admin.css', array(), US_THEMEVERSION );
	wp_enqueue_style( 'us-font-awesome', $us_template_directory_uri . '/common/css/base/fontawesome.css', array(), US_THEMEVERSION );
	wp_enqueue_style( 'us-font-awesome-duotone', $us_template_directory_uri . '/common/css/base/fontawesome-duotone.css', array(), US_THEMEVERSION );

	do_action('us_theme_icon');
}

if ( ! function_exists( 'us_theme_icon' ) ) {

	add_action( 'us_theme_icon', 'us_theme_icon', 10 );
	function us_theme_icon() {

		global $us_template_directory_uri;
		$img_src = $us_template_directory_uri . '/img/us-core.png';

		if ( defined( 'US_CORE_VERSION' ) AND us_get_option( 'white_label', 0 ) AND ! empty ( us_get_option( 'white_label_theme_icon', '' ) )) {

			$icon_id = us_get_option( 'white_label_theme_icon', '' );
			$img_src = wp_get_attachment_image_src( $icon_id, 'post-thumbnails' );
			$img_src = $img_src[0];
		}
		?>
		<style>
			/* UpSolution icon for the WP admin menu */
			.menu-icon-generic.toplevel_page_us-theme-options .wp-menu-image,
			.menu-icon-generic.toplevel_page_us-home .wp-menu-image {
				background: url(<?= $img_src ?>) no-repeat center 6px / 22px auto !important;
			}
			.menu-icon-generic.toplevel_page_us-theme-options .wp-menu-image:before,
			.menu-icon-generic.toplevel_page_us-home .wp-menu-image:before {
				display: none;
			}
		</style>
		<?php
	}
}
