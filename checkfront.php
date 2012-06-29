<?php 
/* 
Plugin Name: Checkfront Online Booking System
Plugin URI: http://www.checkfront.com/extend/wordpress
Description: Connects Wordpress to the Checkfront Online Booking, Reservation and Availability System.  Checkfront integrates into popular payment systems including Paypal, Authorize.net, SagePay and integrates into Salesforce, Xero and Google Apps.  Transactions, Reporting and Bookings are securly stored in the Checkfront backoffice app, while providing a self service booking portal on your own website.
Version: 2.5.1
Author: Checkfront Inc.
Author URI: http://www.checkfront.com/
Copyright: 2008 - 2012 Checkfront Inc 
*/

if ( ! defined( 'WP_PLUGIN_URL' ) ) define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );

class Checkfront {

	public $lib_version = '2.1';
	public $host= '';
	public $plugin_url = '';
	public $interface = 'v1';
	public $legacy_mode='inline';
	public $embed = false;

	public $widget = false;
	public $book_url = '';
	public $api_url = '';

	public $args = array();

	function __construct($cnf) {
		$this->set_host($cnf['host']);
		$this->plugin_url = $cnf['plugin_url'];
		$this->interface = ($cnf['interface']) ? $cnf['interface'] : 'v1';
	}


    /**
     * get shortcode arg defaults
     *
     * @param void
     * @return bool
    */
	public function get_args() {
		$this->args['view']= get_option('checkfront_view');
		$this->args['theme']= get_option('checkfront_theme');
		$this->args['style_background-color']= get_option('checkfront_style_background-color');
		$this->args['style_color']= get_option('checkfront_style_color');
		$this->args['style_font-family']= get_option('checkfront_style_font-family');
		$this->args['options-tabs']= get_option('checkfront_options-tabs');
		$this->args['options-compact']= get_option('checkfront_options-compact');
		$this->args['shortcode']= get_option('checkfront_shortcode');
		if(!$this->args['shortcode']) $this->args['shortcode'] = '[checkfront]';
		return true;
	}

    /**
     * sets the checkfront host
     *
     * @param string $host
     * @return bool
    */
	private function set_host($host) {
		$this->host = $host;
		$this->url = "//{$this->host}";

		// v1 only
		$this->api_url = "{$this->url}/api/2.0";
		return true;
	}

    /**
     * set valid host
     *
     * @param string $host
     * @return string $host  
    */
	private function valid_host($value) {
		if(!preg_match('~^http://|https://~',$value)) $value = 'https://' . $value;
		if($uri = parse_url($value)) {
			if($uri['host']) {
				$host= $uri['host'];
			}
		}
		return $host;
	}


    /**
     * display error when plugin is not yet configured
     *
     * @param void
     * @return string $html formatted message
    */
	public function error_config() {
		if(is_admin()) {
			return '<p style="padding: .5em; border: solid 1px red;">' . __('Please configure the Checkfront plugin in the Wordpress Admin.') . '</p>';
		} else {
			return '<p style="padding: .5em; border: solid 1px red;">' . __('Bookings not yet available here.') .'</p>';
		}
	}

    /**
     * render booking widget
     *
     * @param array $cnf shortcode paramaters
     * @return string $html rendering code
    */
	public function render($cnf) {
		$cnf = $this->clean($cnf);
		if($this->interface == 'v1') {
			return $this->v1_interface($cnf);
		} else {
			return $this->v2_interface($cnf);
		}
	}

    /**
     * clean short code params
     *
     * @param array $cnf shortcode paramaters
     * @return array $cnf formatted paramaters
    */
	private function clean($cnf) {
		foreach($cnf as $cnf_id => $data) {
			$data = preg_replace("/\#|'/",'',strip_tags($data));
			$cnf[$cnf_id] = $data;
		}
		return $cnf;
	}

