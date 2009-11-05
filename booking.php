<?php
$html .= '<div id="CF">';
$html .= '<form action="' . $Checkfront->api_url . '" method="get">';
$html .= '<input type="hidden" name="CF_html" value="true"><input type="hidden" name="CF_slip_name" value="CF_slip">';
$html .= '<input type="hidden" name="CF_return_url" value="' . get_permalink() . '"><input type="hidden" name="cf_slip_name" value="CF_slip">';
$html .= '<input type="hidden" name="CF_date" value="' . $Checkfront->date . '">';
$html .= '<input type="hidden" name="CF_adults" value="' . $Checkfront->adults. '">';
$html .= '<input type="hidden" name="CF_duration" value="' . $Checkfront->duration. '">';
if(count($_COOKIE['CF_slip'])) {
	foreach($_COOKIE['CF_slip'] as $id => $slip) {
		$html .= '<input type="hidden" name="CF_slip[' . $id . ']" value="' . $slip. '">';
	}
}
if(count($_GET['CF_slip'])) {
	foreach($_GET['CF_slip'] as $id => $slip) {
		$html .= '<input type="hidden" name="CF_slip[' . $id . ']" value="' . $slip. '">';
	}
}
$html .= '<ul id="CF_tabs"></ul>';
$html .= '<div id="CF_items"><strong id="CF_desc">Availability for: <span></span></strong>';
$html .= '</div></form></div>';
$html .= '<p id="CF_i"><a style="background-image: url(\'' . $Checkfront->path .'/icon.png\')" href="http://www.checkfront.com/">Online Bookings by Checkfront&trade;</a></p>';
return $html;
?>
