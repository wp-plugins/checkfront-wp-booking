<?php
$html = '<div id="CF">';
$html .= '<form action="' . $this->api_url . '" method="get">';
$html .= '<input type="hidden" name="CF_html" value="true"><input type="hidden" name="CF_slip_name" value="CF_slip">';
$html .= '<input type="hidden" name="CF_return_url" value="' . get_permalink() . '"><input type="hidden" name="cf_slip_name" value="CF_slip">';
$html .= '<input type="hidden" name="CF_date" value="' . $this->date . '">';
$html .= '<input type="hidden" name="CF_adults" value="' . $this->adults. '">';
$html .= '<input type="hidden" name="CF_duration" value="' . $this->duration. '">';
if(isset($_COOKIE['CF_slip']) and count($_COOKIE['CF_slip'])) {
	foreach($_COOKIE['CF_slip'] as $id => $slip) {
		$html .= '<input type="hidden" name="CF_slip[' . $id . ']" value="' . $slip. '">';
	}
}
if(isset($_COOKIE['CF_slip']) and count($_GET['CF_slip'])) {
	foreach($_GET['CF_slip'] as $id => $slip) {
		$html .= '<input type="hidden" name="CF_slip[' . $id . ']" value="' . $slip. '">';
	}
}
$html .= '<ul id="CF_tabs"></ul>';
$html .= '<div id="CF_items"><strong id="CF_desc">Availability for: <span></span></strong>';
$html .= '</div></form></div>';
$html .= '<p id="CF_i"><a style="background: url(\'' . $this->plugin_url .'/icon.png\') left center no-repeat; padding: 5px 0 5px 18px; font-size: smaller; color: 555;"  href="http://www.checkfront.com/">Online Bookings by Checkfront</a><!--' . $this->app_id . '--></p>';
return $html;
?>
