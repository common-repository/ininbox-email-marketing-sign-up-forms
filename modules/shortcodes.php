<?php 
add_shortcode( 'ininbox', 'wif_shortcode_handler' );
function wif_shortcode_handler( $atts, $content = null ) {	
	$form_list =  get_option('_ininboxjson' );
	foreach( $form_list as $single_form ){
		if( $single_form->WebformID != $atts['id'] ) continue;
		
		$out_codes = get_option( '_form_data_'.$atts['id'] );
		
		switch( $atts['type'] ){
			case 'direct':
			
			$out .= '<a href="'.$out_codes->LinkURL.'">'.$atts['anchor'].'</a>';
			
			break;
			
			case 'iframe':
				$out .= $out_codes->IFRAMECode;
			break;
			
			case 'html':
			$out .= $out_codes->HTMLCode;
			break;
		}
	}
	  return $out; 
}

?>