    /**
     * render v1 legacy mode
     *
     * @param array $cnf shortcode paramaters
     * @return string $html rendering code
    */
	private function v1_interface($cnf) {
		$set = array();
		if($cnf['item_id'] >0) {
			$set[] = "item_id: '{$cnf['item_id']}'";
		}
		if($cnf['category_id'] >0) {
			$set[] = "category_id: '{$cnf['category_id']}'";
		}
		if(empty($this->host)) return $this->error_config();
		if($this->mode == 'framed') {
			$html = '<iframe src="//' . $this->host . '/www/client/?wp" style="border: 0; width: 100%; height: 800px"></iframe>';
		} else {
			$html = $this->droplet($set);
		}
		return $html;
	}

    /**
     * get the location of the pipe helper.  
     * The pipe helps performance and sizing of the v2 interface.
     *
     * @param void
     * @return string $pipe url (must be local to this domain)
    */
	private function get_pipe() {
		return WP_PLUGIN_URL . '/' . basename(dirname(__FILE__)) . '/pipe.html';
	}

	private function set_ids($ids) {
		return preg_replace("/[^0-9,]/",'',$ids);
	}


    /**
     * render v2 interface
     *
     * @param array $cnf shortcode paramaters
     * @return string $html rendering code
    */
	private function v2_interface($cnf) {

		$pipe = $this->get_pipe();
		$html = "\n<!-- CHECKFRONT BOOKING PLUGIN v{$this->lib_version}-->\n";
		$html .= '<div id="CHECKFRONT_BOOKING_WIDGET_01"><p id="CHECKFRONT_LOADER" style="background: url(\'https://media.checkfront.com/images/loader.gif\') left center no-repeat; padding: 5px 5px 5px 20px">Loading Booking System...</p></div>';
		$html .= "\n<script type='text/javascript'>\nnew CHECKFRONT.Widget ({";
		$html .= "host: '{$this->host}',\n";
		$html .= "pipe: '{$pipe}',\n";
		$html .= "target: 'CHECKFRONT_BOOKING_WIDGET_01',\n";
		// optional, or default items
		if($cnf['item_id']) {
			$this->cnf['item_id'] = $this->set_ids($this->cnf['item_id']);
			$html .= "item_id: '{$cnf['category_id']}',\n";
		}
		if($cnf['category_id']) {
			$this->cnf['category_id'] = $this->set_ids($this->cnf['category_id']);
			$html .= "category_id: '{$cnf['category_id']}',\n";
		}	
		if($cnf['theme']) $html .= "theme: '{$this->theme}',\n";
		if($cnf['width'] > 0)  $html .= "width: '{$cnf['width']}',\n";
		if($cnf['layout'])  $html .= "layout: '{$cnf['layout']}',\n";
		if($cnf['tid'])  $html .= "tid: '{$cnf['tid']}',\n";
		if($cnf['options'])  $html.= "options: '{$cnf['options']}',\n";
		if($cnf['style'])  $html .= "style: '{$cnf['style']}'";
		$html .="}).render();</script>";
		return $html;
	}	


	private function droplet_set($set=array()) {
		if(count($set)) {
			$CF_set = '<input type="hidden" id="CF_set" value="{' . implode(',',$set) . '}" />';
		}
		if($this->book_url) {
			$CF_set .= '<input type="hidden" id="CF_src" value="' . $this->book_url .'" />';
		}

		return $CF_set;
	}


    /**
     * v1 droplet
     *
     * @param array $cff
     * @return string html id
    */
	function droplet($set) {
		return '<div id="CF" class="' . $this->host . '"><p id="CF_load" class="CF_load">' . __('Searching availability...') . $this->droplet_set($set) . '</div>';
	}
}

/* ------------------------------------------------------
 * Wordpress Required Functions
/* ------------------------------------------------------*/

//Shortcode [clean-conract parameter="value"]
function checkfront_func($cnf, $content=null) {
	$cnf=shortcode_atts(array(
		'category_id' => '0',
		'item_id' => '0',
		'tid' => '',
		'discount' => '',
		'options' => '',
		'style' => '',
		'width' => '',
		'theme' => '',
		'category_id'=>'',
		'item_id'=>'',
	), $cnf);
	return checkfront($cnf);
}

