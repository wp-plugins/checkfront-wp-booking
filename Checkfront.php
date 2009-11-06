<?php /**
 * Checkfront  - connects to the Checkfront Booking API 
 * @author     Jason Morehouse <jm@checkfront.com>
 * @copyright  Checkfront Inc.
*/
class Checkfront {
	
	const API_VERSION = '0.5';
	const PLUGIN_VERSION = '0.7.1';

	private $app_id = 'API';
	public $host; 
	public $date_format;
	public $date;
	private $session_id;

	function __construct($host=NULL) {

		$this->set_host($host);
		if($app_id) {
			$this->app_id = $app_id;
		}

		$this->date = $this->date($_GET['CF_date']);
		$this->adults = $this->adults($_GET['CF_adults']);
		$this->duration = $this->adults($_GET['CF_duration']);

		$path = explode('/',dirname(__FILE__));

		$dir = array_pop($path);
		$this->path = '/'.PLUGINDIR.'/' . $dir;
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
		/* ssl is not required for basic inventory requests */
		$scheme = ($ssl) ? 'https' : 'http';
		$this->url = "{$scheme}://{$this->host}";
		$this->api_url = "{$this->url}/api/" . CHECKFRONT::API_VERSION;
	}
}
