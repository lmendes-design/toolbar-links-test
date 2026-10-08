<?php
/**
 * Plugin Name: Toolbar Links Test
 * Plugin URI:  https://github.com/lmendes-design/toolbar-links-test
 * Description: Test plugin for Trac #66258. The W always goes to the Dashboard and the site name always goes to the site, in the admin, in the editors and on the front end. Deactivate to get the current behavior back.
 * Version:     1.0.0
 * Requires at least: 7.1
 * Requires PHP: 7.4
 * Author:      Lucas Mendes
 * Author URI:  https://profiles.wordpress.org/lucasmdo/
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: toolbar-links-test
 *
 * @package toolbar-links-test
 */

defined( 'ABSPATH' ) || exit;

/**
 * W menu: adds Dashboard as the first item.
 *
 * Runs right before wp_admin_bar_wp_menu() (priority 10), so the node sits
 * before About WordPress. The same `read` check Core uses for the About link.
 *
 * @param WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance.
 */
function tlt_wp_menu_dashboard( $wp_admin_bar ) {
	if ( ! current_user_can( 'read' ) ) {
		return;
	}

	$wp_admin_bar->add_node(
		array(
			'parent' => 'wp-logo',
			'id'     => 'dashboard',
			'title'  => __( 'Dashboard' ),
			'href'   => self_admin_url(),
		)
	);
}
add_action( 'admin_bar_menu', 'tlt_wp_menu_dashboard', 9 );

/**
 * W click: the W always goes to the Dashboard.
 *
 * Runs after wp_admin_bar_site_menu() (priority 30). On the front end that
 * function moves the Dashboard node under the site name, so it is re-added
 * under the W here. The node keeps its position, so it stays first.
 *
 * @param WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance.
 */
function tlt_wp_menu_link( $wp_admin_bar ) {
	if ( ! current_user_can( 'read' ) || ! $wp_admin_bar->get_node( 'wp-logo' ) ) {
		return;
	}

	$wp_admin_bar->add_node(
		array(
			'id'    => 'wp-logo',
			'title' => '<span class="ab-icon" aria-hidden="true"></span><span class="screen-reader-text">' .
					/* translators: Hidden accessibility text. */
					__( 'Dashboard' ) .
				'</span>',
			'href'  => self_admin_url(),
			'meta'  => array(
				'menu_title' => __( 'Dashboard' ),
			),
		)
	);

	$wp_admin_bar->add_node(
		array(
			'parent' => 'wp-logo',
			'id'     => 'dashboard',
			'title'  => __( 'Dashboard' ),
			'href'   => self_admin_url(),
		)
	);
}
add_action( 'admin_bar_menu', 'tlt_wp_menu_link', 31 );

/**
 * Site name: the same link and the same menu in every context.
 *
 * Runs right after wp_admin_bar_site_menu() (priority 30). The capability
 * checks are the ones Core uses for each item.
 *
 * @param WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance.
 */
function tlt_site_menu( $wp_admin_bar ) {
	if ( ! $wp_admin_bar->get_node( 'site-name' ) ) {
		return;
	}

	// The Network Admin and the User Dashboard keep their own site name node.
	if ( is_network_admin() || is_user_admin() ) {
		return;
	}

	// Click: the site name always goes to the site.
	$wp_admin_bar->add_node(
		array(
			'id'   => 'site-name',
			'href' => home_url( '/' ),
		)
	);

	// Menu: remove the items Core adds per context.
	$core_items = array( 'view-site', 'edit-site', 'appearance', 'themes', 'widgets', 'menus', 'background', 'header', 'plugins' );
	foreach ( $core_items as $id ) {
		$wp_admin_bar->remove_node( $id );
	}

	// Then add the same items everywhere.
	$wp_admin_bar->add_node(
		array(
			'parent' => 'site-name',
			'id'     => 'view-site',
			'title'  => __( 'Visit Site' ),
			'href'   => home_url( '/' ),
		)
	);

	if ( is_multisite() && current_user_can( 'manage_sites' ) ) {
		$wp_admin_bar->add_node(
			array(
				'parent' => 'site-name',
				'id'     => 'edit-site',
				'title'  => __( 'Manage Site' ),
				'href'   => network_admin_url( 'site-info.php?id=' . get_current_blog_id() ),
			)
		);
	}

	if ( ! current_user_can( 'read' ) ) {
		return;
	}

	if ( current_user_can( 'activate_plugins' ) ) {
		$wp_admin_bar->add_node(
			array(
				'parent' => 'site-name',
				'id'     => 'plugins',
				'title'  => __( 'Plugins' ),
				'href'   => admin_url( 'plugins.php' ),
			)
		);
	}

	// Themes, plus Widgets, Menus, Background and Header on classic themes.
	wp_admin_bar_appearance_menu( $wp_admin_bar );
}
add_action( 'admin_bar_menu', 'tlt_site_menu', 31 );

/**
 * Two small style changes.
 *
 * 1. The same default icon (house) everywhere when the site has no site icon.
 *    Core shows a gauge on the front end.
 * 2. The W stays visible under 600px. Core hides it there, but it is now the
 *    way to the Dashboard.
 */
function tlt_styles() {
	if ( ! is_admin_bar_showing() ) {
		return;
	}

	wp_add_inline_style(
		'admin-bar',
		'#wpadminbar #wp-admin-bar-site-name:not(.has-site-icon) > .ab-item:before { content: "\f102"; content: "\f102" / ""; }' .
		'@media screen and (max-width: 600px) { #wpadminbar li#wp-admin-bar-wp-logo { display: block; } }'
	);
}
add_action( 'wp_enqueue_scripts', 'tlt_styles', 20 );
add_action( 'admin_enqueue_scripts', 'tlt_styles', 20 );
