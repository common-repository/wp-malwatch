<?php
if( !class_exists( 'WPMW_ScanHidden' ) ) {
	class WPMW_ScanHidden extends WPMW_Module {

		/**
		 * @var WPMW
		 */
		var $wpmw;

		var $_scan_Directories = array();
		var $_scan_Files = array();
		var $count = 0;

		function WPMW_ScanHidden($wpmw) {
			$this->wpmw = $wpmw;
			$this->addActions();
			$this->addFilters();
		}

		function name() {
			return __('Hidden File Scanning');
		}

		function addActions() {
			add_action('admin_init',array(&$this,'addAdministrativeItems'));
		}

		function addFilters() { }

		/// CALLBACKS

		function addAdministrativeItems() {
			$optHidden = get_option('WPMW Scan Hidden Settings');
			
			if($optHidden == 1)
				$this->wpmw->addDashboardComponent(array(&$this,'displayWatchlistDashboard'));
		}

		function scan() {
			$base = rtrim(ABSPATH,'/');
			$this->scanRecursivelyForHiddenFiles($base);
			return array('directories'=>$this->_scan_Directories,'files'=>$this->_scan_Files,'count'=>$this->count);
		}

		function scanRecursivelyForHiddenFiles($resource) {
			///if($this->value()=='Hidden') {
				if( is_link( $resource ) ) {
					return false;
				} elseif( is_file( $resource ) ) {
					$name = basename($resource);
					if( '.' == $name[0] && '.htaccess' != $name ) {
						$this->count++;
						return true;
					} else {
						return false;
					}
				} elseif( is_dir( $resource ) ) {
					$handle = opendir($resource);
					
					$hasBad = false;
					while(false !== ($file = readdir($handle))) {
						if( '.' == $file || '..' == $file ) {
							continue;
						}
						$result = $this->scanRecursivelyForHiddenFiles($resource . "/{$file}",$extensions);
						
						if( true === $result ) {
							$hasBad = true;
							$this->_scan_Files[] = "{$resource}/{$file}";
						}
					}
					if( $hasBad ) {
						$this->_scan_Directories[] = "{$resource}/";
					}
					return false;
				}
			//}
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
			$data = stripslashes_deep($_POST['hiddenFile']);
			$this->saveSettings($data);
		}
		
		function saveSettings($settings) {
			if(isset($_POST['hiddenFile']) == true) $settings = 1; else $settings = 0;
			$this->settings = $settings;
			update_option('WPMW Scan Hidden Settings', $settings);
		}
		
		function getSettingsHidden() {
			if(null === $this->settings) {
				$this->settings = get_option('WPMW Scan Hidden Settings', array('hiddenfile'=>array('1','1','1')));
			}
			return $this->settings;
		}
	}
}