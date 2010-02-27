<?php
if(isset($_POST['checkfront_host'])) {
	update_option('checkfront_mode',$_POST['checkfront_mode']);
	if($host = $Checkfront->valid_host($_POST['checkfront_host'])) {
		update_option('checkfront_host',$host);
		$Checkfront->host = $host;
		$cf_msg = "Updated!";
	} else {
		$cf_msg = "Invalid URL!";
	}
}
?>
<form method="post">
<div class="wrap">
<input type="hidden" name="checkfront_settings" value="1">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>Checkfront for WordPress</h2>
<p ><a href="http://www.checkfront.com/"><img src="<?php echo $Checkfront->plugin_url?>/logo.png" style="float: left; padding-right: 1em; border:0;"></a>
Checkfront is an online booking platform that allows businesses to manage their inventories online, centralize reservations, process payments and get unified access to leading distribution channels.<br /><a href="http://www.checkfront.com" target="_blank">http://www.checkfront.com</a></p>
</p>
<hr style="border:0; clear: both">
<h3>Get Started</h3>
<ol>
<li><a href="https://www.checkfront.com/start/" target="_blank">Create your free Checkfront account</a>, setup your inventory, and configure your account and e-commerce.</li>
<li>Supply your Checkfront URL in the API Setup above.</li>
<li>Create a <a href="post-new.php">new Wordpress post</a> and embed the booking system with the shortcode <code>[checkfront booking="embed"]</code></li>
</ol>
	<div class="metabox-holder meta-box-sortables pointer">
		<div class="postbox">
<?php
if(isset($cf_msg)){?>
<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p><strong><?php echo $cf_msg?></strong></p></div>
<?php }?>
			<h3 class="hndle"><span>API Setup</span></h3>
			<div class="inside" style="padding: 0 10px">
				<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="checkfront_email">Checkfront Host Url:</label></th>
						<td nowrap>https://<input name="checkfront_host" style="width: 15em" id="checkfront_host" value="<?php echo $Checkfront->host?>" class="regular-text" type="text"> </td>
						<td><em>Location of the Checkfront Management Console</em></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="checkfront_mode">Display mode:</label></th>
						<td><input type="radio" name="checkfront_mode" id="inline" value="inline"><label for="inline" value="inline">Inline</label> &nbsp;&nbsp; <input type="radio" value="frame" id="framed" name="checkfront_mode"><label for="framed">Framed</label>
						<td><em>In-line will blend better with your existing style, but some themes may have unpredictable results with the Checkfront layout.  </em></td>

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
<p style="color: #555"> Plugin Version: <?php print CHECKFRONT::PLUGIN_VERSION?>, API Version: <?php print CHECKFRONT::API_VERSION?></p>
</form>
