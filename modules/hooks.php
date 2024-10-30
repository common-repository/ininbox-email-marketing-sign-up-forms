<?php 
add_action('delete_post', 'sc_booking_remove') 	;
add_filter('wp_trash_post', 'sc_booking_remove') 	;
//add_action('before_delete_post', 'sc_booking_remove') 	;
function sc_booking_remove( $post_id ){
	global $wpdb;
	if( get_post_meta( $post_id, 'circular', true) == 1 ){
	
		$out_ar = explode( '/', get_post_meta( $post_id, 'booking_date_from', true) );
		$from_date = $out_ar[1].'/'.$out_ar[0].'/'.$out_ar[2];
		$from_date_time = strtotime( $from_date );
		
		$out_ar = explode( '/', get_post_meta( $post_id, 'booking_date_to', true ) );
		$to_date = $out_ar[1].'/'.$out_ar[0].'/'.$out_ar[2];
		$to_date_time = strtotime( $to_date );
		
		for( $i = $from_date_time; $i <= $to_date_time; $i = $i + 86400 ){
			if( date('N', $i) == get_post_meta( $post_id, 'day2process', true ) ){
		
				for($k=strtotime( get_post_meta( $post_id,'booking_time_from', true) ); $k < strtotime( get_post_meta( $post_id,'booking_time_to', true) ); $k = $k+1800 )  {					
						$this_time = date( "Hi",  $k  );
						$next_time = date( "Hi",  $k+1800  );			
							$wpdb->query("DELETE  FROM ".$wpdb->prefix."field".get_post_meta( $post_id, 'field_number', true )." WHERE date = '".date( 'd/m/Y', $i )."' AND hour = '".$this_time.$next_time."' " );		
							//var_dump( "DELETE  FROM ".$wpdb->prefix."field".get_post_meta( $post_id, 'field_number', true )." WHERE date = '".date( 'd/m/Y', $i )."' AND hour = '".$this_time.$next_time."' " );
				}
			
			}
		}
	
	}else{
	$wpdb->query("DELETE  FROM ".$wpdb->prefix."field".get_post_meta( $post_id, 'field', true )." WHERE date = '".get_post_meta( $post_id, 'date', true )."' AND hour = '".get_post_meta( $post_id, 'hour', true )."' " );
	}
	
	
	//var_dump( "DELETE  FROM ".$wpdb->prefix."field".get_post_meta( $post_id, 'field', true )." WHERE date = '".get_post_meta( $post_id, 'date', true )."' AND hour = '".get_post_meta( $post_id, 'hour', true )."' " );
	
}

//
if( !function_exists('set_html_content_type') ){
	function set_html_content_type() {
		return 'text/html';
	}
}
?>