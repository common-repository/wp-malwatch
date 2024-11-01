<?php
$settings = $this->getSettings();
if(count($settings['warnings']) == 0) {
	?>
<p><?php printf( __( 'Your blog is clear of the signs of  malware this version of <a href="http://how-to-blog.tv/security/wp-malwatch/">WP-MalWatch</a> is looking for.  For now, check out the latest at How-To-Blog.TV:' ) ); ?></p>
<ul>
	<?php foreach($this->getFeedItems() as $item) { ?>
	<li><a target="_blank" href="<?php echo $item->get_link(); ?>"><?php echo $item->get_title(); ?></a></li>
	<?php } ?>
</ul>
	<?php
} else {
?>
<p><?php _e('There were some items detected that could be cause for concern.  Please see the following sections for more details and visit the <a target="_blank" href="http://how-to-blog.tv/security/">security section</a> of How-To-Blog.TV for detailed information on WordPress security.'); ?></p>
<?php
}
?>
<?php
if(count($settings['warnings']) > 0) {
	?>
<h4>How-To-Blog.TV</h4>
<p><?php
printf(__('After you\'re done checking out the issues listed below, read the latest post on How-To-Blog.TV:'));
?></p>
<ul>
<?php foreach($this->getFeedItems(1) as $item) { ?>
<li><a target="_blank" href="<?php echo $item->get_link(); ?>"><?php echo $item->get_title(); ?></a></li>
<?php } ?>
</ul>
<p></p>
	<?php
}
?>
<?php do_action( 'wpmw_watchlist' ); ?>