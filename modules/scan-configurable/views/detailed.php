<?php
$settings = $this->getSettings();
$patterns = $settings['file-pattern'];
?>
<div class="wpmw-section-description">
	<h3><?php esc_html_e($this->name()); ?> <a href="#"><?php _e('Learn More'); ?></a></h3>
	<div>
		<?php _e('MalWatch can search for up to 5 file patterns on your system.  The default settings are the file patterns associated with the Pharma attack.  Keep in mind that just because a file matches a pattern DOES NOT mean it is bad.  Use the detailed report view to examine the contents of the file.  For more information visit <a href="http://how-to-blog.tv/security/wp-malwatch/">How-To-Blog.TV</a>'); ?>
	</div>
</div>
<?php
foreach($patterns as $pattern) {
	if(empty($this->results[$pattern])) { continue; }
	?>
	<h4><?php esc_html_e($pattern); ?></h4>
	<?php
	foreach($this->results[$pattern] as $filename) {
		?>
		<div class="wpmw-file-contents">
			<h4><?php esc_html_e($filename); ?> <a href="#"><?php _e('Show Contents'); ?></a></h4>
			<pre><?php esc_html_e(file_get_contents($filename)); ?></pre>
		</div>
		<?php
	}
	?>
	<?php
}
?>
<hr />