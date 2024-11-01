<div class="wrap">
<?php 
	$optHidden = get_option('WPMW Scan Hidden Settings');
	$opthtaccess = get_option('WPMW Scan htaccess Settings');
	$optUploads = get_option('WPMW Scan Uploads Settings');
	$optLocale = get_option('WPMW Scan Locale Settings');
	$optCheck = get_option('WPMW Scan Check Settings');
?>
	<h2><?php _e('Detailed Report'); ?></h2>
<h3><?php _e('Active Modules:'); _e(' File Scanning, ');if($optHidden == 1) { _e('Hidden File Scanning, '); } if($opthtaccess == 1){ _e('Htaccess Scanning, '); } if($optUploads == 1) { _e('Uploads Scanning, ');} if($optLocale == 1) { _e('Locale Php Scanning, ');} if($optCheck == 1) { _e('Keywords Scanning');}?></h3>
	<?php echo $this->getDetailedReportHTML(); ?>
</div>