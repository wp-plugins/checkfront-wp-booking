<?php
$html = '<div id="CF">';
$html .= '<input type="hidden" name="CF_src" value="' . get_permalink() . '">';
if(isset($_COOKIE['CF_slip']) and count($_GET['CF_slip'])) {
	foreach($_GET['CF_slip'] as $id => $slip) {
		$html .= '<input type="hidden" name="CF_slip[' . $id . ']" value="' . $slip. '">';
	}
}
$html .= '<a id="CF_id" class="' . $this->host . '" href="http://www.checkfront.com/">Online Bookings by Checkfront</a><!--' . $this->app_id . '--></p></div>';
return $html;
?>
