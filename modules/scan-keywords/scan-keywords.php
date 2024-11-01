<?php
if( !class_exists( 'WPMW_ScanKeywords' ) ) {
	class WPMW_ScanKeywords extends WPMW_Module {
		/**
		 * @var WPMW
		 */
		var $wpmw;
		var $settings = null;
		var $results = array();
		var $excludeDirs = array();
		
		function WPMW_ScanKeywords($wpmw) {
			$this->wpmw = $wpmw;
			$this->addActions();
			$this->addFilters();
		}

		function name() {
			return __('Keywords Scanning');
		}

		function addActions() {
			add_action('admin_init',array(&$this,'addAdministrativeItems'));
		}

		function addFilters() { }

		/// CALLBACKS

		function buildExcludedDirectories() {
			$plugins = get_plugins();
			
			foreach($plugins as $file => $info) {
				if($info['Name'] == 'WordPress.com Stats') {
					$path = path_join(WP_PLUGIN_DIR,$file);
					$this->excludeDirs[] = dirname($path);
				}
			}
		}
		
		function addAdministrativeItems() {
			$optCheck = get_option('WPMW Scan Check Settings');
			if($optCheck == 1)
				$this->wpmw->addDashboardComponent(array(&$this,'displayWatchlistDashboard'));
		}

		function scan() {
			$keyCheck = get_option('WPMW Scan Check Settings');
			if($keyCheck == 0)
				return false;
				$this->buildExcludedDirectories();
				$base = rtrim(ABSPATH,'/');
				$this->scanRecursivelyForExtensions($base,array('php'));
				global $is_IIS;
				$server = $is_IIS ? __('IIS') : __('Apache');
				$expected = $is_IIS ? 0 : 1;
				if($this->count > $expected) {
					//$this->wpmw->addWarning(sprintf(__('You are running WordPress on %s and this server should have at most %d .php file.  There were more than that found.  See the full scan report for details.'), $server, $expected));
				}
				return array('scanKeywords'=>$this->_scan_Directories,'count'=>$this->count);
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
						if($file == 'index.php' || $file == 'header.php' || $file == 'footer.php' || $file == 'single.php') {
							$result = $this->scanRecursivelyForExtensions($resource . "/{$file}",$extensions);
							if( true === $result ) {
								$this->_scan_Files[] = "{$resource}/{$file}";
								$hasBad = true;
							}
						} else {
							$result = $this->scanRecursivelyForExtensions($resource . "/{$file}",$extensions);
						}
					}
					//exit;
					if( $hasBad ) {
						$this->_scan_Directories[] = "{$resource}/";
					}
					return false;
				}
			
		}

		/// DISPLAY

		function getDetailedReportHTML() {
			ob_start();
			include('views/detailed.php');
			return ob_get_clean();
		}

		function displayWatchlistDashboard() {
			include('views/meta-dashboard.php');
		}

		function configurationForm() {
			include('views/configure.php');
		}

		function handleConfiguration() {
			$dataScan = stripslashes_deep($_POST['scanKeywords']);
			$dataCheck = stripslashes_deep($_POST['checkKeywords']);
			$data = explode(",",$dataScan);
			$this->saveSettingsCheck($data,$dataCheck);
			$this->saveSettings($data,$dataCheck);
		}

		function saveSettings($settings,$dataChecked) {
			if($dataChecked == 1) {
				if(is_array($settings)) {
					$this->settings = $settings;
					update_option('WPMW Scan Keywords Settings', $settings);
				}
			} else if($dataChecked == "" && $settings[0] != "") {
				if(is_array($settings)) {
					$this->settings = $settings;
					update_option('WPMW Scan Keywords Settings', $settings);
				}
			}
		}
		
		function saveSettingsCheck($data,$settings) {
			if($settings == '' && $data[0] == "")
				$settings = 0;
			else
				$settings = 1;
			update_option('WPMW Scan Check Settings', $settings);
		}

		function getSettingsKeywords() {
			if(null === $this->settings) {
				$this->settings = get_option('WPMW Scan Keywords Settings');
			}
			return $this->settings;
		}
		
	}
}