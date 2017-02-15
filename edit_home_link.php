<?php
/**
 * @link              ganeshveer.tk
 * @since             1.0.0
 * @package           Edit_homepage_link
 *
 * @wordpress-plugin
 * Plugin Name:       Edit HomePage Link
 * Plugin URI:        ganeshveer.tk
 * Description:       This plugin create a homepage or frontpage edit link on your settings->reading page, where you select the static page to display as front page or posts page. It helps you to go to the editing homepage directly.
 * Version:           1.0.0
 * Author:            Ganesh Veer
 * Author URI:        ganeshveer.tk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       edit_home_link
 * Domain Path:       /languages
 */

//where it came from https://wordpress.org/ideas/topic/homepage-acces

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
 // ------------------------------------------------------------------
 // Add all your sections, fields and settings during admin_init
 // ------------------------------------------------------------------
 //
 
 function ehpl_api_init() {
 	// Add the section to reading settings so we can add our
 	// fields to it
 	add_settings_section(
		'ehpl_setting_section',
		'Display edit link',
		'ehpl_setting_section_callback_function',
		'reading'
	);
 	
 	// Add the field with the names and function to use for our new
 	// settings, put it in our new section
 	add_settings_field(
		'ehpl_setting_name',
		'Home/Front page Edit link',
		'ehpl_setting_callback_function',
		'reading',
		'ehpl_setting_section'
	);
 	
 	// Register our setting so that $_POST handling is done for us and
 	// our callback function just has to echo the <input>
 	register_setting( 'reading', 'ehpl_setting_name' );
 } // eg_settings_api_init()
 
 add_action( 'admin_init', 'ehpl_api_init' );
  
 // ------------------------------------------------------------------
 // Settings section callback function
 // ------------------------------------------------------------------
 //
 // This function is needed if we added a new section. This function 
 // will be run at the start of our section
 //
  function ehpl_setting_section_callback_function() {
 	echo '<p style="display:none;">&nbsp;</p>';
	/*	if(get_option( 'eg_setting_name' )){
			$homeid =  get_option( 'page_on_front' );
			$postpid = get_option( 'page_for_posts' );
		}
	else{ 		echo "Not Allowed";	}
	*/
 }
 
 // ------------------------------------------------------------------
 // Callback function for our example setting
 // ------------------------------------------------------------------
 // creates a checkbox true/false option. Other types are surely possible
 
 function ehpl_setting_callback_function() {
 	echo '<input name="ehpl_setting_name" id="ehpl_setting_name" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'ehpl_setting_name' ), false ) . ' /> allow us to put edit link in front of "Front page" & "Posts page"';
 }

 function ehpl_enqueue_admin_script( $hook ) {
    if ( 'options-reading.php' != $hook ) {    return;    }
    $homeid =  get_option( 'page_on_front' );
	$postpid = get_option( 'page_for_posts' );
	$ajax_nonce = wp_create_nonce( "hehpl_homeurl" );

    wp_enqueue_script( 'edit_home_ajax_script', plugin_dir_url( __FILE__ ) . 'edit_home_ajax.js', array(), '1.0' );
    wp_localize_script( 'edit_home_ajax_script', 'ehpl_obj', 
    	array( 	'ajax_url' => admin_url( 'admin-ajax.php' ),
    			'wp_nonce' => 	$ajax_nonce,
     			'frontpage'=> $homeid, 
     			'postspage'=>$postpid,
     			'display_edit_link' =>  get_option( 'ehpl_setting_name' )
     		 ));
}
add_action( 'admin_enqueue_scripts', 'ehpl_enqueue_admin_script' );

// --------------------------------
// 			AJAX FUNCTION 
//---------------------------------
add_action('wp_ajax_nopriv_append_link','ehpl_append_link_callback');
add_action('wp_ajax_append_link','ehpl_append_link_callback');
function ehpl_append_link_callback(){
	check_ajax_referer( 'hehpl_homeurl', 'security' );
	ob_clean();	
	$hpostid =   intval($_REQUEST['postid']);
	$link =  get_edit_post_link($hpostid);
	echo $link;
	die();
}
