<?php
function sc_add_post_type() {
  $labels = array(
    'name' => __('Booking Orders', 'sc'),
    'singular_name' => __('Order', 'sc'),
    'add_new' => __('Add New', 'sc'),
    'add_new_item' => __('Add New Order', 'sc'),
    'edit_item' => __('Edit Order', 'sc'),
    'new_item' => __('New Order', 'sc'),
    'all_items' => __('All Orders', 'sc'),
    'view_item' => __('View Order', 'sc'),
    'search_items' => __('Search Order', 'sc'),
    'not_found' =>  __('No Orders found', 'sc'),
    'not_found_in_trash' => __('No Orders found in Trash', 'sc'), 
    'parent_item_colon' => '',
    'menu_name' => __('Booking Orders', 'sc')

  );
  $args = array(
    'labels' => $labels,
    'public' => false,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
	'menu_icon' => plugins_url('/images/ball.png', __FILE__ ),
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title', 'editor','custom-fields', 'author' )
  ); 
  register_post_type('booking_order', $args);
  
  
  
 
}
add_action( 'init', 'sc_add_post_type' );
?>