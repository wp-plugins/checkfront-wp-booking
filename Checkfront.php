<?php /**
 * Checkfront  - connects to the Checkfront Booking API 
 * @author     Jason Morehouse <jm@checkfront.com>
 * @copyright  Checkfront Inc.
*/
class Checkfront {
	
	const API_VERSION = '0.5';
	const PLUGIN_VERSION = '0.8';

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
		$scheme = (isset($_SERVER['HTTPS'])) ? 'https' : 'http';
		$this->url = "{$scheme}://{$this->host}";
		$this->api_url = "{$this->url}/api/" . CHECKFRONT::API_VERSION;
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
			return checkfront_invoice($id);
		} else {
			include(dirname(__FILE__).'/booking.php');
		}
		return $html;
	}


}
