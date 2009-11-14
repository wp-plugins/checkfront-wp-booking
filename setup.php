<?php
if(isset($_POST['checkfront_host'])) {
	if($host = $Checkfront->valid_host($_POST['checkfront_host'])) {
		update_option('checkfront_host',$host);
		$Checkfront->host = $host;
	$cf_msg = "Connected!";
	} else {
	$cf_msg = "Invalid host!";
	}
}
?>
<?php
if(isset($cf_msg)){?>
<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p><strong><?php echo $cf_msg?></strong></p></div>
<?}?>
<form method="post">
<div class="wrap">
<input type="hidden" name="checkfront_settings" value="1">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>Checkfront for WordPress</h2>
<p ><a href="http://www.checkfront.com/"><img src="<?php echo $Checkfront->path?>/logo.png" style="float: left; padding-right: 1em; border:0;"></a>
Checkfront is an online booking platform that allows businesses to manage their inventories online, centralize reservations, process payments and get unified access to leading distribution channels.<br /><a href="http://www.checkfront.com" target="_blank">http://www.checkfront.com</a></p>
</p>
	<div class="metabox-holder meta-box-sortables pointer">
		<div class="postbox">
			<h3 class="hndle"><span>API Setup</span></h3>
			<div class="inside" style="padding: 0 10px">
				<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="checkfront_email">Checkfront Host Url:</label></th>
						<td>https://<input name="checkfront_host" id="checkfront_host" value="<?php echo $Checkfront->host?>" class="regular-text" type="text"> 
					<input type="submit" name="submit" class="button-primary" value=" Connect " /> 
					</tr>
			<tr>
				<th></th>
				<td>
<p> Checkfront is currently in Beta. Updates of this plugin may occur more frequent than normal.  Please keep it up to date.</p> 
				</td>
			</tr>
				</tbody>
			</table>
			</div>
		</div>
	</div>
<hr style="border:0; clear: both">
<h3>Get Started</h3>
<ol>
<li><a href="http://www.checkfront.com/start/" target="_blank">Create your free Checkfront accont</a>, setup your inventory, and configure your account and e-commerce.</li>
<li>Supply your Checkfront url in the API Setup above.</li>
<li>Enable the <a href="widgets.php">Checkfront Booking Search Widget</a></li>
<li>Create a <a href="post-new.php">new Wordpress post</a> and enbed the booking system with the shortcode <code>[checkfront booking="embed"]</code></li>
</ol>
<p style="color: #555"> Plugin Version: <?php print CHECKFRONT::PLUGIN_VERSION?>, API Version: <?php print CHECKFRONT::API_VERSION?></p>
</form>
