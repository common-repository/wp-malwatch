<div class="wpmw-section-description">
	<h3><?php esc_html_e($this->name()); ?> <a href="#"><?php _e('Learn More'); ?></a></h3>
	<div>
		<?php _e('If you have files with .PHP extensions in your uploads directory, then this module will make a list of them.  In the opinion of the authors of this plugin, there is no reason for these files to exist and you should ask questions if files get listed here.'); ?>
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