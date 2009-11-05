<form class="checkfront" action="/book/">
<fieldset>
<legend>Booking</legend>
<ol>
    <li class="date">
    <strong for="date">Date</strong><input id="CF_date" name="CF_date" value="<?php echo date($Checkfront->date_format,strtotime($Checkfront->query['date']))?>" type="text"style="width:140px">
    </li>
    <li><strong>Nights:</strong><input type="text" name="CF_duration" value="<?php echo $Checkfront->query['duration']?>" style="width: 30px" size="3">
        <strong>Adults:</strong><input type="text" style="width: 30px" name="CF_adults" value="<?php echo $Checkfront->query['adults']?>"  size="3">
    </li>
    <li>
        <input type="submit" value=" Search ">
    </li>
</ol>
</fieldset>
</form>

