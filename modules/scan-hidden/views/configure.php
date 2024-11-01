<?php $settings = $this->getSettingsHidden(); ?>
<table class="form-table" style="clear:left;">
	<tbody>
		<tr>
			<th scope="row"><label for="scan-hidden-file-pattern-1"><?php _e('Hidden File'); ?></label></th>
			<td>
				<input value="<?=$settings?>" <?php if($settings=='1') echo "checked"?> onclick="onoff()" type="checkbox" name="hiddenFile" id="hiddenFile" /> Enable / Disable
			</td>
		</tr>
	</tbody>
</table>