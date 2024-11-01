<?php
if( !class_exists( 'WPMW_ScanHtaccess' ) ) {
	class WPMW_ScanHtaccess extends WPMW_Module {

		/**
		 * @var WPMW
		 */
		var $wpmw;
		var $htAccessCount = 0;
		var $excludeDirs = array();

		var $_scan_Directories = array();
		var $_scan_Files = array();

		function __construct($wpmw) {
			$this->wpmw = $wpmw;
			$this->addActions();
			$this->addFilters();
		}

		function name() {
			return __('htaccess Scanning');
		}
		
		/*function value() {
			return __('htaccess');
		}*/

		function addActions() {
			add_action('admin_init',array(&$this,'addAdministrativeItems'));
		}

		function addFilters() { }

		function buildExcludedDirectories() {
			$plugins = get_plugins();
			foreach($plugins as $file => $info) {
				if($info['Name'] == 'WordPress.com Stats') {
					$path = path_join(WP_PLUGIN_DIR,$file);
					$this->excludeDirs[] = dirname($path);
				}
			}
		}

		/// CALLBACKS

		function addAdministrativeItems() {
			$opthtaccess = get_option('WPMW Scan htaccess Settings');
			if($opthtaccess == 1)
				$this->wpmw->addDashboardComponent(array(&$this,'displayWatchlistDashboard'));
		}

		function scan() {
				$this->buildExcludedDirectories();
				$base = rtrim(ABSPATH,'/');
				$this->scanRecursivelyForExtensions($base,array('htaccess'));
				global $is_IIS;
				$server = $is_IIS ? __('IIS') : __('Apache');
				$expected = $is_IIS ? 0 : 1;
				if($this->count > $expected) {
					$this->wpmw->addWarning(sprintf(__('You are running WordPress on %s and this server should have at most %d .htaccess file.  There were more than that found.  See the full scan report for details.'), $server, $expected));
				}
	
				return array('directories'=>$this->_scan_Directories,'count'=>$this->count);
		}

		function scanRecursivelyForExtensions($resource,$extensions = array('php')) {
			
				if( is_link( $resource ) ) {
					return false;
				} elseif( is_file( $resource ) ) {
					$extension = array_pop(explode('.',$resource));
					if( in_array($extension,$extensions) ) {
						$this->count++;
						return true;
					} else {
						return false;
					}
				} elseif( is_dir( $resource ) ) {
					if(in_array($resource,$this->excludeDirs)) {
						return false;
					}
					$handle = opendir($resource);
					$hasBad = false;
					while(false !== ($file = readdir($handle))) {
						if( '.' == $file || '..' == $file ) {
							continue;
						}
						$result = $this->scanRecursivelyForExtensions($resource . "/{$file}",$extensions);
						if( true === $result ) {
							$this->_scan_Files[] = "{$resource}/{$file}";
							$hasBad = true;
						}
					}
	
					if( $hasBad ) {
						$this->_scan_Directories[] = "{$resource}/";
					}
					return false;
				}
			
		}

		/// DISPLAY

		function displayWatchlistDashboard() {
			include('views/meta-dashboard.php');
		}

		function getDetailedReportHTML() {
			ob_start();
			include('views/detailed.php');
			return ob_get_clean();
		}
		
		function configurationForm() {
			include('views/configure.php');
		}
		
		function handleConfiguration() {
			$data = stripslashes_deep($_POST['htaccessfile']);
			$this->saveSettings($data);
		}
		
		function saveSettings($settings) {
			if(isset($_POST['htaccessfile']) == true) $settings = 1; else $settings = 0;
			$this->settings = $settings;
			update_option('WPMW Scan htaccess Settings', $settings);
		}
		
		function getSettingshtaccess() {
			if(null === $this->settings) {
				$this->settings = get_option('WPMW Scan htaccess Settings', array('htaccessfile'=>array('1','1','1')));
			}
			return $this->settings;
		}
	}
}