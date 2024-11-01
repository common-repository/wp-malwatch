<?php
$settings = $this->getSettings();
$hasWarning = !empty($settings['warnings']);
?>
<div class="wrap" id="wp-malwatch-wrap">
	<h2><?php _e('Summary Report'); ?></h2>
	<div id="wp-malwatch-scan-settings" class="updated">
		<p>
		<?php if(empty($settings['time'])) { ?>
			<?php _e( 'You have not performed a scan yet.  Click the "Scan Now" button to perform a scan.' ); ?>
		<?php } else { ?>
			<?php $time = $this->getLastScanTimeLocal(); ?>
			<?php printf( __( 'Your last scan was performed on %s at %s.' ), gmdate('M j, Y',$time), gmdate('g:i A',$time) ); ?>
		<?php } ?>
			<?php $class = $hasWarning ? 'wpmw-warning' : 'wpmw-all-clear'; ?>
			<span class="<?php echo $class; ?> alignright"></span>
		</p>
	</div>
	<div id="postbox" class="metabox-holder has-right-sidebar">
		<div class="inner-sidebar">
			<?php
			do_meta_boxes('wpmw','side','');
			?>
		</div>
		<div class="has-sidebar-content" id="post-body-content">
			<div class="meta-box-sortabless">
				<?php
				do_meta_boxes('wpmw','normal','');
				?>
			</div>
		</div>
	</div>
</div>
