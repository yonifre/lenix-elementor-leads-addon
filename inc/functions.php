<?php
function lenix_array_to_csv($array){
   if (count($array) == 0) {
     return null;
   }
	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');

	// UTF-8 BOM
	fwrite($output, "\xEF\xBB\xBF");

	// output the column headings
	foreach($array as $fields){
		fputcsv($output, $fields);
	}
	
	return ob_get_clean();
}

function lenix_download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
	
}

//hide add new leads in admin bar
function lenix_elementor_leads_css_to_footer(){
	?>
<style>
	#wp-admin-bar-new-elementor_lead {
		display: none;
	}
	body.post-type-elementor_lead .wrap a.page-title-action {
		display: none;
	}
</style>
<?php }
add_action( 'admin_footer', 'lenix_elementor_leads_css_to_footer' );
add_action( 'wp_footer', 'lenix_elementor_leads_css_to_footer' );


add_action('pre_get_posts', 'query_set_only_current_form' );
function query_set_only_current_form( $wp_query ) {

    if( is_admin()
		&& $wp_query->is_main_query()
		&& isset($_GET['elementor_form'])
		&& isset($_GET['elementor_form_post_id'])
	) {
		$form_slug = sanitize_text_field($_GET['elementor_form']);
		$post_id = sanitize_text_field($_GET['elementor_form_post_id']);
		
		
		// fix elementor 2.1
		$form_slugs = array($form_slug);
		$post_ids = array($post_id);
		
		if($included_posts = get_post_meta($post_id,'_elementor_global_widget_included_posts',true)){
			$post_ids = array_keys($included_posts);
			foreach($post_ids as $included_post_id ){
				$elementor_data = get_post_meta($included_post_id,'_elementor_data',true);
				$elementor_data_json = json_decode($elementor_data,true);

				$slug = recursive_get_forms_slugs($elementor_data_json,$post_id);
				if($slug){
					$form_slugs = array_merge($form_slugs,$slug);
				}
			}
			$post_ids[] = $post_id;
		}
		
        $wp_query->set(
			'meta_query',
			array(
				'relation' => 'AND',
				array(
					'key'     => 'form_slug',
					'value'   => $form_slugs,
					'compare' => 'IN',
				),
				array(
					'key'     => 'post_id',
					'value'   => $post_ids,
					'compare' => 'IN',
				)
			)
		);

    }
}

function recursive_get_forms_slugs($arr,$id){
	
	global $slugs;
	
	if(!is_array($arr)){
		return $slugs;
	}
	
	foreach($arr as $data){
		if(isset($data['elements']) && !empty($data['elements'])){
			return recursive_get_forms_slugs($data['elements'],$id);
		}

		if(isset($data['templateID']) && $data['templateID'] == $id){
			$slugs[$data['id']] = $data['id'];
			return $slugs;
		}
	}
}

function lenix_get_query_field($field){
	
	if(!isset($_GET[$field])){
		return false;
	}
	
	return sanitize_text_field($_GET[$field]);
	
}