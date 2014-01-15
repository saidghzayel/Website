<?php

if( ENV_DOMAIN == PRODUCTION_DOMAIN ) {

	if ( !defined( 'SUNRISE_LOADED' ) )
		define( 'SUNRISE_LOADED', 1 );

	if ( defined( 'COOKIE_DOMAIN' ) ) {
		die( 'The constant "COOKIE_DOMAIN" is defined (probably in wp-config.php). Please remove or comment out that define() line.' );
	}

	// let the site admin page catch the VHOST == 'no'
	$wpdb->dmtable = $wpdb->base_prefix . 'domain_mapping';
	$dm_domain = $wpdb->escape( $_SERVER[ 'HTTP_HOST' ] );

	if( ( $nowww = preg_replace( '|^www\.|', '', $dm_domain ) ) != $dm_domain )
		$where = $wpdb->prepare( 'domain IN (%s,%s)', $dm_domain, $nowww );
	else
		$where = $wpdb->prepare( 'domain = %s', $dm_domain );

	$wpdb->suppress_errors();
	$domain_mapping_id = $wpdb->get_var( "SELECT blog_id FROM {$wpdb->dmtable} WHERE {$where} ORDER BY CHAR_LENGTH(domain) DESC LIMIT 1" );
	$wpdb->suppress_errors( false );
	if( $domain_mapping_id ) {
		$current_blog = $wpdb->get_row("SELECT * FROM {$wpdb->blogs} WHERE blog_id = '$domain_mapping_id' LIMIT 1");
		$current_blog->domain = $_SERVER[ 'HTTP_HOST' ];
		$current_blog->path = '/';
		$blog_id = $domain_mapping_id;
		$site_id = $current_blog->site_id;

		define( 'COOKIE_DOMAIN', $_SERVER[ 'HTTP_HOST' ] );

		$current_site = $wpdb->get_row( "SELECT * from {$wpdb->site} WHERE id = '{$current_blog->site_id}' LIMIT 0,1" );
		$current_site->blog_id = $wpdb->get_var( "SELECT blog_id FROM {$wpdb->blogs} WHERE domain='{$current_site->domain}' AND path='{$current_site->path}'" );
		if( function_exists( 'get_current_site_name' ) )
			$current_site = get_current_site_name( $current_site );

		define( 'DOMAIN_MAPPING', 1 );
	}

	return false;
}


if ( !defined( 'SUNRISE_LOADED' ) )
	define( 'SUNRISE_LOADED', 1 );

if ( defined( 'COOKIE_DOMAIN' ) ) {
	die( 'The constant "COOKIE_DOMAIN" is defined (probably in wp-config.php). Please remove or comment out that define() line.' );
}

if( !defined( 'PRODUCTION_DOMAIN' ) )
	die( 'You must define PRODUCTION_DOMAIN' );

if (isset($_SERVER['HTTP_HOST'])) {
	$host = $_SERVER['HTTP_HOST'];
} elseif (isset($_SERVER['SERVER_NAME'])) {
	$host = $_SERVER['SERVER_NAME'];
}
add_filter( 'login_headerurl', 'cwwp_login_logo_url' );
add_filter( 'network_home_url', 'cwwp_login_logo_url' );
/**
 * Filters the default login URL to point to the current site's homepage.
 *
 * @since 1.0.0
 *
 * @param string $url The default login logo URL
 * @return string $url The amended login logo URL
 */
function cwwp_login_logo_url( $url ) {

	return trailingslashit( get_home_url() );

}

/**
 * This parses a domain and returns its first subdomain,
 * returning false if the given domain matches the environment
 * domain. This is because we don't want the subdomain of the
 * environment domain if it already includes a subdomain.
 */
function getSubDomain ($domain) {
    if( $domain == ENV_DOMAIN )
    	return;

    $eDom = explode('.', $domain);
    return $eDom[0] .'.';
}

if ( getSubDomain( $host ) . ENV_DOMAIN == $host) {
	// switch the host.
	$host = getSubDomain( $host ) . PRODUCTION_DOMAIN;
}

if (is_subdomain_install()) {
	$sql = $wpdb -> prepare("SELECT * FROM {$wpdb->blogs} WHERE domain = %s LIMIT 1", $host);
} else {
	// this probably needs some work.
	$path = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));
	if (count($path))
		$path = '/' . $path[0];
	else
		$path = '/';

	$sql = $wpdb -> prepare("SELECT * FROM {$wpdb->blogs} WHERE domain = %s AND path = %s LIMIT 1", $host, $path);
}

if ($_blog = $wpdb -> get_row($sql)) {

	$current_blog = $_blog;

	$blog_id = $_blog -> blog_id;
	$site_id = $current_blog -> site_id;

	// set current site
	$current_site = $wpdb -> get_row($wpdb -> prepare("SELECT * from {$wpdb->site} WHERE id = %d", $site_id));
	$current_site -> blog_id = $blog_id;

	// Switch the network_home_url to the environment domain
	$current_site = get_current_site_name($current_site);
	$current_site->domain = ENV_DOMAIN;
	$sql = $wpdb -> prepare("SELECT * FROM {$wpdb->blogs} WHERE domain = %s AND path = %s LIMIT 1", $host, $path);

}
