<?php
if( !class_exists( 'WPMW_ScanUploads' ) ) {
	class WPMW_ScanUploads extends WPMW_Module {

		/**
		 * @var WPMW
		 */
		var $wpmw;
		var $_utility_Extensions = array('php','php5');

		var $_scan_Files = array();
		var $_scan_Directories = array();

		function __construct($wpmw) {
			$this->wpmw = $wpmw;
			$this->addActions();
			$this->addFilters();
		}

		function name() {
			return __('Uploads Directory Scanning');
		}

		function addActions() {
			add_action('admin_init',array(&$this,'addAdministrativeItems'));
		}

		function addFilters() { }

		/// CALLBACKS

		function addAdministrativeItems() {
			$optUploads = get_option('WPMW Scan Uploads Settings');
			if($optUploads == 1)
				$this->wpmw->addDashboardComponent(array(&$this,'displayWatchlist'));
		}

		function scan() {
			$uploads = wp_upload_dir();
			$base = $uploads['basedir'];
			$this->scanRecursivelyForExtensions($base,$this->_utility_Extensions);

			if( !empty( $this->_scan_Directories ) ) {
				$this->wpmw->addWarning(sprintf(__('Some directories in your uploads folder contain files with one of the following forbidden extensions: %s'), implode(', ',$this->_utility_Extensions)));
			}

			return array('files'=>$this->_scan_Files,'directories'=>$this->_scan_Directories);
		}

		function scanRecursivelyForExtensions($resource,$extensions = array('php')) {

			if( is_link( $resource ) ) {
				return false;
			} elseif( is_file( $resource ) ) {
				$extension = array_pop(explode('.',$resource));
				if( in_array($extension,$extensions) ) {
					$this->_scan_Files[] = $resource;
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
					$result = $this->scanRecursivelyForExtensions($resource . "/{$file}",$extensions);
					if( true === $result ) {
						$hasBad = true;
					}
				}

				if( $hasBad ) {
					$this->_scan_Directories[] = "{$resource}/";
				}
				return false;
			}
		}

		function getDetailedReportHTML() {
			ob_start();
			include('views/detailed.php');
			return ob_get_clean();
		}

		/// DISPLAY

		function displayWatchList() {
			include('views/meta-dashboard.php');
		}
		
		function configurationForm() {
			include('views/configure.php');
		}
		
		function handleConfiguration() {
			$data = stripslashes_deep($_POST['uploadDir']);
			$this->saveSettings($data);
		}
		
		function saveSettings($settings) {
			if(isset($_POST['uploadDir']) == true) $settings = 1; else $settings = 0;
			$this->settings = $settings;
			update_option('WPMW Scan Uploads Settings', $settings);
		}
		
		function getSettingsUploads() {
			if(null === $this->settings) {
				$this->settings = get_option('WPMW Scan Uploads Settings', array('uploadDir'=>array('1','1','1')));
			}
			return $this->settings;
		}
	}
}