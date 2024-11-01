<div class="wpmw-section-description">
	<h3><?php esc_html_e($this->name()); ?> <a href="#"><?php _e('Learn More'); ?></a></h3>
	<div>
		<?php _e('The core WordPress installation includes a file called Locale.php.  This file contains the localization logic for International versions of WordPress.  Unfortunately, hackers like to drop redirects in this file due to its pervasive nature in WordPress.  They normally hide these redirects via encode64 variables.  WP-MalWatch looks for abnormal PHP calls in this file related to encode64 information.  If your Locale.php file is flagged, re-install WordPress via the upgrade function in the WordPress dashboard.'); ?>
	</div>
</div>
<?php
foreach($this->_scan_Files as $filename) {
	?>
	<div class="wpmw-file-contents">
		<h4><?php esc_html_e($filename); ?> <a href="#"><?php _e('Show Contents'); ?></a></h4>
		<pre><?php esc_html_e(file_get_contents($filename)); ?></pre>
	</div>
	<?php
}
?>
<hr />