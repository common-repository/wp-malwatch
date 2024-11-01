<?php 
	$settings = $this->getSettingsKeywords(); 
	$settingsChecked = get_option('WPMW Scan Check Settings');
	for($i=0;$i<count($settings);$i++) {
		if($i<count($settings) - 1)
			$keyWords .= $settings[$i].",";
		else
			$keyWords .= $settings[$i];
	}
?>
<p>
	<?php _e('Put Upto 10 Keywords for search seperated with commas (,)')?>
</p>
<table class="form-table" style="clear:left;">
	<tbody>
		<tr>
			<th scope="row"><label for="scan-keywords-file-pattern-1"><?php _e('Keywords Scan'); ?></label></th>
			<td valign="top">
				<input value="<?=$keyWords?>" type="text" class="regular-text" <?php if($settingsChecked=='0') echo "disabled"?> name="scanKeywords" id="scanKeywords" onkeypress="checkCommas(this.value)" />
			</td>
			<!--<td>
				<input value="<?=$settingsChecked?>" <?php if($settingsChecked=='1') echo "checked"?>  type="checkbox" name="checkKeywords" id="checkKeywords"  onclick="keywordOnOff()" /> <div id="status"><?php if($settingsChecked=='1') { echo "Disable"; } else { echo "Enable"; } ?></div>
			</td>-->
			<td>
				<input value="<?=$settingsChecked?>" <?php if($settingsChecked=='1') echo "checked"?>  type="checkbox" name="checkKeywords" id="checkKeywords" onclick="keywordOnOff()" /> Enable/Disable
			</td>
		</tr>
	</tbody>
</table>