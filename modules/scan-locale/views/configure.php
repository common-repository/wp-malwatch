<?php $settings = $this->getSettingslocale(); 

?>
<table class="form-table" style="clear:left;">
	<tbody>
		<tr>
			<th scope="row"><label for="scan-locale-file-pattern-1"><?php _e('Locale File'); ?></label></th>
			<td>
				<input value="<?=$settings?>" <?php if($settings=='1') echo "checked"?> onclick="onoff()" type="checkbox" name="localeFile" id="localeFile" /> Enable / Disable
			</td>
		</tr>
	</tbody>
</table>