<?php
$results = $this->wpmw->getScanResultsForModule($this);
$directories = $results['directories'];
$count = $results['count'];
$hasDirectories = !empty($directories);
global $is_IIS;
$server = $is_IIS ? __('IIS') : __('Apache');
$expected = $is_IIS ? 0 : 1;
?>
<div class="wpmw-section-description">
	<h4><?php _e( 'htaccess Scan' ); ?> </h4>

</div>
<p>
	<?php
	if($count>$expected) {
		$color = 'red';
	} else {
		$color = 'green';
	}
	printf(
	__('<span style="color:%s;">%d</span> <code>.htaccess</code> files found.'), $color, $count
	);
	printf(
	__(' <a href="%s">See Detailed Report.</a>'), admin_url('admin.php?page=wp-malwatch-detailed')
	);
	?>
</p>
