<?php
$settings = $this->getSettings();
$results = $this->wpmw->getScanResultsForModule($this);
$files = $results['matches'];
?>
<div class="wpmw-section-description">
	<h4><?php _e('Configurable File Scan'); ?> </h4>
	
</div>
<?php if($results['count'] > 0) { ?>
<p><?php printf('There were %s found matching your configured patterns.  Please check the <a href="%s">detailed report</a> for more information.', sprintf(_n('%d file', '%d files', $results['count']), $results['count']), admin_url('admin.php?page=wp-malwatch-detailed')) ?></p>
<?php } else { ?>
<p><?php _e('There were no files found matching any of your configured file patterns.'); ?></p>
<?php } ?>
