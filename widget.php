<form id="CF_search" action="<?php echo $data['checkfront_search_path']?>">
<fieldset>
<legend><?php echo $data['checkfront_widget_title']?></legend>
<ol>
    <li class="date">
    <strong for="date">Date</strong><input id="CF_date" name="CF_date" value="<?php echo date($Checkfront->date_format,strtotime($Checkfront->query['date']))?>" type="text"style="width:140px">
	</li>
<?php if($data['checkfront_widget_duration_title']) {?>
	<li>
		<strong><?php print $data['checkfront_widget_duration_title']?>:</strong><input type="text" name="CF_duration" value="<?php echo $Checkfront->query['duration']?>" style="width: 30px" size="3">
	</li>
<?}?>
    <li>
        <input type="submit" value=" Search ">
    </li>
</ol>
</fieldset>
</form>

