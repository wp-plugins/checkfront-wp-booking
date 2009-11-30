<?php 
/* 
Plugin Name: Checkfront Booking
Plugin URI: http://www.checkfront.com/extend/wordpress
Description: Connects wordpress to the Checkfront Online Booking and Availablity platform.  Checkfront is currently in Beta. Updates of this plugin may occur regularly --  please keep it up to date.
Version: 0.8.2
Author: Checkfront Inc
Author URI: http://www.checkfront.com/
Copyright: 2009 Checkfront Inc 
*/

if ( ! defined( 'WP_PLUGIN_URL' ) ) define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) ) define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

class Checkfront {
	
	const API_VERSION = '0.8';
	const PLUGIN_VERSION = '0.8.2';

	public $app_id = 'CHECKFRONT_WP-AER124';
	public $host= NULL; 
	public $date_format;
	public $date;
	private $session_id;
	public $adults;
	public $duration;

	function __construct($host=NULL) {

		$this->set_host($host);
		if(isset($_GET['CF_date'])) $this->date = $this->date($_GET['CF_date']);
		if(isset($_GET['CF_adults'])) $this->adults = $this->adults($_GET['CF_adults']);
		if(isset($_GET['CF_duration'])) $this->duration = $this->adults($_GET['CF_duration']);

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

	function set_host($host) {
		$this->host = $host;
		$this->url = "//{$this->host}";
		$this->api_url = "{$this->url}/api/" . CHECKFRONT::API_VERSION;
		$path = explode('/',dirname(__FILE__));
		$dir = array_pop($path);
		$this->plugin_url =  WP_PLUGIN_URL .'/' . $dir;
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

		if(isset($_GET['CF_id'])) {
			return checkfront_invoice($_GET['CF_id']);
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


// {{{ checkfront_widget()
/* 
 * Display admin
 * @param void
 * @return void
*/
function checkfront_widget() {
	global $Checkfront;
    $data = get_option('checkfront_widget');

	include(dirname(__FILE__).'/widget.php');
}

// {{{ checkfront_widget()
/* 
 * Display admin
 * @param void
 * @return void
*/
function checkfront_widget_options() {
	global $Checkfront;
	$data = get_option('checkfront_widget');
?>
  <p><label>Title<input name="checkfront_widget_title" type="text" value="<?php echo $data['checkfront_widget_title']; ?>" /></label><em style="color: #888">Display title of widget</em></p>
  <p><label>Path<input name="checkfront_search_path" type="text" value="<?php echo $data['checkfront_search_path']; ?>" /></label><em style="color:#888">Path to your booking page</em></p>
  <p><label>Duration Title<input name="checkfront_widget_duration_title" type="text" value="<?php echo $data['checkfront_widget_duration_title']; ?>" /></label><br /><em style="color:#888">Leave blank to hide</em></p>
  <p><label>Default Duration<input name="checkfront_widget_default_duration" type="text" value="<?php echo $data['checkfront_widget_default_duration']; ?>" /></label><br /><em style="color:#888">Default duration</em></p>
<?php
	if (isset($_POST['checkfront_search_path'])){
		$data['checkfront_search_path'] = attribute_escape($_POST['checkfront_search_path']);
		$data['checkfront_widget_title'] = attribute_escape($_POST['checkfront_widget_title']);
		$data['checkfront_widget_duration_title'] = attribute_escape($_POST['checkfront_widget_duration_title']);
		$data['checkfront_widget_default_duration'] = attribute_escape($_POST['checkfront_widget_default_duration']);
		update_option('checkfront_widget', $data);
	}

}


// {{{ checkfront_invoice()
/* 
 * Display admin
 * @param void
 * @return void
*/
function checkfront_invoice($id) {
	global $Checkfront;
	return '<iframe src="https://' . $Checkfront->host . '/widget/invoice?CF_id=' . $id. '" border="0" id="CF_invoice"></iframe>';

}


add_action('wp_head', 'checkfront_head'); 
function checkfront_head() { 
	global $post, $Checkfront;
	if(!isset($Checkfront->host)) return;
	if (stripos($post->post_content,'[checkfront')) {
		print ' <script src="//' . $Checkfront->host . '/client/wp.js" type="text/javascript"></script>' ."\n";
		print ' <link rel="stylesheet" href="//' . $Checkfront->host . '/client/wp.css" type="text/css" media="all" />' . "\n";

		add_filter('comments_open', 'checkfront_comments_open_filter', 10, 2);
		add_filter('comments_template', 'checkfront_comments_template_filter', 10, 1);
	}

	if(is_active_widget('checkfront_widget')) {
		print ' <script src="' . $Checkfront->plugin_url . '/search.js" type="text/javascript"></script>' ."\n";
		print ' <link rel="stylesheet" href="' . $Checkfront->plugin_url. '/search.css" type="text/css" media="all" />' . "\n";
	}	
}

function checkfront_comments_open_filter($open, $post_id=null) {
	 return $open;
}

function checkfront_comments_template_filter($file) {
    return dirname(__FILE__).'/empty';
}


$Checkfront = new Checkfront(get_option('checkfront_host'));
$Checkfront->query['date'] = $Checkfront->date(isset($_GET['CF_date']) ? $_GET['CF_date'] : NULL );
$Checkfront->query['duration'] = $Checkfront->duration(isset($_GET['CF_duration']) ? $_GET['CF_duration'] : 0);
$Checkfront->query['adults'] = $Checkfront->adults(isset($_GET['CF_adults']) ? $_GET['CF_adults'] : 0);
$Checkfront->date_format = get_option('date_format');

add_shortcode('checkfront', 'checkfront_func');
add_action('admin_menu', 'checkfront_conf');
add_action('init', 'checkfront_init');

function checkfront_init() {
	global $Checkfront;
	register_sidebar_widget('Checkfront Booking Search', 'checkfront_widget'); 
    register_widget_control('Checkfront Booking Search', 'checkfront_widget_options');

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
