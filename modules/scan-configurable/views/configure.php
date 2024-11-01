<?php $settings = $this->getSettings(); ?>
<p>
	<?php _e('Configure the file patterns you wish to scan for.  You can use the * character as a wildcard (as in *.jpg.php)'); ?>
</p>
<p>
	<?php _e('The only allowed characters here are A-Z, a-z, 0-9, . (period), - (hyphen), _ (underscore) and * (the wildcard).  This is for your system\'s safety.')?>
</p>
<table class="form-table" style="clear:left;">
	<tbody>
		<tr>
			<th scope="row"><label for="scan-configurable-file-pattern-1"><?php _e('File Pattern 1'); ?></label></th>
			<td>
				<input value="<?php esc_attr_e($settings['file-pattern'][0]); ?>" type="text" class="regular-text" name="scan-configurable[file-pattern][]" id="scan-configurable-file-pattern-1" />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="scan-configurable-file-pattern-2"><?php _e('File Pattern 2'); ?></label></th>
			<td>
				<input value="<?php esc_attr_e($settings['file-pattern'][1]); ?>" type="text" class="regular-text" name="scan-configurable[file-pattern][]" id="scan-configurable-file-pattern-1" />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="scan-configurable-file-pattern-3"><?php _e('File Pattern 3'); ?></label></th>
			<td>
				<input value="<?php esc_attr_e($settings['file-pattern'][2]); ?>" type="text" class="regular-text" name="scan-configurable[file-pattern][]" id="scan-configurable-file-pattern-1" />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="scan-configurable-file-pattern-4"><?php _e('File Pattern 4'); ?></label></th>
			<td>
				<input value="<?php esc_attr_e($settings['file-pattern'][3]); ?>" type="text" class="regular-text" name="scan-configurable[file-pattern][]" id="scan-configurable-file-pattern-1" />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="scan-configurable-file-pattern-5"><?php _e('File Pattern 5'); ?></label></th>
			<td>
				<input value="<?php esc_attr_e($settings['file-pattern'][4]); ?>" type="text" class="regular-text" name="scan-configurable[file-pattern][]" id="scan-configurable-file-pattern-1" />
			</td>
		</tr>
	</tbody>
</table>
<div>
	<p><?php _e('<code>*.bak.php</code>, <code>*.old.php</code>, and <code>*.cache.php</code> are the file patterns needed to detect the Phrama Hack.  Please see <a href="http://www.pearsonified.com/2010/04/wordpress-pharma-hack.php">Chris Pearson\'s Pharma Hack description</a> for more information.'); ?></p>
</div>