<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Elementor_Leads_Handler {
	
	protected $lead_id;
	protected $post_id;
	protected $form_slug;
	protected $form_id;
	protected $form_name;
	protected $lead_title;
	protected $fields;
	
	protected function insert_lead_post(){
		
		if(empty($this->fields)){
			return;
		}
		
		$meta['lead_data'] = wp_slash( wp_json_encode( $this->lead_data ) );
		$meta['post_id'] = $this->post_id;
		$meta['form_slug'] = $this->form_slug;
		
		$this->lead_id = wp_insert_post(
			array(
				'post_type'		=> 'elementor_lead',
				'post_status'	=> 'publish',
				'meta_input'	=> $meta,
			)
		);
		
	}
	
	protected function update_lead_post(){
		
		if($this->lead_id){
			
			$post_title['ID'] = $this->lead_id;
			$post_title['post_title'] = __('Lead #','elementor-leads').$this->lead_id;
			wp_update_post($post_title);
		}
		
	}
	
	public function store_submit_form( $record ) {
		
		if( !isset($_POST['post_id']) || !isset($_POST['form_id']) ){
			return false;
		}
		
		$this->post_id = sanitize_key($_POST['post_id']);
		$this->form_slug = sanitize_key($_POST['form_id']);
		$this->form_name = $record->get_form_settings('form_name');
		$this->fields = $record->get('fields');
		
		$this->lead_data = $record->get('fields');	
		
		$this->insert_lead_post();
		$this->update_lead_post();
		
	}

	public function __construct() {
		add_action( 'elementor_pro/forms/new_record', [ $this, 'store_submit_form' ], 10, 1 );
	}
}
new Elementor_Leads_Handler();