<?php
/**
 * K Lite back compat functionality
 *
 * Prevents K Lite from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
 * @package WordPress
 * @subpackage k_lite
 * @since K Lite 1.0.0
 */

/**
 * Prevent switching to K Lite on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since K Lite 1.0.0
 */
function klite_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'klite_upgrade_notice' );
}
add_action( 'after_switch_theme', 'klite_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * K Lite on WordPress versions prior to 4.7.
 *
 * @since K Lite 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function klite_upgrade_notice() {
	/* translators: %s: WordPress version. */
	$message = sprintf( __( 'K Lite requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'klite' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since K Lite 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function klite_customize() {
	wp_die(
		sprintf(
			/* translators: %s: WordPress version. */
			__( 'K Lite requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'klite' ),
			$GLOBALS['wp_version']
		),
		'',
		array(
			'back_link' => true,
		)
	);
}
add_action( 'load-customize.php', 'klite_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since K Lite 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function klite_preview() {
	if ( isset( $_GET['preview'] ) ) {
		/* translators: %s: WordPress version. */
		wp_die( sprintf( __( 'K Lite requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'klite' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'klite_preview' );
