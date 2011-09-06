<label class="append-1">&nbsp;居住地:&nbsp;&nbsp;&nbsp;</label>
<label>&nbsp;省份:&nbsp;&nbsp;&nbsp;</label>
<?php $tmpAttr = 'id="province" name="province" style="width: 200px;"';
	echo form_dropdown('province', $provinces, $provinceSelected, $tmpAttr);
?>
<label>&nbsp;城市:&nbsp;&nbsp;&nbsp;</label>
<?php $tmpAttr = 'id="city" name="city" style="width: 200px;"';
	echo form_dropdown('city', $cities, $citySelected, $tmpAttr);
?>