// Global shortcode call
function checkfront($cnf) {
	global $Checkfront;
	if(is_page() or is_single()) {
		return $Checkfront->render($cnf);
	}
}

// Wordpress Admin Hook
function checkfront_conf() {
	global $Checkfront;
	$icon = WP_PLUGIN_URL . '/' . basename(dirname(__FILE__)) . '/icon.png';
	add_menu_page('Setup', 'Checkfront', 'read', __FILE__, 'checkfront_setup',$icon);

	if ( function_exists('add_submenu_page') ) {
		add_submenu_page('plugins.php', __('Checkfront'), __('Checkfront'), 'manage_options', 'checkfront', 'checkfront_setup');
	}

	add_filter('plugin_row_meta', 'checkfront_plugin_meta', 10, 2 );
}

// Wordpress Setup Page
function checkfront_setup() {
	global $Checkfront;
	wp_enqueue_script('jquery'); 
	wp_enqueue_script(WP_PLUGIN_URL . '/setup.js'); 
	include(dirname(__FILE__).'/setup.php');
}

// Init Checkfront, include any required js / css only when required
function checkfront_head() { 
	global $post, $Checkfront;
	if(!isset($Checkfront->host)) return;
	
	// does this page have any shortcode.  If not, back out.
	if($pos = stripos($post->post_content,'[checkfront') or $pos === 0) $Checkfront->embed = 1;

	// v1 widget
	if($Checkfront->widget) {
		$checkfront_widget_post = get_option("checkfront_widget_post");
		$checkfront_widget_page = get_option("checkfront_widget_page");
		$checkfront_widget_booking  = get_option("checkfront_widget_booking");

		if($Checkfront->embed and !$checkfront_widget_booking) { 
			$Checkfront->widget = 0;
		} else {
			if(is_page() and !$checkfront_widget_page) $Checkfront->widget = 0;
			if(is_single() and !$checkfront_widget_post) $Checkfront->widget = 0;

		}
	}

	if ($Checkfront->widget  or $Checkfront->embed) {
		$Checkfront->book_url = get_option("checkfront_book_url");
		if($Checkfront->interface == 'v1') {
			print ' <script src="//' . $Checkfront->host . '/www/client.js?wp" type="text/javascript"></script>' ."\n";
			print ' <link rel="stylesheet" href="//' . $Checkfront->host . '/www/client.css?wp" type="text/css" media="all" />' . "\n";
		} else {
			print ' <script src="//' . $Checkfront->host . '/lib/interface.js?v=3" type="text/javascript"></script>' ."\n";
		}
		if($Checkfront->embed) {
			// Disable Comments
			add_filter('comments_open', 'checkfront_comments_open_filter', 10, 2);
			add_filter('comments_template', 'checkfront_comments_template_filter', 10, 1);
		}
	}
}

// disable comments on booking pagfe
function checkfront_comments_open_filter($open, $post_id=null) {
	 return $open;
}

// disable comment include (required to clear)
function checkfront_comments_template_filter($file) {
    return dirname(__FILE__).'/xcomments.html';
}

// pligin init
function checkfront_init() {
	global $Checkfront;
	wp_register_sidebar_widget('checkfront_widget', 'Checkfront', 'checkfront_widget',array('description' => __('Availability calendar and search')));
	wp_register_widget_control('checkfront_widget', 'Checkfront', 'checkfront_widget_ctrl');
	add_action('wp_head', 'checkfront_head'); 
	# required includes
	wp_enqueue_script('jquery'); 

	$Checkfront->widget = (is_active_widget('checkfront_widget')) ? 1 : 0;
}

