<?php 

add_action('wp_print_scripts', 'wif_add_script_fn');
function wif_add_script_fn(){
	wp_enqueue_style('urm_bootsrap_css', plugins_url('/inc/assets/css/boot-cont.css', __FILE__ ) ) ;
   if(is_admin()){

	wp_enqueue_script('wif_admin_js', plugins_url('/js/admin.js', __FILE__ ), array('jquery'  ), '1.0' ) ;
	wp_enqueue_style('wif_admin_css', plugins_url('/css/admin.css', __FILE__ ) ) ;	
  }else{
	
	wp_enqueue_script('wif_front_js', plugins_url('/js/front.js', __FILE__ ), array('jquery' ), '1.0' ) ;
	wp_enqueue_style('wif_front_css', plugins_url('/css/front.css', __FILE__ ) ) ;
	
  }
}
?>