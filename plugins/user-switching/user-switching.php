<?php
/*
Plugin Name:  User Switching
Description:  Instant switching between user accounts in WordPress
Version:      0.3.2
Plugin URI:   http://lud.icro.us/wordpress-plugin-user-switching/
Author:       John Blackbourn
Author URI:   http://johnblackbourn.com/

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

*/

if ( !defined( 'OLDUSER_COOKIE' ) )
	define( 'OLDUSER_COOKIE', 'wordpress_olduser_' . COOKIEHASH );

class user_switching {

	function user_switching() {
		add_action( 'admin_init',       array( $this, 'admin_init' ) );
		add_action( 'admin_notices',    array( $this, 'admin_notice' ) );
		add_action( 'user_row_actions', array( $this, 'user_row' ), 10, 2 );
		add_action( 'personal_options', array( $this, 'personal_options' ) );
		add_action( 'admin_bar_menu',   array( $this, 'admin_bar_menu' ), 11 );
		add_action( 'wp_logout',        'wp_clear_olduser_cookie' );
		add_action( 'wp_login',         'wp_clear_olduser_cookie' );
	}

	function personal_options( $user ) {
		$current_user = wp_get_current_user();
		if ( !current_user_can( 'edit_user', $user->ID ) or ( $user->ID == $current_user->ID ) )
			return;
		?>
		<tr>
			<th scope="row"><?php _e( 'User Switching', 'user_switching' ); ?></th>
			<td><a href="<?php echo wp_nonce_url("users.php?action=switch_to_user&amp;user_id={$user->ID}", "switch_to_user_{$user->ID}"); ?>"><?php _e( 'Switch&nbsp;To', 'user_switching' ); ?></a></td>
		</tr>
		<?php
	}

	function remember() {

		$current_user = wp_get_current_user();
		$current      = wp_parse_auth_cookie( '', 'logged_in' );
		$cookie_life  = apply_filters( 'auth_cookie_expiration', 172800, $current_user->ID, false );

		return ( ( $current['expiration'] - time() ) > $cookie_life );

	}

	function admin_init() {
		if ( !isset( $_REQUEST['action'] ) )
			return;

		switch ( $_REQUEST['action'] ) {
			case 'switch_to_user':
				$user_id = (int) $_REQUEST['user_id'];
				check_admin_referer( "switch_to_user_$user_id" );

				if ( switch_to_user( $user_id, $this->remember() ) ) {

					if ( !current_user_can( 'read' ) )
						wp_redirect( add_query_arg( array( 'user_switched' => 'true' ), get_bloginfo('home') ) );
					else
						wp_redirect( add_query_arg( array( 'user_switched' => 'true' ), admin_url() ) );
					die();

				} else {
					wp_die( __( 'Could not switch users.', 'user_switching' ) );
				}
				break;
			case 'switch_to_olduser':
				check_admin_referer( 'switch_to_olduser' );

				if ( !$old_user_id = $this->get_old_user() )
					wp_die( __( 'Could not switch users.', 'user_switching' ) );

				if ( switch_to_user( $old_user_id, $this->remember(), false ) ) {
					wp_redirect( add_query_arg( array( 'user_switched' => 'true', 'back' => 'true' ), admin_url('users.php') ) );
					die();
				} else {
					wp_die( __( 'Could not switch users.', 'user_switching' ) );
				}
				break;
		}
	}

