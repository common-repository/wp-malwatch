<?php $settings = $this->getSettingsUploads(); ?>
<table class="form-table" style="clear:left;">
	<tbody>
		<tr>
			<th scope="row"><label for="scan-uploads-directory-pattern-1"><?php _e('Uploads Directory'); ?></label></th>
			<td>
				<input value="<?=$settings?>" <?php if($settings=='1') echo "checked"?> onclick="onoff()" type="checkbox" name="uploadDir" id="uploadDir" /> Enable / Disable
			</td>
		</tr>
	</tbody>
</table>