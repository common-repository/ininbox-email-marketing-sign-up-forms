<?php 
	
function wif_api_call( $page_num ){
	$config = get_option('wif_options'); 	
	$process = curl_init($host);
	curl_setopt($process, CURLOPT_URL, 'http://api.ininbox.com/v1/webforms/list.json?Page='.$page_num.'&OrderField=name&OrderDirection=asc');
	curl_setopt($process, CURLOPT_USERPWD, $config['api_key'] . ":" . $config['api_pass'] );
	curl_setopt($process, CURLOPT_TIMEOUT, 30);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
	$return = curl_exec($process);
	curl_close($process);
	
	return $return;
}	

function ininbox_form( $id = null, $type = null, $anchor = null ){
	echo do_shortcode('[ininbox id="'.$id.'" type="'.$type.'" anchor="'.$anchor.'"] ');
}

function wif_get_form( $form_id ){
	$config = get_option('wif_options'); 	
	$process = curl_init($host);
	curl_setopt($process, CURLOPT_URL, 'http://api.ininbox.com/v1/webforms/'.$form_id.'/detail.json');
	curl_setopt($process, CURLOPT_USERPWD, $config['api_key'] . ":" . $config['api_pass'] );
	curl_setopt($process, CURLOPT_TIMEOUT, 30);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
	$return = curl_exec($process);
	curl_close($process);
	
	return $return;
}

/*
function wif_get_forms_call(){
	$config = get_option('wif_options'); 	
	$process = curl_init($host);
	curl_setopt($process, CURLOPT_URL, 'http://api.ininbox.com/v1/webforms/list.json?Page=5&OrderField=name&OrderDirection=asc');
	curl_setopt($process, CURLOPT_USERPWD, $config['api_key'] . ":" . $config['api_pass'] );
	curl_setopt($process, CURLOPT_TIMEOUT, 30);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
	$return = curl_exec($process);
	curl_close($process);
	var_dump( $return );
	return $return;
}
*/


?>