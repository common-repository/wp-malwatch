<div class="wpmw-section-description">
	<h3><?php esc_html_e($this->name()); ?> <a href="#"><?php _e('Learn More'); ?></a></h3>
	<div>
		<?php _e('Most WordPress blogs will have 1 or more .HTACCESS files.  They are not necesarily bad but can be a tool a hacker uses to divert traffic from your blog.  Use the detailed view to examine them.  If they contain <a href="http://how-to-blog.tv/security/wp-malwatch/common-htaccess-directives-for-wordpress/">Common .HTACCESS Directives</a>, then you are fine.  If they redirect to sites related to cheap software and viagra, you might have a problem.'); ?>
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