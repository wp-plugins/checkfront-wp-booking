<?php if(isset($_POST['checkfront_host'])) {
	update_option('checkfront_mode',$_POST['checkfront_mode']);
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
<script src="<?php print WP_PLUGIN_URL . '/' . basename(dirname(__FILE__))?>/setup.js"></script>
<form method="post">
<div class="wrap">
<input type="hidden" name="checkfront_settings" value="1">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>Checkfront for WordPress</h2>
<p ><a href="http://www.checkfront.com/"><img src="//media.checkfront.com/images/checkfront.png" style="float: left; padding-right: 1em; border:0;"></a>
Checkfront is an online booking platform that allows businesses to manage their inventories online, centralize reservations, process payments and get unified access to leading distribution channels. &nbsp; <a href="http://www.checkfront.com" target="_blank">http://www.checkfront.com</a></p>
</p>
<hr style="border:0; clear: both">
<h3>Get Started</h3>
<ol>
<li><a href="https://www.checkfront.com/start/" target="_blank">Create your free Checkfront account</a>, setup your inventory, configure your account and e-commerce.</li>
<li>Supply your Checkfront URL in the setup below.</li>
<li>Create a <a href="post-new.php">new Wordpress post</a> and embed the booking system with by pasting in the shortcode: <br /><code style="font-size: 1.1em; font-weight: bold">[checkfront booking="embed"]</code></li>
<li>Enable the <a href="widgets.php">Checkfront sidebar widget</a> (optional)</li>
</ol>
	<div class="metabox-holder meta-box-sortables pointer">
		<div class="postbox">
<?php
if(isset($cf_msg)){?>
<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p><strong><?php echo $cf_msg?></strong></p></div>
<?php }?>
			<h3 class="hndle"><span>Setup</span></h3>
			<div class="inside" style="padding: 0 10px">
				<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="checkfront_email">Checkfront Host Url:</label></th>
						<td nowrap>https://<input name="checkfront_host" style="width: 15em" id="checkfront_host" value="<?php echo $Checkfront->host?>" class="regular-text" type="text"> </td>
						<td><em>Location of your Checkfront Management Console [<a href="https://www.checkfront.com/start">Create</a>]</em></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="checkfront_mode">Render mode:</label></th>
						<td><input type="radio" name="checkfront_mode" id="inline" value="inline" <?php if($Checkfront->mode == 'inline') print 'checked="checked"';?>><label for="inline" value="inline">Inline</label> &nbsp;&nbsp; <input type="radio" value="framed" id="framed" name="checkfront_mode"  <?php if($Checkfront->mode == 'framed') print 'checked="checked"';?>><label for="framed">Framed</label></td>
						<td><em>In-line will blend better with your existing layout, but is not compatible with some themes.  </em></td>
					</tr>
					<tr>
					<td>
						<input type="submit" name="submit" class="button-primary" value=" Update " /> 
				</td>
					</tr>
				</tbody>
			</table>

			</div>
		</div>
	</div>
</form>
 <div class="metabox-holder meta-box-sortables pointer">
        <div class="postbox">
			<h3 class="hndle"><span  style="background: url('//www.checkfront.com/images/twitter.png') left center no-repeat; padding: 1em 1em 1em 24px;">Latest news</span><a href="http://twitter.com/Checkfront">Follow Checkfront</a></h3>
			<div class="inside" style="padding: 0 10px">
<div id="tweet_container" class="form-table" style="background: #fff; "><p style="background: url('//www.checkfront.com/images/load.gif') left center no-repeat; padding: 1em 1em 1em 24px;">Loading</div> 
<br />
</div>
</div>
</div>
<p style="color: #555">API Version: <?php print $Checkfront->api_version?></p>
