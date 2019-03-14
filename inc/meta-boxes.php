<?php
function get_field_label_by_type($data){
	
	if($data['field_label']){
		return $data['field_label'];
	}
	
	if($data['placeholder']){
		return $data['placeholder'];
	}
	
	return __('No Label','elementor-leads');
	
}

function display_value_by_type($data){

	$field_value = $data['value'];
	if(!$field_value){
		echo "-";
		return;
	}
	switch($data['type']):
		case "email":
			echo "<a target='_blank' href='mailto:$field_value'>$field_value</a>";
			break;
		case "textarea":
			echo nl2br($data['value']);
			break;
		case "url":
			echo "<a target='_blank' href='$field_value'>".urldecode($field_value)."</a>";
			break;
		case "acceptance":
			echo '<input type="checkbox" checked disabled style="opacity:1">';
			break;
		case "checkbox":
			$checks = explode(',',$data['value']);
			$count = 0;
			$count_checks = count($checks);
			foreach($checks as $val){
				$count++;
				echo "<span>$val</span>";
				if($count_checks != $count){
					echo "<br>";
				}
			}
			break;
		case "upload":
			echo "<a target='_blank' href='$field_value'>".__('Download File','elementor-leads')."</a>"; 
			break;
		default:
			echo $field_value;
	endswitch;

}

add_action('admin_menu', 'edisable_new_posts');
function edisable_new_posts() {
  if (isset($_GET['post_type']) && $_GET['post_type'] == 'elementor_lead') {
	  echo '<style type="text/css">
	  .page-title-action { display:none; }
	  </style>';
  }
}

 
add_action( 'admin_menu', 'elementor_leads_register_admin_menu', 205 );
function elementor_leads_register_admin_menu() {
	add_menu_page(
		__( 'Elementor Leads', 'elementor-leads' ),
		__( 'Elementor Leads', 'elementor-leads' ),
		'publish_pages',
		'elementor-leads',
		'elementor_leads_display_settings_page',
		'dashicons-list-view',
		100
	);
}

function elementor_leads_display_settings_page(){
	
	echo '<div class="wrap">';
		echo '<h2>'.__( 'Elementor Leads', 'elementor-leads' ).'</h2>';	
		do_action('lenix_elementor_leads_admin_options_page_section');	
	echo '</div>';

	
}

