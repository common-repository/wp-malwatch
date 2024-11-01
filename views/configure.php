<?php
if($_GET['update'] == 'true') {
	?>
	<div id="wpmw-configure-message" class="updated fade">
	<p><strong><?php _e('Settings Saved.'); ?></strong></p>
	</div>
	<?php
}
?>
<div class="wrap" id="wp-malwatch-wrap">
		<h2><?php _e('Configure'); ?></h2>
		<div id="postbox" class="metabox-holder has-right-sidebar">
			<div class="inner-sidebar">
				<?php
				do_meta_boxes('wpmw','side','');
				?>
			</div>

			<form method="post">
				<div class="has-sidebar-content" id="post-body-content">
					<div class="meta-box-sortabless">
						<?php
						do_meta_boxes('wpmw-configure','normal','');
						?>
					</div>
				</div>
				<p class="submit">
					<?php wp_nonce_field('configure-wpmw'); ?>
					<input class="button-primary" type="submit" name="configure-wpmw" value="<?php _e('Save Configuration'); ?>" />
				</p>
			</form>
		</div>
</div>