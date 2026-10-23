<?php
/**
 * Plugin Name: Toolbar Links Test
 * Plugin URI:  https://github.com/lmendes-design/toolbar-links-test
 * Description: Four prototypes for Trac #66258, the W and the site name in the Toolbar. Pick one in Settings > General or with the TLT_PROTOTYPE constant. Deactivate to get the current behavior back.
 * Version:     2.0.0
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
 * The prototypes.
 *
 * 1. The W goes to the Dashboard, the site name goes to the site. Same menus everywhere.
 * 2. Everything under the site name. The site name goes to the site, Dashboard is the
 *    first item of its menu, same menu everywhere. The W does not change.
 * 3. Dashboard always in the site name menu. The click works as today, Dashboard is
 *    always in the menu, in the admin and in the editors too. The W does not change.
 * 4. The W moves to the end of the Toolbar. The site name is the first item and works
 *    like prototype 3. The W menu moves next to the account menu.
 *
 * @return array<int, array{label: string, description: string}>
 */
function tlt_prototypes() {
	return array(
		1 => array(
			'label'       => __( 'Prototype 1: the W goes to the Dashboard, the site name goes to the site', 'toolbar-links-test' ),
			'description' => __( 'Dashboard is the first item of the W menu. The site name menu is the same everywhere: Visit Site, Plugins, Themes. The W stays visible on small screens.', 'toolbar-links-test' ),
		),
		2 => array(
			'label'       => __( 'Prototype 2: everything under the site name', 'toolbar-links-test' ),
			'description' => __( 'The site name goes to the site. Its menu is the same everywhere: Dashboard, Visit Site, Plugins, Themes. The W does not change.', 'toolbar-links-test' ),
		),
		3 => array(
			'label'       => __( 'Prototype 3: Dashboard always in the site name menu', 'toolbar-links-test' ),
			'description' => __( 'The site name click works as today. Dashboard is always in its menu, in the admin and in the editors too. The W does not change.', 'toolbar-links-test' ),
		),
		4 => array(
			'label'       => __( 'Prototype 4: the W moves to the end of the Toolbar', 'toolbar-links-test' ),
			'description' => __( 'The site name is the first item and works like prototype 3. The W menu moves next to the account menu.', 'toolbar-links-test' ),
		),
	);
}

/**
 * The active prototype, 1 to 4.
 *
 * The TLT_PROTOTYPE constant wins (Playground blueprints define it). Then the
 * option set in Settings > General. Default is 1, so the first Playground link
 * shared in the Make Core post keeps working.
 *
 * @return int
 */
function tlt_prototype() {
	static $prototype = null;

	if ( null !== $prototype ) {
		return $prototype;
	}

	if ( defined( 'TLT_PROTOTYPE' ) ) {
		$prototype = (int) TLT_PROTOTYPE;
	} else {
		$prototype = (int) get_option( 'tlt_prototype', 1 );
	}

	if ( ! isset( tlt_prototypes()[ $prototype ] ) ) {
		$prototype = 1;
	}

	return $prototype;
}

/**
 * Whether the current screen is the Post Editor or the Site Editor.
 *
 * Both are admin screens for WordPress, so Core gives them the admin version
 * of the site name menu. This helper only exists to document the context in
 * the code below.
 *
 * @return bool
 */
function tlt_is_editor() {
	if ( ! is_admin() ) {
		return false;
	}

	global $pagenow;

	return in_array( $pagenow, array( 'post.php', 'post-new.php', 'site-editor.php' ), true );
}

/* -------------------------------------------------------------------------
 * The W
 * ---------------------------------------------------------------------- */

/**
 * Prototype 1. W menu: adds Dashboard as the first item.
 *
 * Runs right before wp_admin_bar_wp_menu() (priority 10), so the node sits
 * before About WordPress. The same `read` check Core uses for the About link.
 *
 * @param WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance.
 */
