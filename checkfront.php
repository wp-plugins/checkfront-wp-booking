<?php 
/* 
Plugin Name: Checkfront Booking
Plugin URI: http://www.checkfront.com/extend/wordpress
Description: Connects wordpress to the Checkfront Online Booking and Availablity platform.  
Version: 0.9
Author: Checkfront Inc
Author URI: http://www.checkfront.com/
Copyright: 2008 - 2010 Checkfront Inc 
*/

if ( ! defined( 'WP_PLUGIN_URL' ) ) define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) ) define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

class Checkfront {
	
	const API_VERSION = '0.9';
	const PLUGIN_VERSION = '0.9';

	public $app_id = 'CHECKFRONT_WP';
	public $host= NULL; 
	private $session_id;

	function __construct($host=NULL) {
		$this->set_host($host);
	}

    function set_host($host) {
        $this->host = $host;
        $this->url = "//{$this->host}";
        $this->api_url = "{$this->url}/api/" . CHECKFRONT::API_VERSION;
        $path = explode('/',dirname(__FILE__));
        $dir = array_pop($path);
        $this->plugin_url =  WP_PLUGIN_URL .'/' . $dir;
    }


	function date($str) {
		return ($str) ? date('Ymd',strtotime($str)): date('Ymd');
	}

	function duration($int) {
		return ($int>0) ? $int : 3;
	}

	function adults($int=1) {
		return ($int>0) ? $int : 2;
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
			return '<p style="padding: .5em; border: solid 1px red;">Please configure the Checkfront plugin in the Wordpress Admin.</p>';
		} else {
			return '<p style="padding: .5em; border: solid 1px red;">Bookings not yet available here.</p>';
		}
	}

	function embed_booking() {
		if(empty($this->host)) return $this->error_config();

		if(isset($_GET['CF_invoice'])) {
			return checkfront_invoice($_GET['CF_invoice']);
		} else {
			include(dirname(__FILE__).'/booking.php');
		}
		return $html;
	}
}

//Shortcode [clean-conract parameter="value"]
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

// {{{ checkfront_invoice()
/* 
 * Display admin
 * @param void
 * @return void
*/
function checkfront_invoice($id) {
	global $Checkfront;
	return '<iframe src="https://' . $Checkfront->host . '/www/invoice/?CF_id=' . $id. '" border="0" id="CF_invoice"></iframe>';

}


function checkfront_head() { 
	global $post, $Checkfront;
	if(!isset($Checkfront->host)) return;
		if ($pos = stripos($post->post_content,'[checkfront') or $pos === 0) {
		print ' <script src="//' . $Checkfront->host . '/www/client.js" type="text/javascript"></script>' ."\n";
		print ' <link rel="stylesheet" href="//' . $Checkfront->host . '/client/wp.css" type="text/css" media="all" />' . "\n";
		add_filter('comments_open', 'checkfront_comments_open_filter', 10, 2);
		add_filter('comments_template', 'checkfront_comments_template_filter', 10, 1);
	}
}

function checkfront_comments_open_filter($open, $post_id=null) {
	 return $open;
}

function checkfront_comments_template_filter($file) {
    return dirname(__FILE__).'/empty';
}


$Checkfront = new Checkfront(get_option('checkfront_host'));
add_shortcode('checkfront', 'checkfront_func');
add_action('admin_menu', 'checkfront_conf');
add_action('init', 'checkfront_init');

function checkfront_init() {
	global $Checkfront;
	
	add_action('wp_head', 'checkfront_head'); 

	# required includes
	wp_enqueue_script('jquery'); 
}

function checkfront_plugin_meta($links, $file) {

	// create link
	if (basename($file,'.php') == 'checkfront') {
		return array_merge(
			$links,
			array( '<a href="plugins.php?page=checkfront">' . __('Settings') . '</a>') 
		);
	}
	return $links;
}
?>
