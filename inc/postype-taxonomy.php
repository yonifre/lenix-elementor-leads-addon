<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function elementor_leads_post_type() {
	
	// Lead
	$labels = array(
		'name'                  => _x( 'Leads', 'Post Type General Name', 'elementor-leads' ),
		'singular_name'         => _x( 'Lead', 'Post Type Singular Name', 'elementor-leads' ),
		'menu_name'             => __( 'Leads', 'elementor-leads' ),
		'name_admin_bar'        => __( 'Leads', 'elementor-leads' ),
		'archives'              => __( 'Lead Archives', 'elementor-leads' ),
		'attributes'            => __( 'Lead Attributes', 'elementor-leads' ),
		'parent_item_colon'     => __( 'Parent Lead:', 'elementor-leads' ),
		'all_items'             => __( 'All Leads', 'elementor-leads' ),
		'add_new_item'          => __( 'Add New Lead', 'elementor-leads' ),
		'add_new'               => __( 'Add New Lead', 'elementor-leads' ),
		'new_item'              => __( 'New Lead', 'elementor-leads' ),
		'edit_item'             => __( 'Edit Lead', 'elementor-leads' ),
		'update_item'           => __( 'Update Lead', 'elementor-leads' ),
		'view_item'             => __( 'View Lead', 'elementor-leads' ),
		'view_items'            => __( 'View Leads', 'elementor-leads' ),
		'search_items'          => __( 'Search Lead', 'elementor-leads' ),
		'not_found'             => __( 'No Leads', 'elementor-leads' ),
		'not_found_in_trash'    => __( 'No Leads found in Trash', 'elementor-leads' ),
		'featured_image'        => __( 'Featured Image', 'elementor-leads' ),
		'set_featured_image'    => __( 'Set featured image', 'elementor-leads' ),
		'remove_featured_image' => __( 'Remove featured image', 'elementor-leads' ),
		'use_featured_image'    => __( 'Use as featured image', 'elementor-leads' ),
		'insert_into_item'      => __( 'Insert into Lead', 'elementor-leads' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Lead', 'elementor-leads' ),
		'items_list'            => __( 'Leads list', 'elementor-leads' ),
		'items_list_navigation' => __( 'Leads list navigation', 'elementor-leads' ),
		'filter_items_list'     => __( 'Filter Leads list', 'elementor-leads' ),
	);
	$args = array(
		'label'                 => __( 'Lead', 'elementor-leads' ),
		'description'           => __( 'leads from forms', 'elementor-leads' ),
		'labels'                => $labels,
		'supports'              => array('title',),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => false,
		'menu_position'         => 100,
		'menu_icon'             => 'dashicons-id-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
		'show_in_rest'          => false,
	);
	register_post_type( 'elementor_lead', $args );
	
}

add_action( 'init', 'elementor_leads_post_type' );