<?
/*
Plugin Name: INinbox Email Marketing Sign up Forms
Plugin URI: http://www.INinbox.com
Description: The Official INinbox Sign Up Form plugin makes it easy to grow your subscribers! Use this plugin to integrate your email newsletter sign up forms into your WordPress site.
Version: 1.1
Author: INinbox Email Marketing
Author URI: http://www.INinbox.com

*/
//include('modules/profile.php');
//include('modules/meta_box.php');
//include('modules/cpt.php');
//include('modules/ajax.php');

include('modules/shortcodes.php');
include('modules/functions.php');
//include('modules/hooks.php');
include('modules/scripts.php');
include('modules/settings.php');
include('modules/widgets.php');

register_activation_hook( __FILE__, 'wif_activate' );
//add_action('init', 'sc_activate');
function wif_activate() {
  
 flush_rewrite_rules();
}

function wif_init() {
 $plugin_dir = basename(dirname(__FILE__));
 load_plugin_textdomain( 'wif', false, $plugin_dir );
}
add_action('plugins_loaded', 'wif_init');
add_action('after_setup_theme', 'wif_init');
?>