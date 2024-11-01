<?php $settings = $this->getSettingshtaccess(); 
?>
<table class="form-table" style="clear:left;">
	<tbody>
		<tr>
			<th scope="row"><label for="scan-htaccess-file-pattern-1"><?php _e('Htaccess File'); ?></label></th>
			<td>
				<input name="htaccessfile" id="htaccessfile" type="checkbox" onclick="onoff()" value="<?=$settings?>" <?php if($settings=='1') echo "checked"?> /> Enable / Disable
			</td>
		</tr>
	</tbody>
</table>