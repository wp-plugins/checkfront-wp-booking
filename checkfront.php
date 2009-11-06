<?php 
/* 
Plugin Name: Checkfront Booking
Plugin URI: http://www.checkfront.com/extend/wordpress
Description: Connects wordpress to the Checkfront Online Booking and Availablity platform.
Version: 0.7.1
Author: Checkfront Inc.
Author URI: http://www.checkfront.com/
Copyright: 2009 Checkfront Inc 
*/


//Shortcode [clean-conract parameter="value"]
function checkfront_func($atts, $content=null) {
	$atts=shortcode_atts(array(
		'booking' => '0',
	), $atts);
	return checkfront($atts);
}

function checkfront($atts) {
	global $Checkfront;
	if($atts['booking']) {
		return checkfront_booking();
	}
}

// {{{ checkfront_conf()
/* 
 * Add to admin
 * @param void
 * @return void
*/
function checkfront_conf() {
	global $Checkfront;
	if ( function_exists('add_menu_page') ) {
		add_menu_page('Setup', 'Checkfront', 'read', __FILE__, 'checkfront_setup',"{$Checkfront->path}/icon.png");
//		add_submenu_page(__FILE__, 'Inventory', 'Inventory', 'read', __FILE__, 'checkfront_inventory');
//		add_submenu_page(__FILE__, 'Setup', 'Setup', 10, 'checkfront_setup', 'checkfront_setup');
	}
}

// {{{ checkfront_conf_page()
/* 
 * Display admin
 * @param void
 * @return void
*/
function checkfront_setup() {
	global $Checkfront;
	include(dirname(__FILE__).'/setup.php');
}


// {{{ checkfront_widget()
/* 
 * Display admin
 * @param void
 * @return void
*/
function checkfront_widget() {
	global $Checkfront;
	include(dirname(__FILE__).'/widget.php');
}


// {{{ checkfront_invoice()
/* 
 * Display admin
 * @param void
 * @return void
*/
function checkfront_invoice() {
	global $Checkfront;
	return '<iframe src="https://' . $Checkfront->host . '/widget/invoice?CF_id=' . $_GET['CF_id'] . '" border="0" id="CF_invoice"></iframe>';

}
// {{{ checkfront_booking()
/* 
 * Display admin
 * @param void
 * @return void
*/
function checkfront_booking() {
	global $Checkfront;
	if($_GET['CF_id']) {
		return checkfront_invoice();	
	} else {
		include(dirname(__FILE__).'/booking.php');
	}
	return $html;
}

require('Checkfront.php');

$Checkfront = new Checkfront(get_option('checkfront_host'));
$Checkfront->query['date'] = $Checkfront->date($_GET['CF_date']);
$Checkfront->query['duration'] = $Checkfront->duration($_GET['CF_duration']);
$Checkfront->query['adults'] = $Checkfront->adults($_GET['CF_adults']);
$Checkfront->date_format = get_option('date_format');

add_shortcode('checkfront', 'checkfront_func');
add_action('admin_menu', 'checkfront_conf');

register_sidebar_widget('Checkfront Booking Search', 'checkfront_widget'); 

# required includes
wp_enqueue_script('jquery'); 
wp_enqueue_script('checkfront', $Checkfront->url . '/client/wp.js');
wp_enqueue_style('checkfront', $Checkfront->url  . '/client/wp.css');

?>
