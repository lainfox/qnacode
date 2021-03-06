<?php

/**
 * BuddyPress Updater
 *
 * @package BuddyPress
 * @subpackage Updater
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * If there is no raw DB version, this is the first installation
 *
 * @since BuddyPress (1.7)
 *
 * @uses get_option()
 * @uses bp_get_db_version() To get BuddyPress's database version
 * @return bool True if update, False if not
 */
function bp_is_install() {
	return ! bp_get_db_version_raw();
}

/**
 * Compare the BuddyPress version to the DB version to determine if updating
 *
 * @since BuddyPress (1.6)
 *
 * @uses get_option()
 * @uses bp_get_db_version() To get BuddyPress's database version
 * @return bool True if update, False if not
 */
function bp_is_update() {

	// Current DB version of this site (per site in a multisite network)
	$current_db   = bp_get_option( '_bp_db_version' );
	$current_live = bp_get_db_version();

	// Compare versions (cast as int and bool to be safe)
	$is_update = (bool) ( (int) $current_db < (int) $current_live );

	// Return the product of version comparison
	return $is_update;
}

/**
 * Determine if BuddyPress is being activated
 *
 * @since BuddyPress (1.6)
 *
 * @uses buddypress()
 * @return bool True if activating BuddyPress, false if not
 */
function bp_is_activation( $basename = '' ) {
	$bp     = buddypress();
	$action = false;

	if ( ! empty( $_REQUEST['action'] ) && ( '-1' != $_REQUEST['action'] ) ) {
		$action = $_REQUEST['action'];
	} elseif ( ! empty( $_REQUEST['action2'] ) && ( '-1' != $_REQUEST['action2'] ) ) {
		$action = $_REQUEST['action2'];
	}

	// Bail if not activating
	if ( empty( $action ) || !in_array( $action, array( 'activate', 'activate-selected' ) ) ) {
		return false;
	}

	// The plugin(s) being activated
	if ( $action == 'activate' ) {
		$plugins = isset( $_GET['plugin'] ) ? array( $_GET['plugin'] ) : array();
	} else {
		$plugins = isset( $_POST['checked'] ) ? (array) $_POST['checked'] : array();
	}

	// Set basename if empty
	if ( empty( $basename ) && !empty( $bp->basename ) ) {
		$basename = $bp->basename;
	}

	// Bail if no basename
	if ( empty( $basename ) ) {
		return false;
	}

	// Is BuddyPress being activated?
	return in_array( $basename, $plugins );
}

/**
 * Determine if BuddyPress is being deactivated
 *
 * @since BuddyPress (1.6)
 *
 * @uses buddypress()
 * @return bool True if deactivating BuddyPress, false if not
 */
function bp_is_deactivation( $basename = '' ) {
	$bp     = buddypress();
	$action = false;

	if ( ! empty( $_REQUEST['action'] ) && ( '-1' != $_REQUEST['action'] ) ) {
		$action = $_REQUEST['action'];
	} elseif ( ! empty( $_REQUEST['action2'] ) && ( '-1' != $_REQUEST['action2'] ) ) {
		$action = $_REQUEST['action2'];
	}

	// Bail if not deactivating
	if ( empty( $action ) || !in_array( $action, array( 'deactivate', 'deactivate-selected' ) ) ) {
		return false;
	}

	// The plugin(s) being deactivated
	if ( 'deactivate' == $action ) {
		$plugins = isset( $_GET['plugin'] ) ? array( $_GET['plugin'] ) : array();
	} else {
		$plugins = isset( $_POST['checked'] ) ? (array) $_POST['checked'] : array();
	}

	// Set basename if empty
	if ( empty( $basename ) && !empty( $bp->basename ) ) {
		$basename = $bp->basename;
	}

	// Bail if no basename
	if ( empty( $basename ) ) {
		return false;
	}

	// Is bbPress being deactivated?
	return in_array( $basename, $plugins );
}

/**
 * Update the DB to the latest version
 *
 * @since BuddyPress (1.6)
 *
 * @uses update_option()
 * @uses bp_get_db_version() To get BuddyPress's database version
 * @uses bp_update_option() To update BuddyPress's database version
 */
function bp_version_bump() {
	bp_update_option( '_bp_db_version', bp_get_db_version() );
}

/**
 * Setup the BuddyPress updater
 *
 * @since BuddyPress (1.6)
 *
 * @uses BBP_Updater
 */
function bp_setup_updater() {

	// Are we running an outdated version of BuddyPress?
	if ( ! bp_is_update() )
		return;
	
	bp_version_updater();
}

/**
 * bbPress's version updater looks at what the current database version is, and
 * runs whatever other code is needed.
 *
 * This is most-often used when the data schema changes, but should also be used
 * to correct issues with bbPress meta-data silently on software update.
 *
 * @since bbPress (r4104)
 */
function bp_version_updater() {

	// Get the raw database version
	$raw_db_version = (int) bp_get_db_version_raw();

	/** 1.6 Branch ************************************************************/

	// 1.6
	if ( $raw_db_version < 6067 ) {
		// Do nothing
	}

	/** All done! *************************************************************/

	// Bump the version
	bp_version_bump();
}

/**
 * Redirect user to BuddyPress's What's New page on activation
 *
 * @since BuddyPress (1.7)
 *
 * @internal Used internally to redirect BuddyPress to the about page on activation
 *
 * @uses set_transient() To drop the activation transient for 30 seconds
 *
 * @return If bulk activation
 */
function bp_add_activation_redirect() {

	// Bail if activating from network, or bulk
	if ( isset( $_GET['activate-multi'] ) )
		return;

	// Add the transient to redirect
    set_transient( '_bp_activation_redirect', true, 30 );
}

/** Activation Actions ********************************************************/

/**
 * Runs on BuddyPress activation
 *
 * @since BuddyPress (1.6)
 *
 * @uses do_action() Calls 'bp_activation' hook
 */
function bp_activation() {

	// Force refresh theme roots.
	delete_site_transient( 'theme_roots' );

	// Use as of (1.6)
	do_action( 'bp_activation' );

	// @deprecated as of (1.6)
	do_action( 'bp_loader_activate' );
}

/**
 * Runs on BuddyPress deactivation
 *
 * @since BuddyPress (1.6)
 *
 * @uses do_action() Calls 'bp_deactivation' hook
 */
function bp_deactivation() {

	// Force refresh theme roots.
	delete_site_transient( 'theme_roots' );

	// Switch to WordPress's default theme if current parent or child theme
	// depend on bp-default. This is to prevent white screens of doom.
	if ( in_array( 'bp-default', array( get_template(), get_stylesheet() ) ) ) {
		switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
		update_option( 'template_root',   get_raw_theme_root( WP_DEFAULT_THEME, true ) );
		update_option( 'stylesheet_root', get_raw_theme_root( WP_DEFAULT_THEME, true ) );
	}

	// Use as of (1.6)
	do_action( 'bp_deactivation' );

	// @deprecated as of (1.6)
	do_action( 'bp_loader_deactivate' );
}

/**
 * Runs when uninstalling BuddyPress
 *
 * @since BuddyPress (1.6)
 *
 * @uses do_action() Calls 'bp_uninstall' hook
 */
function bp_uninstall() {
	do_action( 'bp_uninstall' );
}
