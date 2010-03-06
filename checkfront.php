<?php 
/* 
Plugin Name: Checkfront integrated booking and availability plugin
Plugin URI: http://www.checkfront.com/extend/wordpress
Description: Connects Wordpress to the Checkfront Online Booking platform.  
Version: 1.0
Author: Checkfront Inc.
Author URI: http://www.checkfront.com/
Copyright: 2008 - 2010 Checkfront Inc 
*/

if ( ! defined( 'WP_PLUGIN_URL' ) ) define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) ) define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

class Checkfront {

	public $api_version = '1.0';
	public  $host= NULL; 
	public $mode='inline';
	private $session_id;

	function __construct($host=NULL) {
		$this->set_host($host);
		if($mode = get_option('checkfront_mode')) {
			$this->mode = $mode;
		}

	}

	function set_host($host) {
		$this->host = $host;
		$this->url = "//{$this->host}";
		$this->api_url = "{$this->url}/api/" . $this->api_version;
	}

	function valid_host($value) {
		if(!preg_match('~^http://|https://~',$value)) $value = 'https://' . $value;
		if($uri = parse_url($value)) {
			if($uri['host']) {
				$host= $uri['host'];
			}
		}
		return $host;
	}

	function booking($data=array()) {
		if($_GET['CF_slip']) {
			foreach($_GET['CF_slip'] as $id=> $slip) {
				setcookie('CF_slip[' . $id . ']',$slip,0,'/');
			}
		}
    }

	function error_config() {
		if(is_admin()) {
			return '<p style="padding: .5em; border: solid 1px red;">' . __('Please configure the Checkfront plugin in the Wordpress Admin.') . '</p>';
		} else {
			return '<p style="padding: .5em; border: solid 1px red;">' . __('Bookings not yet available here.') .'</p>';
		}
	}

	function embed_booking() {
		if(empty($this->host)) return $this->error_config();
		if($this->mode == 'framed') {
			$html .= '<iframe src="//' . $this->host . '/www/client/?wp" style="border: solid 1px #999; width: 100%; height: 600px;"></iframe>';
		} else {
			include(dirname(__FILE__).'/dropbox.php');
		}
		return $html;
	}
}

// {{{ checkfront_func()
/* 
 * 
 * @param $atts array 
 * @param $content string
 * @return string
*/
function checkfront_func($atts, $content=null) {
	$atts=shortcode_atts(array(
		'booking' => '0',
	), $atts);
	return checkfront($atts);
}

// {{{ checkfront()
/* 
 * 
 * @param void
 * @return void
*/
function checkfront($atts) {
	global $Checkfront;
	if($atts['booking'] and is_page() or is_single()) {
		return $Checkfront->embed_booking();
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

	if ( function_exists('add_submenu_page') ) {
		add_submenu_page('plugins.php', __('Checkfront'), __('Checkfront'), 'manage_options', 'checkfront', 'checkfront_setup');
	}

	add_filter('plugin_row_meta', 'checkfront_plugin_meta', 10, 2 );
}

// {{{ checkfront_setup()
/* 
 * Display setup page
 * @param void
 * @return void
*/
function checkfront_setup() {
	global $Checkfront;
	wp_enqueue_script('jquery'); 
	include(dirname(__FILE__).'/setup.php');
}


// {{{ checkfront_head()
/* Add style and js for booking window if called
 * 
 * @param void
 * @return void
*/
function checkfront_head() { 
	global $post, $Checkfront;
	if(!isset($Checkfront->host)) return;
		if ($pos = stripos($post->post_content,'[checkfront') or $pos === 0) {
		print ' <script src="//' . $Checkfront->host . '/www/client.js?wp" type="text/javascript"></script>' ."\n";
		print ' <link rel="stylesheet" href="//' . $Checkfront->host . '/www/client.css?wp" type="text/css" media="all" />' . "\n";

		// Disable Comments
		add_filter('comments_open', 'checkfront_comments_open_filter', 10, 2);
		add_filter('comments_template', 'checkfront_comments_template_filter', 10, 1);
	}
}

// {{{ checkfront_comments_open_filter()
/* Disable comments
 * 
 * @param void
 * @return void
*/
function checkfront_comments_open_filter($open, $post_id=null) {
	 return $open;
}

// {{{ checkfront_comments_template_filter()
/* Disable comments
 * 
 * @param void
 * @return void
*/
function checkfront_comments_template_filter($file) {
    return dirname(__FILE__).'/empty';
}

// {{{ checkfront_init()
/* 
 * @param void
 * @return void
*/
function checkfront_init() {
	add_action('wp_head', 'checkfront_head'); 
	# required includes
	wp_enqueue_script('jquery'); 
}

// {{{ checkfront_plugin_meta()
/* 
 * @param void
 * @return void
*/
function checkfront_plugin_meta($links, $file) {
	// create link
	if (basename($file,'.php') == 'checkfront') {
		return array_merge(
			$links,
			array( '<a href="plugins.php?page=checkfront">' . __('Settings') . '</a>','<a href="http://www.checkfront.com/support/faq">' . __('FAQ') . '</a>') 
		);
	}
	return $links;
}

$Checkfront = new Checkfront(get_option('checkfront_host'));
add_shortcode('checkfront', 'checkfront_func');
add_action('admin_menu', 'checkfront_conf');
add_action('init', 'checkfront_init');
?>
