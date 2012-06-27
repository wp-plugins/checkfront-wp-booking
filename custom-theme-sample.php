<?php
/**
 *  @package WordPress
 *  @subpackage Default_Theme
 *  Template Name: Checkfront Booking Page
 *
 *  The easiest way to use Checkfront is to create a new post in the
 *  wordpres editor, and paste in the Checkfront shortcode: [checkfront]
 *  There are additinal options you can pass to the shortcode to change
 *  the behavour or layout.
 *
 *  Alternativly, if you wish to build Checkfront into a theme, you can
 *  use this sample as a starting point.  You will need to tweak it
 *  with your theme.
 *
 *  The pipe.html file must be on the server.  This helps with sizing the 
 *  booking portal.
 *
 *  Please see our Wordpress Setup Guide for up to date information:
 *  http://www.checkfront.com/extend/wordpress/
 *
 *  For more complex custom integrations, consider our API:
 *  http://www.checkfront.com/api/2/
 *  
 *  The Checkfront plugin must be installed and active.  This method
 *  only works with the v2 interface.
*/

get_header($template_name);

// replace demo.checkfront.com with your checkfront host
$Checkfront = new Checkfront('demo.checkfront.com');
$Checkfront->interface = 'v2';

// if using https, be sure and change the schema in the pipe
$Checkfront->pipe = "http://{$_SERVER['HTTP_HOST']}/wp-content/plugins/checkfront-wp-booking/pipe.html";
$Checkfront->render(
	array(
		'options'=>'tabs,compact',
		'style'=>'background-color: FFF;font:Tahoma',
	)
);

get_footer($template_name);

