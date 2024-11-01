<?php
$settings = $this->getSettings();
$hasWarnings = !empty($settings['warnings']);
$class = $hasWarnings ? 'wpmw-warning' : 'wpmw-all-clear';
$title = $hasWarning ? __('MalWatch Findings') : __('Successful Scan');
?>
<h4 id="wpmw-dash-heading"><?php echo $title; ?> (<a href="<?php echo admin_url('admin.php?page=wp-malwatch-detailed'); ?>"><?php _e( 'see complete report' ); ?></a>)</h4>
<br class="clear"></br>
<div>
	<div id="wpmw-dashboard-learn">
		<img src="<?php echo $this->_utility_PluginUrl ?>resources/img/wp-malwatch.png" alt="WP-MalWatch" />
		<p>
			<a target="_blank" class="button" href="<?php echo $this->_utility_HomeUrl; ?>"><?php _e( 'Learn More' ); ?></a>
		</p>
		<form method="post">
			<p class="submit"><input type="submit" name="wpmw-scan" id="wpmw-scan-doer" value="<?php _e( 'Rescan' ); ?>" /><?php wp_nonce_field('wpmw-scan'); ?></p>
		</form>
	</div>
	<div id="wpmw-dashboard-info">
		<?php
		if(!$hasWarnings) {
		?>
		<p><?php
		printf( __( 'Your blog is clear of the signs of malware this version of
		<a href="http://how-to-blog.tv/security/wp-malwatch/">WP-MalWatch</a> is looking for.
		For now, check out the latest at How-To-Blog.TV:'  ) );
		?></p>
		<ul>
		<?php foreach($this->getFeedItems() as $item) { ?>
		<li><a target="_blank" href="<?php echo $item->get_link(); ?>"><?php echo $item->get_title(); ?></a></li>
		<?php } ?>
		</ul>
		<p></p>
		<?php
		}
		do_action('wpmw_dashboard');
		if($hasWarnings) { 
			?>
		<h4>Sponsored by How-To-Blog.TV</h4>
		<p><?php
		printf(__('From our latest posts:'));
		?></p>
		<ul>
		<?php foreach($this->getFeedItems(2) as $item) { ?>
		<li><a target="_blank" href="<?php echo $item->get_link(); ?>"><?php echo $item->get_title(); ?></a></li>
		<?php } ?>
		</ul>
		<p></p>
			<?php
		}
		?>
	</div>
	<br class="clear" />
</div>