<?php 
if(isset($_POST['checkfront_host'])) {
	$Checkfront->mode = $_POST['checkfront_mode'];
	if($host = $Checkfront->valid_host($_POST['checkfront_host'])) {
		update_option('checkfront_host',$host);
		$Checkfront->host = $host;
		$cf_msg = "Updated!";
	} else {
		$cf_msg = "Invalid URL!";
	}
}
?>
<div style="width: 800px">
<script type="text/javascript">
jQuery(document).ready(function() {

	function clean(str) {
		return str.replace(/[^\d\w\-\_ , "]/ig,'');
	}

	jQuery('#shortcode_generator').click(function() {

		height = 600;
		width = 1150;
		var cwidth=(window.screen.width-width)/2;
		var cheight=(window.screen.height-height)/2;var param="location=yes,status=yes,resizable=yes,scrollbars=yes,menubar=yes,toolbar=yes,width="+width+',height='+height+',left='+cwidth+',top='+cheight;
		var sw=window.open(this.href,'',param);sw.focus();return false;
	});
});

</script>
<div style="width: 500px; float: left">
<p>Checkfront is a powerful online booking system that allows businesses to manage their inventories, centralize reservations, and process payments. </p>

<h3>Quick Start</h3>
<ul style="font-size: 16px">
<li style="padding: 5px 0; height: 25px; line-height: 25px;"><strong style="margin-right: 10px; background-color: #ccc; border-radius: 20px; clear: none; color: #000; display: inline-block; float: left; font-style: normal; height: 25px; font-weight: bold; line-height: 25px;font-size:14px; text-align: center; width: 25px;">1</strong> Create and configure <a href="https://www.checkfront.com/start/?src=wp-setup" target="_blank">your Checkfront account</a>.</li>
<li style="padding: 5px 0; height: 25px; line-height: 25px;"><strong style="margin-right: 10px; background-color: #ccc; border-radius: 20px; clear: none; color: #000; display: inline-block; float: left; font-style: normal; height: 25px; font-weight: bold; line-height: 25px;font-size:14px; text-align: center; width: 25px;">2</strong> Supply your Checkfront URL and optional settings <a href="#checkfront_setup">below</a>.</li>
<li style="padding: 5px 0; height: 25px; line-height: 25px;"><strong style="margin-right: 10px; background-color: #ccc; border-radius: 20px; clear: none; color: #000; display: inline-block; float: left; font-style: normal; height: 25px; font-weight: bold; line-height: 25px;font-size:14px; text-align: center; width: 25px;">3</strong> Create a new page and supply the <a href="#shortcode">short code</a> you created.</li>
<li style="padding: 5px 0; height: 25px; line-height: 25px;"><strong style="margin-right: 10px; background-color: #ccc; border-radius: 20px; clear: none; color: #000; display: inline-block; float: left; font-style: normal; height: 25px; font-weight: bold; line-height: 25px;font-size:14px; text-align: center; width: 25px;">4</strong> Start accepting online bookings.</li>
</ul>
</div>
<div style="margin-top: 1em; float: right; width: 275px; box-shadow: 0 0 2px #ddd; border-radius: 6px; background-color: #fff; border: solid 1px #ddd; padding: 10px;">
<div style="text-align: center">
<a href="http://www.checkfront.com/"><img src="//www.checkfront.com/images/brand/Checkfront-Logo-45.png" height="40" alt="Checkfront" /></a><br />
<strong>Smart, Simplified Online Bookings</strong><br /><br />
</div>
<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fcheckfront.bookings&amp;send=false&amp;layout=button_count&amp;width=250&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=132896805841" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:290px; margin-bottom: 10px; height:21px;" allowTransparency="true"></iframe>
<!-- Place this tag in your head or just before your close body tag -->
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<!-- Place this tag where you want the +1 button to render -->
<div class="g-plusone" data-size="small" data-annotation="inline" data-href="http://www.checkfront.com/"></div>
<br />
<br />
<a href="http://twitter.com/Checkfront" style="background: url('https://www.checkfront.com/images/twitter.png') left center no-repeat; padding: 5px 5px 5px 20px" target="_blank">Follow us on Twitter</a><br /><br />
<a href="http://www.checkfront.com/support/" style="background: url('https://www.checkfront.com/images/brand/Checkfront-Icon-16.png') left center no-repeat; padding: 5px 5px 5px 20px;" target="_blank">Support Library</a><br /><br />
<a href="http://www.checkfront.com/wordpress/" style="background: url('http://s.wordpress.org/favicon.ico?3') left center no-repeat; padding: 5px 5px 5px 20px;" target="_blank">Checkfront Wordpress Setup Guide</a>
</div>
<br style="clear: both" />
<form method="post" action="">
	<div class="metabox-holder meta-box-sortables pointer">
		<div class="postbox">
			<h3 class="hndle">Setup</h3>
<?php
if(isset($cf_msg)){?>
<div style="background-color: rgb(255, 251, 204); margin:1em 1em 0em 1em" id="message" class="updated fade"><p><strong><?php echo $cf_msg?></strong></p></div>
<?php }?>
			<div class="inside" style="padding: 0 10px">
				<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="checkfront_email">Checkfront Host Url:</label></th>
						<td nowrap>https://<input name="checkfront_host" style="width: 15em;font-weight: bold" id="CF_id" value="<?php echo $Checkfront->host?>" class="regular-text" type="text" /><br /><em style="color: #888">Eg: demo.checkfront.com</em> </td>
						<td id="CF_status"><em>Location of your Checkfront Admin</td>
					</tr>
					<tr>
					<td>
						<input type="submit" name="submit" class="button-primary" value=" Update " /> 
</td><td>
Don't have a Checkfront account?
 <a href="https://www.checkfront.com/start" target="_blank">Start Your Free Trial</a></em></td>
				</td>
					</tr>
				</tbody>
			</table>

			</div>
		</div>
	</div>
		<a name="shortcode"></a>
	<div class="metabox-holder meta-box-sortables pointer">
		<div class="postbox">
			<h3 class="hndle">Use</h3>
			<div class="inside" style="padding: 0 10px">
				<table class="form-table">
				<tbody>
<?php if($Checkfront->host) {?>
					<tr valign="top">
						<td scope="row" colspan="2">You can embed the Checkfront booking portal into any page by pasting in this shortcode where you'd like it to appear:</td>
					</tr>
					<tr>
						<td scope="row" colspan="2"><strong style="font-size: 14px">[checkfront]</strong> &nbsp; &nbsp; 
						<a  class="button-primary" href="https://<?php echo $Checkfront->host?>/manage/extend/integrate/droplet/?src=wordpress" value=" Update " target="_blank" id="shortcode_generator"/>Launch Shortcode Generator</a></td>
					</tr>
<?php }?>
					<tr><td colspan="2"><strong>Quick Setup Guide</strong> <small>3.5 minutes</small></td></tr>
					</tr>
									<tr><td colspan="3">
<iframe style="margin-left: 1em; border: solid 1px #aaa; box-shadow: 0 0 5px #ccc" width="740" height="415" src="http://www.youtube-nocookie.com/embed/VlvzZWiAySU?rel=0" frameborder="0" allowfullscreen></iframe>
</td></tr>
	<tr>
					<td><strong>Require more help?</strong>  Please see our <a href="http://www.checkfront.com/support/wordpress">wordpress setup guide</a> in our  <a href="http://www.checkfront.com/support/">support library</a> or <a href="http://www.checkfront.com/conatct/">contact us</a> and we'd be happy to assist.</td>
					</td>
					</tr>
				</tbody>
			</table>

			</div>
		</div>
	</div>
</form>
<div>

<p style="float: left; color: #555">&copy; Checkfront Inc 2008 - <?php print date('Y')?></p>

<p style="float: right; color: #999">
<a style="color: #777;  font-size: 11px" href="http://www.checkfront.com/">Learn More</a>
&nbsp;|&nbsp; 
<a style="color: #777;  font-size: 11px" href="http://www.checkfront.com/updates">Recent Updates</a>
&nbsp;|&nbsp; 
<a style="color: #777;  font-size: 11px" href="http://www.checkfront.com/support">Support</a>
&nbsp;|&nbsp; 
<a style="color: #777;  font-size: 11px" href="http://www.checkfront.com/developers">Developers</a>
&nbsp;|&nbsp; 
<a style="color: #777;  font-size: 11px" href="http://www.checkfront.com/privacy">Privacy</a>
&nbsp;|&nbsp; 
<a style="color: #777; font-size: 11px" href="http://www.checkfront.com/terms">Terms of Service</a> 
</p>
</div>
</div>
