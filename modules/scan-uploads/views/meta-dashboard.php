<?php
global $pagenow;
$dashboard = 'index.php' == $pagenow;
$results = $this->wpmw->getScanResultsForModule($this);
$directories = $results['directories'];
if( $dashboard ) {
	$directories = array_slice((array)$directories,0,5);
}
$files = $results['files'];
$hasDirectories = !empty($directories);
$hasFiles = !empty($files);
?>
<div class="wpmw-section-description">
	<h4><?php _e( 'Uploads Scan' ); ?> </h4>

</div>
<?php if( $hasDirectories ) { ?>
<p><?php _e( 'The following directories have items in them that you might want to examine.' ); ?></p>
<ul>
	<?php foreach($directories as $directory) { ?>
	<li><?php echo $directory; ?></li>
	<?php } ?>
	<?php if( $dashboard ) { ?>
	<li><a href="<?php echo admin_url('admin.php?page=wp-malwatch-detailed'); ?>"><?php _e( 'See Detailed Report.'); ?></a></li>
	<?php } ?>
</ul>
<?php } else { ?>
<p><?php _e('Your uploads directory has been scanned completely and is free of php files.'); ?></p>
<?php } ?>
