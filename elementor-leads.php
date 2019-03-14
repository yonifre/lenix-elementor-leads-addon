<?php
/*
Plugin Name: Lenix Elementor Leads addon
Plugin URI:  https://lenix.co.il/plugin/lenix-elementor-leads-addon/
Version:     1.5
Description: Elementor leads By Lenix.
Author:      Lenix
Author URI:  https://lenix.co.il/
Depends: Elementor
Text Domain: elementor-leads
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// constants
define( 'ELEMENTOR_LEADS__FILE__', __FILE__ );
define( 'ELEMENTOR_LEADS_PLUGIN_BASE', plugin_basename( ELEMENTOR_LEADS__FILE__ ) );
define( 'ELEMENTOR_LEADS_URL', plugins_url( '/', ELEMENTOR_LEADS__FILE__ ) );
define( 'ELEMENTOR_LEADS_PATH', plugin_dir_path( ELEMENTOR_LEADS__FILE__ ) );
define( 'ELEMENTOR_LEADS_VERSION', 1.5);

add_action('elementor_pro/init', 'elementor_leads_init');
function elementor_leads_init(){
	
	load_plugin_textdomain( 'elementor-leads',false, dirname( plugin_basename( __FILE__ ) ). '/languages'  );
	
	require( ELEMENTOR_LEADS_PATH . 'inc/postype-taxonomy.php' );
	require( ELEMENTOR_LEADS_PATH . 'inc/elementor-api.php' );
	require( ELEMENTOR_LEADS_PATH . 'inc/meta-boxes.php' );
	require( ELEMENTOR_LEADS_PATH . 'inc/functions.php' );	
	
}

require( ELEMENTOR_LEADS_PATH . 'inc/class-lenix-elementor-forms.php' );


add_action('plugins_loaded',function(){
	if ( !function_exists( 'elementor_pro_load_plugin' ) ) {
		add_action( 'admin_notices', 'elementor_leads_no_active_notice' );
	} 
});

function elementor_leads_no_active_notice() {
    echo "<div class='notice notice-warning is-dismissible'>";
        echo '<p>'.__( 'Elementor leads: Elementor Pro plugin is inactive!', 'elementor-leads' ).'</p>';
    echo "</div>";
}

add_filter( 'plugin_row_meta', 'lenix_plugin_row_meta', 10, 2 );
function lenix_plugin_row_meta( $links, $file ) {
	if ( !strpos( $file, 'elementor-leads' ) === false ) {
		$leads_link = array(
			'lead_list' => '<a href="'.admin_url().'/admin.php?page=elementor-leads" target="_blank">'.__( 'My leads', 'elementor-leads' ).'</a>'
		);
		
		$links = array_merge( $links, $leads_link );
	}
	
	return $links;
}