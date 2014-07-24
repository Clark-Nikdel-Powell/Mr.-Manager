<?php
/*
    Plugin Name: Mr. Manager
    Plugin URI: http://clarknikdelpowell.com
    Version: 0.1.0
    Description: Creates a new user role titled 'Manager.' Welcome aboard, Mr. Manager!
    Author: Josh Nederveld
    Author URI: http://clarknikdelpowell.com/agency/people/josh/

    Copyright 2014+ Clark/Nikdel/Powell (email : josh@clarknikdelpowell.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2 (or later),
    as published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function hire_mr_manager() {

	$templateRole = 'editor';
	$capabilities = array();

	$template = get_role($templateRole);
	if ($template && !is_wp_error($template)) {
		foreach ($template->capabilities as $capability=>$val) {
			$capabilities[$capability] = 1;
		}
	}

	// Do you need to hire a new employee? That's up to you, Mr. Manager
	$promotions = array(
		'create_users'
	,	'edit_users'
	,	'delete_users'
	,	'list_users'
	,	'promote_users'
	,	'remove_users'
	);

	// Adds promotions.
	foreach ($promotions as $promotion) {
		$capabilities[$promotion] = 1;
	}

	// Adds the manager role.
	add_role('manager', __( 'Manager' ), $capabilities);

}

function fire_mr_manager() {

	remove_role('manager');

}

// WP Engine's pages are hidden by default for Editors, but not managers.
// So we add this code, for extra security.
function hide_wpengine_page() {

	if (is_admin()) {
		$user = wp_get_current_user();
	
		if ( $user->roles[0] != 'administrator' ) {
			remove_menu_page( 'wpengine-common' );
		}
	}
}

add_action( 'admin_menu', 'hide_wpengine_page' );


register_activation_hook(__FILE__, 'hire_mr_manager');
register_uninstall_hook(__FILE__,  'fire_mr_manager');