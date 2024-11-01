<?php 

?>
<ul>
	<li>
		<form method="post">
			<p class="submit"><input type="submit" name="wpmw-scan" id="wpmw-scan-doer" value="<?php _e( 'Scan Now' ); ?>" /><?php wp_nonce_field('wpmw-scan'); ?></p>
			<!-- wp-malwatch -->
			<input type="hidden" name="scanvalues" id="scanvalues" value="" />
			
			<script type="text/javascript"> <!-- 
			function onoff(arg) {
				var str = new Array(3);
				if(document.getElementById('hiddenFile').checked==true) {
					str[0] = 'hf';
				}
				if(document.getElementById('htaccessfile').checked==true) {
					str[1] = 'ht';
				}
				if(document.getElementById('uploadDir').checked==true) {
					str[2] = 'ud';
				}
				if(document.getElementById('localeFile').checked==true) {
					str[3] = 'lf';
				}
				if(document.getElementById('checkKeywords').checked==true) {
					str[4] = 'ck';
				}
				document.getElementById('scanvalues').value = str.join(',');
			}
			
			function keywordOnOff() {
				if(document.getElementById('checkKeywords').checked == false) {
					document.getElementById('scanKeywords').disabled = true;
					document.getElementById('status').innerHTML = 'Enable';
				} else {
					document.getElementById('scanKeywords').disabled = false;
					document.getElementById('scanKeywords').focus();
					document.getElementById('status').innerHTML = 'Disable';
				}
			}
			
			function checkCommas(checkedCommas) {
				var count;
				count = checkedCommas.split(",");
				if(count.length >= 11) {
					alert("You Cannot Put More Than 10 Keywords");
					document.getElementById('scanKeywords').value="";
				}
			}
			--> </script>
			<!-- wp-malwatch -->
		</form>
	</li>
	<li><a target="_blank" href="http://how-to-blog.tv/security/wp-malwatch/"><?php _e( 'Plugin Home Page' ); ?></a></li>
	<li><a target="_blank" href="http://how-to-blog.tv/security/wp-malwatch/disclaimer/"><?php _e( 'Disclaimer' ); ?></a></li>
	<li><a href="mailto:malwatchbug@how-to-blog.tv"><?php _e( 'Report a Bug' ); ?></a></li>
	<li><a target="ej_ejc" class="ec_ejc_thkbx" onclick="javascript:return EJEJC_lc(this);" href="https://www.e-junkie.com/ecom/gb.php?c=cart&amp;i=593936&amp;cl=86678&amp;ejc=2"><?php _e( 'Donate' ); ?></a></li>
</ul>