// Set admin meta
function checkfront_plugin_meta($links, $file) {

	// create link
	if (basename($file,'.php') == 'checkfront') {
		return array_merge(
			$links,
			array( 
				'<a href="plugins.php?page=checkfront">' . __('Settings') . '</a>',
				'<a href="http://www.checkfront.com/extend/wordpress/">' . __('Setup Guide') . '</a>',
				'<a href="http://www.checkfront.com/faq/">' . __('FAQ') . '</a>',
				'<a href="https://www.checkfront.com/login/">' . __('Checkfront Login') . '</a>',
		) 
		);
	}
	return $links;
}

// Show widget
function checkfront_widget() {
	global $Checkfront;
	if(!$Checkfront->widget) return;
	$checkfront_widget_title = get_option("checkfront_widget_title");
	if(!empty($checkfront_widget_title)) print '<h2 class="widgettitle">' . $checkfront_widget_title . '</h2>';
	print '<div id="CF_cal" class="' . $Checkfront->host . '"></div>';
	print $Checkfront->CF_set();
}

// Widget control
function checkfront_widget_ctrl() {

	if($_POST['checkfront_update']) {
		update_option("checkfront_book_url", $_POST['checkfront_book_url']);
		update_option("checkfront_widget_title", $_POST['checkfront_widget_title']);
		update_option("checkfront_widget_post ", $_POST['checkfront_widget_post']);
		update_option("checkfront_widget_page ", $_POST['checkfront_widget_page']);
		update_option("checkfront_widget_booking", $_POST['checkfront_widget_booking']);
	}

	$checkfront_book_url = get_option("checkfront_book_url");

	// try and find booking page in content 
	if(!$checkfront_book_url) {
		global $wpdb;
		$checkfront_book_url = $wpdb->get_var("select guid FROM `{$wpdb->prefix}posts` where post_content like '%[checkfront%' and post_type = 'page' limit 1");
		update_option("checkfront_widget_url", $checkfront_book_url);
	}

 	$checkfront_widget_title = get_option("checkfront_widget_title");
	$checkfront_widget_post = (get_option("checkfront_widget_post")) ? ' checked="checked"' : '';
 	$checkfront_widget_page = (get_option("checkfront_widget_page")) ? ' checked="checked"' : '';
 	$checkfront_widget_booking  = (get_option("checkfront_widget_booking")) ? ' checked="checked"' : '';

	print '<input type="hidden" name="checkfront_update" value="1" />';	
	print '<ul>';
	print '<li><label for="checkfront_book_url">' . __('Booking Page (URL)') . ': </label><input type="text" id="checkfront_book_url" name="checkfront_book_url" value="' . $checkfront_book_url . '" /> </li>';
	print '<li><label for="checkfront_widget_title">' . __('Title') . ': </label><input type="text" id="checkfront_widget_title" name="checkfront_widget_title" value="' . $checkfront_widget_title . '" /> </li>';
	print '<li><input type="checkbox" id="checkfront_widget_post" name="checkfront_widget_post" value="1"' . $checkfront_widget_post . '/><label for="checkfront_widget_post" />' . __('Show on posts') . '</li>';
	print '<li><input type="checkbox" id="checkfront_widget_page" name="checkfront_widget_page" value="1"' .  $checkfront_widget_page . '/><label for="checkfront_widget_post" />' . __('Show on pages') . '</li>';
	print '<li><input type="checkbox" id="checkfront_widget_booking" name="checkfront_widget_booking" value="1"' . $checkfront_widget_booking . '/><label for="checkfront_widget_booking" />' . __('Show on booking page') . '</li>';
	print '</ul>';
}

/*
 Create Checkront class.  If you wish to include this in a custom theme (not shortcode)
 see the custom-theme-sample.php
*/
$Checkfront = new Checkfront(
	array(
		'host'=>get_option('checkfront_host'),
		'plugin_url'=>WP_PLUGIN_URL,
		'legacy_mode'=>get_option('checkfront_mode'),
		'interface' =>get_option('checkfront_interface')
	);
);
add_shortcode('checkfront', 'checkfront_func');
add_action('admin_menu', 'checkfront_conf');
add_action('init', 'checkfront_init');
?>
