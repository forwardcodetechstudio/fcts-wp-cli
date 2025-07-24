<?php
/**
 * Function: User Profile Tabs
 * Beschreibung: 
 *    Gruppieren der Felder der Benutzerprofilseite unter Registerkarten.
 *    Alle Felder im Benutzerprofil von, gegliedert durch H4, werden durch Javascript in Tabs organisiert.
 *    Javascript organisiert nur die Felder neu. Die eingebundenen Javascript-Listener werden nicht berührt.
 * Version: 1.3
 * Create: 10.08.2022
 * Author: Paul Brand (brand@litterarius.eu)
 */
global $pagenow;
if ($pagenow == 'profile.php' || $pagenow == 'user-edit.php') {
	add_action('admin_enqueue_scripts', 'user_profile_tabs_enqueue_script');
	function user_profile_tabs_enqueue_script() {
		wp_enqueue_script('user_profile_tabs/profile', THEME_DIR_URI . '/inc/wp-user-profil/user-profile-tabs.js');
		wp_enqueue_style('user_profile_tabs/profile', THEME_DIR_URI . '/inc/wp-user-profil/user-profile-tabs.css');
	}
}
