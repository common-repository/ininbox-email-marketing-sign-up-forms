<?php 
	
add_action('wp_ajax_next_step_action', 'sc_next_step_fn');
add_action('wp_ajax_nopriv_next_step_action', 'sc_next_step_fn');

function sc_next_step_fn(){
	global $wpdb;
  if( check_ajax_referer( 'security_nonce', 'security') ){
  
	$cur_date = $_POST['current_date'];
	$cur_date_arr = explode( '_', $_POST['current_date'] );
	$new_time = $cur_date_arr[1].'/'.$cur_date_arr[0].'/'.$cur_date_arr[2];
	$res = strtotime( $new_time );
	//$res = $res + 60*60*24;
	$next_date = date( 'j_n_Y', $res );
	
	$field1_res = $wpdb->get_col("SELECT hour FROM ".$wpdb->prefix."field1 WHERE date = '".$next_date."' ");

	$field2_res = $wpdb->get_col("SELECT hour FROM ".$wpdb->prefix."field2 WHERE date = '".$next_date."' ");
	$field3_res = $wpdb->get_col("SELECT hour FROM ".$wpdb->prefix."field3 WHERE date = '".$next_date."' ");
	
	
	for( $i=0; $i<=23; $i++ ){
		
	}
	
	$out_res = array( 
	'field1' =>  $field1_res,
	'field2' =>  $field2_res,
	'field3' =>  $field3_res
	);
	
	echo json_encode( $out_res );
  }
  die();
} 
add_action('wp_ajax_book_day_action', 'sc_book_day_action');
add_action('wp_ajax_nopriv_book_day_action', 'sc_book_day_action');

function sc_book_day_action(){
	global $wpdb, $current_user;
  if( check_ajax_referer( 'security_nonce', 'security') ){
  
	$dot_array =  json_decode( stripslashes( $_POST['current_date'] ) ) ;
		

		
		foreach( $dot_array as $single_block ){
				$wpdb->query("INSERT INTO  `".$wpdb->prefix."field".$single_block->field."` ( 
				`date` ,
				`hour` ,
				`team1` ,
				`team2` ,
				`team1_score` ,
				`team2_score`
				)
				VALUES (
				'".$single_block->date."',  '".$single_block->hour."', NULL , NULL , NULL , NULL
				) 
				");
				$order_info[] = str_replace('_', '/', $single_block->date ).' '.$single_block->hour.'-00 '."field = ".$single_block->field.' User: '.$current_user->user_login;
		}
		$order_info = implode( '<br/>', $order_info );
		$config = get_option('sc_options');
			add_filter( 'wp_mail_content_type', 'set_html_content_type' );
			// prepare User email
				$pp_mailfrom = '';
				$pp_mailfrom = str_replace( '%login%', $current_user->user_login, stripslashes( html_entity_decode( nl2br( $config['user_email_cliche'] ) ) ) );
				$pp_mailfrom = str_replace( '%order_info%', $order_info, $pp_mailfrom );

				$pp_mailfrom = str_replace( '%firstname%', $current_user->user_firstname, $pp_mailfrom );
				$pp_mailfrom = str_replace( '%lastname%', $current_user->user_lastname, $pp_mailfrom );
				$pp_mailfrom = str_replace( '%date%', str_replace('_', '/', $single_block->date ), $pp_mailfrom );
				$pp_mailfrom = str_replace( '%time%', $single_block->hour.'-00', $pp_mailfrom );
				$pp_mailfrom = str_replace( '%field%' , $single_block->field , $pp_mailfrom );
				$pp_mailfrom = str_replace( '%phone%' , get_user_meta(  $current_user->ID, 'rpr_telefonnummer', true ) , $pp_mailfrom );
				
				$headers = 'From: '.$config['admin_email_address'].' <'.$config['admin_email_address'].'>' . "\r\n";
				$subject = $config['user_email_subject'];
				wp_mail( $current_user->user_email, $subject, $pp_mailfrom , $headers);
		
			// prepare admin email
				$pp_mailfrom = '';
				$pp_mailfrom = str_replace( '%login%', $current_user->user_login, stripslashes( html_entity_decode( nl2br( $config['admin_email_cliche'] ) ) ) );
				$pp_mailfrom = str_replace( '%order_info%', $order_info, $pp_mailfrom );
			
				$pp_mailfrom = str_replace( '%firstname%', $current_user->user_firstname, $pp_mailfrom );
				$pp_mailfrom = str_replace( '%lastname%', $current_user->user_lastname, $pp_mailfrom );
				$pp_mailfrom = str_replace( '%date%', str_replace('_', '/', $single_block->date ), $pp_mailfrom );
				$pp_mailfrom = str_replace( '%time%', $single_block->hour.'-00', $pp_mailfrom );
				$pp_mailfrom = str_replace( '%field%' , $single_block->field , $pp_mailfrom );
				$pp_mailfrom = str_replace( '%phone%' , get_user_meta(  $current_user->ID, 'rpr_telefonnummer', true ) , $pp_mailfrom );
			
				$headers = 'From: '.$config['admin_email_address'].' <'.$config['admin_email_address'].'>' . "\r\n";
				$subject = $config['admin_email_subject'];
				wp_mail( $config['admin_email_address'], $subject, $pp_mailfrom , $headers);
				remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
			//adding booking in backend
			$my_post = array(
			  'post_title'    => $order_info,
			  'post_content'  => 'This is my post.',
			  'post_status'   => 'publish',
			  'post_author'   => 1,
			  'post_type' => 'booking_order'
			);

			// Insert the post into the database
			$new_id = wp_insert_post( $my_post );
			update_post_meta( $new_id, 'date', $single_block->date );
			update_post_meta( $new_id, 'hour', $single_block->hour );
			update_post_meta( $new_id, 'field', $single_block->field );
			
  }
  die();
}


?>