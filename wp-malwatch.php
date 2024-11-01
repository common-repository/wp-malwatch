<?php
/*
 Plugin Name: WP-MalWatch
 Plugin URI: http://how-to-blog.tv/security/wp-malwatch/
 Description: Scan your WordPress system nightly and on demand with this quick and easy WordPress malware detector.
 Author: OrangeCast
 Version: 2.1.2
 Author URI: http://how-to-blog.tv/security/wp-malwatch/developer
*/

if( !class_exists( 'WPMW' ) ) {
	class WPMW_Module {

		function WPMW_Module($wpmw) { }
		function scan() { }

		function configurationForm() {
			include('views/default-module-configuration-form.php');
		}

		function handleConfiguration() {}

		function name() {
			return get_class($this);
		}

		function getDetailedReportHTML() {
			return '';
		}
	}

	class WPMW {

		var $_option_Name = '_WPMW_Main';
		var $_option_Scan = '_WPMW_Scan';

		var $settings = null;
		var $scanResults = null;

		var $_utility_ModulesPath;
		var $_utility_ModuleFiles = array();
		var $_utility_MetaBoxContext = 'wpmw';

		var $_utility_ModuleFilesLoaded = array();
		var $_utility_ModulesLoaded = array();

		var $_utility_Warnings = array();

		var $_utility_PluginUrl;
		var $_utility_HomeUrl = 'http://how-to-blog.tv/security/wp-malwatch/';
		var $_utility_FeedUrl = 'http://feeds.feedburner.com/how-to-blog-tv';


		function WPMW() {
			if($this->uploadDirIsDefault()) {
				$this->addActions();
				$this->addFilters();
				$this->loadModules();
				$this->_utility_PluginUrl = plugins_url('/',__FILE__);
				register_activation_hook(__FILE__, array($this, 'doScan'));
			} else {
				global $pagenow;
				if($pagenow == 'plugins.php' || false !== strpos($_GET['page'],'wp-malwatch-configure')) {
					add_action( 'admin_notices', array( &$this, 'addAdministrativeWarning' ) );
				}
			}
		}

		function addActions() {
			register_activation_hook(__FILE__, array(&$this, 'setWPCron'));
			register_deactivation_hook(__FILE__, array(&$this, 'removeWPCron'));

			add_action('admin_init', array(&$this, 'processSubmission'));
			add_action('admin_menu', array(&$this, 'addAdministrativeItems'));
			add_action('wpmw_do_scan', array(&$this, 'doScan'));
		}

		function addFilters() {

		}

		/// CALLBACKS

		function addAdministrativeWarning() {
			include('views/administrative-warning.php');
		}

		function addAdministrativeItems() {
			add_menu_page(__('WP-MalWatch'), __('WP-MalWatch'), 'manage_options', 'wp-malwatch-detailed', null, plugins_url('resources/img/favicon.ico',__FILE__));
			add_submenu_page('wp-malwatch-detailed',__('Detailed Report'),__('Detailed Report'),'manage_options', 'wp-malwatch-detailed', array(&$this,'displayDetailedReportPage'));
			add_submenu_page('wp-malwatch-detailed',__('Configure'),__('Configure'),'manage_options', 'wp-malwatch-configure', array(&$this,'displayConfigurationPage'));

			add_meta_box('wpmw-dashboard',__('WP-MalWatch'),array(&$this,'displayMetaDashboard'),'dashboard','normal','high');

			foreach($this->_utility_ModulesLoaded as $object) {
				add_meta_box('wpmw-configure-'.sanitize_title_with_dashes($object->name()), $object->name(), array($object, 'configurationForm'), 'wpmw-configure', 'normal');
			}

			$this->addMetaBox('about',__('About this Plugin'),array(&$this,'displayMetaAbout'),'side','high');
			$this->addMetaBox('security-resources',__('Security Resources'),array($this,'displayMetaSecurityResources'),'side','high');
			$this->addMetaBox('watch-list',__('Watch List'),array(&$this,'displayMetaWatchList'),'normal');

			wp_enqueue_style('wpmw',plugins_url('resources/wpmw.css',__FILE__),array());
			wp_enqueue_script('wpmw',plugins_url('resources/wpmw.js',__FILE__),array('jquery'));

			global $pagenow;
			if( 'admin.php' == $pagenow && $_GET['page'] == 'wp-malwatch-configure') {
				wp_enqueue_script('wpmw',plugins_url('resources/wpmw.js',__FILE__),array('jquery'));
				wp_enqueue_script('wpmw-ejunkie','http://www.e-junkie.com/ecom/box.js',array('wpmw'));
			}
		}

		function processSubmission() {
			if( isset( $_POST['wpmw-scan'] ) && check_admin_referer( 'wpmw-scan' ) ) {
				$this->doScan();
				wp_redirect(admin_url('admin.php?page=wp-malwatch-detailed'));
			} elseif( isset($_POST['configure-wpmw']) && check_admin_referer('configure-wpmw')) {
				foreach($this->_utility_ModulesLoaded as $object) {
					$object->handleConfiguration();
				}
				wp_redirect(admin_url('admin.php?page=wp-malwatch-configure&update=true'));
			}
		}

		function setWPCron() {
			$time = strtotime("Tomorrow 4AM");
			$offset = get_option('gmt_offset');
			wp_schedule_event($time + (intval($offset) * 3600), 'daily', 'wpmw_do_scan');
		}

		function removeWPCron() {
			wp_clear_scheduled_hook('wpmw_do_scan');
		}

		/// UTILITY

		function getDetailedReportHTML() {
			$indices = get_option('WPMW Detailed Report Indices', array());
			$output = '';
			foreach($indices as $index) {
				$output .= get_option('WPMW Detailed Report HTML - ' . $index);
			}
			return $output;
		}

		function setDetailedReportHTML($html) {
			// First, split the HTML into 900K chunks
			$index = 0;
			$indices = array();

			$split = 900000;
			$length = strlen($html);
			$strings = array();
			while($index < $length) {
				$part = substr($html,$index,$split);

				$indices[] = $index;
				update_option('WPMW Detailed Report HTML - ' . $index, $part);

				$strings[] = $part;

				$index += $split;
			}
			update_option('WPMW Detailed Report Indices', $indices);
		}

		function uploadDirIsDefault() {
			$info = wp_upload_dir();
			$default = WP_CONTENT_DIR . '/uploads/';
			return $default == trailingslashit( $info['basedir'] );
		}

		function loadModules() {
			$this->_utility_ModulesPath = path_join( dirname( __FILE__ ), 'modules/' );
			$handle = opendir($this->_utility_ModulesPath);
			if($handle) {
				while( false !== ($name = readdir($handle))) {
					$this->loadModule($name);
				}
			}
		}

		function loadModule($name) {
			if(in_array($name,array('.','..'))) {
				return false;
			}
			$optHidden = get_option('WPMW Scan Hidden Settings');
			$opthtaccess = get_option('WPMW Scan htaccess Settings');
			$optUploads = get_option('WPMW Scan Uploads Settings');
			$optLocale = get_option('WPMW Scan Locale Settings');
			$optCheck = get_option('WPMW Scan Check Settings');
			

			if(count($_POST) > 0 && isset($_POST['scanvalues'])) {
				list($hf, $ht, $ud, $lp, $ck) = explode(',', $_POST['scanvalues']);
				if($name=='scan-hidden' && $hf=='' && $optHidden == 0) return;
				if($name=='scan-htaccess' && $ht=='' && $opthtaccess == 0) return;
				if($name=='scan-uploads' && $ud=='' && $optUploads == 0) return;
				if($name=='scan-locale' && $lp=='' && $optLocale == 0) return;
				if($name=='scan-keywords' && $ck=='' && $optCheck == 0) return;
			} else if(count($_POST) > 0 && !isset($_POST['scanvalues']) && $_POST['wpmw-scan'] == 'Rescan'){ 
				if($name=='scan-hidden' && $optHidden == 0) return;
				if($name=='scan-htaccess' && $opthtaccess == 0) return;
				if($name=='scan-uploads' && $optUploads == 0) return;
				if($name=='scan-locale' && $optLocale == 0) return;
				if($name=='scan-keywords' && $optCheck == 0) return;
			}
			
			$file = $this->_utility_ModulesPath . $name . DIRECTORY_SEPARATOR . "{$name}.php";
			$class = $this->getModuleClassName($name);
			if( file_exists( $file ) ) {
				require_once($file);
				if( class_exists( $class ) ) {
					$this->_utility_ModuleFilesLoaded[] = $file;
					$object = new $class($this);
					$this->_utility_ModulesLoaded[] = $object;
				}
			}
		}

		function doScan() {
			$time = current_time('timestamp',true);
			$modules = array();
			$detailHTML = '';
			foreach($this->_utility_ModulesLoaded as $module) {
				$modules[] = get_class($module);
				
				$this->saveScanResultsForModule($module,$module->scan());
				$detailHTML .= $module->getDetailedReportHTML();
				
			}
			$settings = array(
				'time' => $time,
				'modules_used' => $modules,
				'warnings' => $this->_utility_Warnings
			);
			$this->saveSettings($settings);
			$this->setDetailedReportHTML($detailHTML);
		}

		function getScanResults() {
			if( null === $this->scanResults ) {
				$this->scanResults = get_option($this->_option_Scan, array() );
			}
			if( !is_array( $this->scanResults ) ) {
				$this->scanResults = array();
			}
			return $this->scanResults;
		}

		function getScanResultsForModule($module) {
			$results = $this->getScanResults();
			$key = strtolower(get_class($module));
			return is_array($results[$key]) ? $results[$key] : array();
		}

		function saveScanResults($results) {
			if( is_array( $results ) ) {
				$this->scanResults = $results;
				update_option($this->_option_Scan,$results);
			}
		}

		function saveScanResultsForModule($module, $results) {
			$scan = $this->getScanResults();
			$scan[strtolower(get_class($module))] = $results;
			$this->saveScanResults($scan);
		}

		function addMetaBox($id,$title,$callback,$context = 'normal',$priority = 'normal') {
			add_meta_box("wpmw-{$id}",$title,$callback,'wpmw',$context,'high');
		}

		function addDashboardComponent($callback) {
			if( is_callable( $callback ) ) {
				add_action('wpmw_dashboard',$callback);
			}
		}

		function addWatchListComponent($callback) {
			if( is_callable( $callback ) ) {
				add_action('wpmw_watchlist',$callback);
			}
		}

		function getModuleClassName($name) {
			$formatted = strtoupper(get_class($this)) . '_' . str_replace(' ', '', ucwords(str_replace('-',' ', $name)));
			return $formatted;
		}

		function getSettings() {
			if( null === $this->settings ) {
				$this->settings = get_option($this->_option_Name,array());
			}
			if( !is_array($this->settings) ) {
				$this->settings = array();
			}
			return $this->settings;
		}

		function saveSettings($settings) {
			if( is_array($settings ) ) {
				$this->settings = $settings;
				update_option($this->_option_Name, $settings);
			}
		}

		function addWarning($message) {
			if( !is_array( $this->_utility_Warnings ) ) {
				$this->_utility_Warnings = array();
			}
			$this->_utility_Warnings[] = $message;
		}

		function getFeedItems($number = 5) {
			$feed = fetch_feed($this->_utility_FeedUrl);
			if( is_wp_error( $feed ) ) {
				return array();
			} else {
				return $feed->get_items(0,$number);
			}
		}

		function getLastScanTimeLocal() {
			$settings = $this->getSettings();
			$time = $settings['time'];
			return $time + (get_option('gmt_offset')*3600);
		}

		/// DISPLAY


		function displayAdministrativePage() {
			include('views/settings.php');
		}

		function displayDetailedReportPage() {
			include('views/detailed-report.php');
		}

		function displayConfigurationPage() {
			include('views/configure.php');
		}

		function displayMetaAbout() {
			include('views/meta-about.php');
		}

		function displayMetaDashboard() {
			include('views/meta-dashboard.php');
		}

		function displayMetaSecurityResources() {
			include('views/meta-security.php');
		}

		function displayMetaWatchList() {
			include('views/meta-watchlist.php');
		}
	}

	global $WPMW;
	$WPMW = new WPMW;
	include('lib/utility.php');
}