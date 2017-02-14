<?php


/**
 * @link              ganeshveer.tk
 * @since             1.0.0
 * @package           Edit_home_link
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

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
 // ------------------------------------------------------------------
 // Add all your sections, fields and settings during admin_init
 // ------------------------------------------------------------------
 //
 
 function eg_settings_api_init() {
 	// Add the section to reading settings so we can add our
 	// fields to it
 	add_settings_section(
		'eg_setting_section',
		'Display edit link',
		'eg_setting_section_callback_function',
		'reading'
	);
 	
 	// Add the field with the names and function to use for our new
 	// settings, put it in our new section
 	add_settings_field(
		'eg_setting_name',
		'Home/Front page Edit link',
		'eg_setting_callback_function',
		'reading',
		'eg_setting_section'
	);
 	
 	// Register our setting so that $_POST handling is done for us and
 	// our callback function just has to echo the <input>
 	register_setting( 'reading', 'eg_setting_name' );
 } // eg_settings_api_init()
 
 add_action( 'admin_init', 'eg_settings_api_init' );
  
 // ------------------------------------------------------------------
 // Settings section callback function
 // ------------------------------------------------------------------
 //
 // This function is needed if we added a new section. This function 
 // will be run at the start of our section
 //
  function eg_setting_section_callback_function() {
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
 
 function eg_setting_callback_function() {
 	echo '<input name="eg_setting_name" id="eg_setting_name" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'eg_setting_name' ), false ) . ' /> allow us to put edit link in front of "Front page" & "Posts page"';
 }

 function wpdocs_selectively_enqueue_admin_script( $hook ) {
    if ( 'options-reading.php' != $hook ) {    return;    }
    $homeid =  get_option( 'page_on_front' );
	$postpid = get_option( 'page_for_posts' );
	
    wp_enqueue_script( 'edit_home_ajax_script', plugin_dir_url( __FILE__ ) . 'edit_home_ajax.js', array(), '1.0' );
    wp_localize_script( 'edit_home_ajax_script', 'ajax_object', 
    	array( 	'ajax_url' => admin_url( 'admin-ajax.php' ),
     			'frontpage'=> $homeid, 
     			'postspage'=>$postpid,
     			'display_edit_link' =>  get_option( 'eg_setting_name' )
     		 ));
}
add_action( 'admin_enqueue_scripts', 'wpdocs_selectively_enqueue_admin_script' );

// --------------------------------
// 			AJAX FUNCTION 
//---------------------------------
add_action('wp_ajax_nopriv_append_link','append_link_callback');
add_action('wp_ajax_append_link','append_link_callback');
function append_link_callback(){
	ob_clean();
	
	$hpostid =  $_REQUEST['postid'];
	$link =  get_edit_post_link($hpostid);
	echo $link;

	die();
}
