<?php
$results = $this->wpmw->getScanResultsForModule($this);
?>
<div class="wpmw-section-description">
	<h4><?php _e( 'Hidden Files Scan' ); ?> </h4>

</div>
<?php if($results['count'] > 0) { ?>
<p><?php printf('There were %s found in your WordPress install.  Please check the <a href="%s">detailed report</a> for more information.', sprintf(_n('%d hidden file','%d hidden files ',$results['count']),$results['count']), admin_url('admin.php?page=wp-malwatch-detailed')) ?></p>
<?php } else { ?>
<p><?php _e('There were no hidden files found in your WordPress install.'); ?></p>
<?php } ?>