function tlt_wp_menu_dashboard( $wp_admin_bar ) {
	if ( 1 !== tlt_prototype() || ! current_user_can( 'read' ) ) {
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
 * Prototype 1. W click: the W always goes to the Dashboard.
 *
 * Runs after wp_admin_bar_site_menu() (priority 30). On the front end that
 * function moves the Dashboard node under the site name, so it is re-added
 * under the W here. The node keeps its position, so it stays first.
 *
 * @param WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance.
 */
function tlt_wp_menu_link( $wp_admin_bar ) {
	if ( 1 !== tlt_prototype() || ! current_user_can( 'read' ) || ! $wp_admin_bar->get_node( 'wp-logo' ) ) {
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
 * Prototype 4. The W moves to the end of the Toolbar.
 *
 * The node keeps its id, title, link and menu. Only the parent changes to the
 * right side group, next to the account menu. Children follow the id.
 *
 * @param WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance.
 */
function tlt_wp_menu_move( $wp_admin_bar ) {
	if ( 4 !== tlt_prototype() || ! $wp_admin_bar->get_node( 'wp-logo' ) ) {
		return;
	}

	$wp_admin_bar->add_node(
		array(
			'id'     => 'wp-logo',
			'parent' => 'top-secondary',
		)
	);
}
add_action( 'admin_bar_menu', 'tlt_wp_menu_move', 31 );

/* -------------------------------------------------------------------------
 * The site name
 * ---------------------------------------------------------------------- */

/**
 * Prototypes 1 and 2. Site name: the same link and the same menu everywhere.
 *
 * Runs right after wp_admin_bar_site_menu() (priority 30). The capability
 * checks are the ones Core uses for each item. Prototype 2 adds Dashboard as
 * the first item, prototype 1 leaves it under the W.
 *
 * @param WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance.
 */
function tlt_site_menu_fixed( $wp_admin_bar ) {
	$prototype = tlt_prototype();

	if ( ! in_array( $prototype, array( 1, 2 ), true ) || ! $wp_admin_bar->get_node( 'site-name' ) ) {
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

	// Prototype 2 re-adds Dashboard below. Prototype 1 keeps it under the W.
	if ( 2 === $prototype ) {
		$wp_admin_bar->remove_node( 'dashboard' );
	}

	// Then add the same items everywhere.
	if ( 2 === $prototype && current_user_can( 'read' ) ) {
		$wp_admin_bar->add_node(
			array(
				'parent' => 'site-name',
				'id'     => 'dashboard',
				'title'  => __( 'Dashboard' ),
				'href'   => admin_url(),
			)
		);
	}

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
add_action( 'admin_bar_menu', 'tlt_site_menu_fixed', 31 );

/**
 * Prototypes 3 and 4. Dashboard is always in the site name menu.
 *
 * Core adds Dashboard on the front end only. In the admin, and so in the Post
 * Editor and the Site Editor, this adds it as the second item, right after
 * Visit Site. The click on the site name does not change. The other items do
 * not change either.
 *
 * @param WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance.
 */
function tlt_site_menu_dashboard( $wp_admin_bar ) {
	if ( ! in_array( tlt_prototype(), array( 3, 4 ), true ) || ! $wp_admin_bar->get_node( 'site-name' ) ) {
		return;
	}

	if ( is_network_admin() || is_user_admin() ) {
		return;
	}

	if ( ! is_admin() || ! current_user_can( 'read' ) || $wp_admin_bar->get_node( 'dashboard' ) ) {
		return;
	}

	// Keep Manage Site after Dashboard on multisite: remove it and add it back.
	$edit_site = $wp_admin_bar->get_node( 'edit-site' );
	if ( $edit_site ) {
		$wp_admin_bar->remove_node( 'edit-site' );
	}

	$wp_admin_bar->add_node(
		array(
			'parent' => 'site-name',
			'id'     => 'dashboard',
			'title'  => __( 'Dashboard' ),
			'href'   => admin_url(),
		)
	);

	if ( $edit_site ) {
		$wp_admin_bar->add_node( (array) $edit_site );
	}
}
add_action( 'admin_bar_menu', 'tlt_site_menu_dashboard', 31 );

/* -------------------------------------------------------------------------
 * Indicator, styles, settings
 * ---------------------------------------------------------------------- */

/**
 * A small "Prototype N" item on the right, so testers know which one is on.
 *
 * It links to the switch in Settings > General.
 *
 * @param WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance.
 */
function tlt_indicator( $wp_admin_bar ) {
	if ( ! current_user_can( 'read' ) ) {
		return;
	}

	$wp_admin_bar->add_node(
		array(
			'parent' => 'top-secondary',
			'id'     => 'tlt-prototype',
			/* translators: %d: prototype number. */
			'title'  => sprintf( __( 'Prototype %d', 'toolbar-links-test' ), tlt_prototype() ),
			'href'   => current_user_can( 'manage_options' ) ? admin_url( 'options-general.php#tlt-prototype' ) : false,
			'meta'   => array(
				'title' => __( 'Toolbar Links Test: the active prototype. Click to switch.', 'toolbar-links-test' ),
			),
		)
	);
}
// After the search item (9999), so it is the last node of the right group and sits at its left edge.
add_action( 'admin_bar_menu', 'tlt_indicator', 10000 );

/**
 * Styles.
 *
 * All prototypes: the same default icon (house) everywhere when the site has
 * no site icon. Core shows a gauge on the front end.
 * Prototype 1: the W stays visible under 600px. Core hides it there, but it
 * is now the way to the Dashboard.
 * Prototype 4: the W keeps its look inside the right side group.
 * The indicator is small and dim.
 */
function tlt_styles() {
	if ( ! is_admin_bar_showing() ) {
		return;
	}

	$css = '#wpadminbar #wp-admin-bar-site-name:not(.has-site-icon) > .ab-item:before { content: "\f102"; content: "\f102" / ""; }';

	$css .= '#wpadminbar #wp-admin-bar-tlt-prototype > .ab-item { font-size: 11px; opacity: .6; }';

	if ( 1 === tlt_prototype() ) {
		$css .= '@media screen and (max-width: 600px) { #wpadminbar li#wp-admin-bar-wp-logo { display: block; } }';
	}

	if ( 4 === tlt_prototype() ) {
		$css .= '#wpadminbar .ab-top-secondary #wp-admin-bar-wp-logo > .ab-item { padding: 0 9px; }';
		$css .= '#wpadminbar .ab-top-secondary #wp-admin-bar-wp-logo .ab-sub-wrapper .ab-item { padding-left: 2em; }';
	}

	wp_add_inline_style( 'admin-bar', $css );
}
add_action( 'wp_enqueue_scripts', 'tlt_styles', 20 );
add_action( 'admin_enqueue_scripts', 'tlt_styles', 20 );

/**
 * Settings > General: the prototype switch.
 *
 * One option, an integer from 1 to 4. When the TLT_PROTOTYPE constant is
 * defined the field only says so.
 */
function tlt_settings() {
	register_setting(
		'general',
		'tlt_prototype',
		array(
			'type'              => 'integer',
			'default'           => 1,
			'sanitize_callback' => 'tlt_sanitize_prototype',
			'show_in_rest'      => false,
		)
	);

	add_settings_field(
		'tlt_prototype',
		__( 'Toolbar prototype', 'toolbar-links-test' ),
		'tlt_settings_field',
		'general',
		'default',
		array( 'label_for' => 'tlt-prototype' )
	);
}
add_action( 'admin_init', 'tlt_settings' );

/**
 * Keeps the option between 1 and 4.
 *
 * @param mixed $value The submitted value.
 * @return int
 */
function tlt_sanitize_prototype( $value ) {
	$value = (int) $value;

	return isset( tlt_prototypes()[ $value ] ) ? $value : 1;
}

/**
 * Renders the radio list in Settings > General.
 */
function tlt_settings_field() {
	$active = tlt_prototype();

	echo '<fieldset id="tlt-prototype"><legend class="screen-reader-text"><span>' . esc_html__( 'Toolbar prototype', 'toolbar-links-test' ) . '</span></legend>';

	if ( defined( 'TLT_PROTOTYPE' ) ) {
		echo '<p>' . esc_html( tlt_prototypes()[ $active ]['label'] ) . '</p>';
		echo '<p class="description">' . esc_html__( 'Set by the TLT_PROTOTYPE constant in wp-config.php. Remove it to switch here.', 'toolbar-links-test' ) . '</p>';
		echo '</fieldset>';
		return;
	}

	foreach ( tlt_prototypes() as $number => $prototype ) {
		printf(
			'<p><label><input type="radio" name="tlt_prototype" value="%1$d" %2$s> %3$s</label><br><span class="description" style="margin-left: 24px;">%4$s</span></p>',
			(int) $number,
			checked( $active, $number, false ),
			esc_html( $prototype['label'] ),
			esc_html( $prototype['description'] )
		);
	}

	echo '<p class="description">' . esc_html__( 'Test plugin for Trac #66258. Deactivate the plugin to get the current behavior back.', 'toolbar-links-test' ) . '</p>';
	echo '</fieldset>';
}

/**
 * Removes the option on uninstall. Deactivation leaves it, so a tester can
 * compare and come back to the same prototype.
 */
function tlt_uninstall() {
	delete_option( 'tlt_prototype' );
}
register_uninstall_hook( __FILE__, 'tlt_uninstall' );
