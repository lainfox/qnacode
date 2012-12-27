<?php
/**

* Removes BP’s redirect from the regular WP registration page.

*/

function my_remove_bp_register_redirect() {
	remove_action('bp_init', 'bp_core_wpsignup_redirect');
}

add_action( 'bp_loaded', 'my_remove_bp_register_redirect' );
?>