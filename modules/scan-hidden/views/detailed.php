<div class="wpmw-section-description">
	<h3><?php esc_html_e($this->name()); ?> <a href="#"><?php _e('Learn More'); ?></a></h3>
	<div>
		<?php _e('Hidden files ARE NOT always bad but you do want to be aware of their existence on your blog.  If you have hidden files, use the view option in th detailed report to examine their contents.  If they point to websites using keywords that are obviously foul (e.g. "Viagra") then you might have an issue.  DO NOT delete a file just because it is hidden.  For more information visit <a href="http://how-to-blog.tv/security/wp-malwatch/">How-To-Blog.TV</a>'); ?>
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