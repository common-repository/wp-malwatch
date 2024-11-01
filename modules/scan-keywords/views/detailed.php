<?php
$keyCheck = get_option('WPMW Scan Check Settings');
if($keyCheck == 0)
	return false;

?>
<div class="wpmw-section-description">
	<h3><?php esc_html_e($this->name()); ?> <a href="#"><?php _e('Learn More'); ?></a></h3>
	<div>
		<?php _e('MalWatch can search for up to 10 keywords in your theme files.  Hackers will drop hyperlinks into your theme files to funnel link juice to their sites based on specific anchor text.  This scan will help you look for specific keywords that are present in your theme files.  If a theme file is flagged, use the view functionality to examine the flagged theme file and determine where spam hyperlinks have been hidden in your theme.  For more information visit <a href="http://how-to-blog.tv/security/wp-malwatch/">How-To-Blog.TV</a>'); ?>
	</div>
</div>
<?php
$keyWordsString = get_option('WPMW Scan Keywords Settings');
$keyWordsCount = count($keyWordsString);
$rep1 = str_replace("/","\\\\",$this->_scan_Files);
$rep = str_replace("\\\\","/",$rep1);

$fileCount = count($rep);
for($ii=0;$ii<$fileCount;$ii++) {
	$lines = file($rep[$ii]);
	
	for($i = count($lines); $i>0; $i--){
	   if(isset($lines[$i])) {
	   		for($ij=0;$ij<$keyWordsCount;$ij++) {
				if(strpos($lines[$i], $keyWordsString[$ij])) {
				   $finalRep = str_replace("\\\\","/",$rep[$ii]);
				   $finalFiles[] = $finalRep;
				}
			}
		 }
	}
}
if(count($finalFiles) > 0) {
	foreach($finalFiles as $filename) {
		?>
		<div class="wpmw-file-contents">
			<h4><?php esc_html_e($filename); ?> <a href="#"><?php _e('Show Contents'); ?></a></h4>
			<pre><?php esc_html_e(file_get_contents($filename)); ?></pre>
		</div>
		<?php
	}
}
?>
<hr />