	function admin_notice() {
		if ( $old_user_id = $this->get_old_user() ) {

			$old_user = get_userdata( $old_user_id );
			$link = wp_nonce_url('index.php?action=switch_to_olduser', 'switch_to_olduser');

			?><div id="user_switching" class="updated"><p><?php
			if ( isset( $_GET['user_switched'] ) ) {
				printf( __( 'Switched to %s (%s).', 'user_switching' ), $GLOBALS['user_identity'], $GLOBALS['user_login'] );
			}
			printf( __( ' <a href="%s">Switch back to %s (%s)</a>.', 'user_switching' ), $link, $old_user->display_name, $old_user->user_login );
			?></p></div><?php

		} else if ( isset( $_GET['user_switched'] ) ) {

			?><div id="user_switching" class="updated fade"><p><?php
			if ( isset( $_GET['back'] ) ) {
				printf( __( 'Switched back to %s (%s).', 'user_switching' ), $GLOBALS['user_identity'], $GLOBALS['user_login'] );
			} else {
				printf( __( 'Switched to %s (%s).', 'user_switching' ), $GLOBALS['user_identity'], $GLOBALS['user_login'] );
			}
			?></p></div><?php

		}
	}

	function get_old_user() {
		if ( isset( $_COOKIE[OLDUSER_COOKIE] ) )
			return wp_validate_auth_cookie( $_COOKIE[OLDUSER_COOKIE], 'old_user' );
		return false;
	}

	function admin_bar_menu() {
		global $wp_admin_bar;

		if ( !function_exists( 'is_admin_bar_showing' ) )
			return;
		if ( !is_admin_bar_showing() )
			return;

		if ( $old_user_id = $this->get_old_user() ) {

			$old_user = get_userdata( $old_user_id );
			$avatar   = get_avatar( get_current_user_id(), 16 );
			$parent   = !empty( $avatar ) ? 'my-account-with-avatar' : 'my-account';

			$wp_admin_bar->add_menu( array(
				'parent' => $parent,
				'title'  => sprintf( __( 'Switch back to %s (%s)', 'user_switching' ), $old_user->display_name, $old_user->user_login ),
				'href'   => wp_nonce_url( admin_url( 'index.php?action=switch_to_olduser' ), 'switch_to_olduser' )
			) );
		}

	}

	function user_row( $actions, $user ) {
		$current_user = wp_get_current_user();

		if ( current_user_can( 'edit_user', $user->ID ) and ( $current_user->ID != $user->ID ) )
			$actions[] = '<a href="' . wp_nonce_url("users.php?action=switch_to_user&amp;user_id={$user->ID}", "switch_to_user_{$user->ID}") . '">' . __( 'Switch&nbsp;To', 'user_switching' ) . '</a>';

		return $actions;
	}

}

if ( !function_exists( 'wp_set_olduser_cookie' ) ) {
function wp_set_olduser_cookie( $old_user_id = 0 ) {
	$expiration = time() + 172800; # 48 hours
	$cookie = wp_generate_auth_cookie( $old_user_id, $expiration, 'old_user' );
	setcookie( OLDUSER_COOKIE, $cookie, $expiration, COOKIEPATH, COOKIE_DOMAIN, false );
}
}

if ( !function_exists( 'wp_clear_olduser_cookie' ) ) {
function wp_clear_olduser_cookie() {
	setcookie( OLDUSER_COOKIE, ' ', time() - 31536000, COOKIEPATH, COOKIE_DOMAIN );
}
}

if ( !function_exists( 'switch_to_user' ) ) {
function switch_to_user( $user_id = 0, $remember = false, $old_user_id = 0 ) {
	if ( !function_exists( 'wp_set_auth_cookie' ) )
		return false;
	if ( !$user_id )
		return false;
	if ( !$user = get_userdata( $user_id ) )
		return false;

	if ( 0 === $old_user_id ) {
		$current_user = wp_get_current_user();
		$old_user_id = $current_user->ID;
	}

	if ( $old_user_id )
		wp_set_olduser_cookie( $old_user_id );
	else
		wp_clear_olduser_cookie();

	wp_clear_auth_cookie();
	wp_set_auth_cookie( $user_id, $remember );
	wp_set_current_user( $user_id );

	return true;
}
}

load_plugin_textdomain( 'user_switching', false, dirname( plugin_basename( __FILE__ ) ) );

$user_switching = new user_switching();

?>