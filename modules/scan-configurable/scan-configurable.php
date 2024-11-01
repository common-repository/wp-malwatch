<?php
if( !class_exists( 'WPMW_ScanConfigurable' ) ) {
	class WPMW_ScanConfigurable extends WPMW_Module {

		/**
		 * @var WPMW
		 */
		var $wpmw;
		var $settings = null;

		var $results = array();

		function WPMW_ScanConfigurable($wpmw) {
			$this->wpmw = $wpmw;
			$this->addActions();
			$this->addFilters();
		}

		function name() {
			return __('Configurable File Scanning');
		}

		function addActions() {
			add_action('admin_init',array(&$this,'addAdministrativeItems'));
		}

		function addFilters() { }

		/// CALLBACKS

		function addAdministrativeItems() {
			$this->wpmw->addDashboardComponent(array(&$this,'displayWatchlistDashboard'));
		}

		function scan() {
			$settings = $this->getSettings();
			$results = array();
			$count = 0;
			foreach($settings['file-pattern'] as $pattern) {
				if(!empty($pattern)) {
					$matches = safe_glob(ABSPATH.$pattern, GLOB_RECURSE | GLOB_NODIR | GLOB_NODOTS);
					$count += count($matches);
					foreach($matches as $key => $match) {
						$matches[$key] =  ABSPATH . $match;
					}
					$results[$pattern] = $matches;
				}
			}

			$this->results = $results;
			return array('matches' => $results, 'count'=>$count);
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
			$data = stripslashes_deep($_POST['scan-configurable']);
			foreach($data['file-pattern'] as $key => $value) {
				$value = trim($value);
				if(empty($value)) {
					unset($data['file-pattern'][$key]);
				} else {
					$data['file-pattern'][$key] = preg_replace('/[^a-zA-Z0-9\.*\-_]/','',$value);
				}
			}
			$data['file-pattern'] = array_unique($data['file-pattern']);
			$this->saveSettings($data);
		}

		function saveSettings($settings) {
			if(is_array($settings)) {
				$this->settings = $settings;
				update_option('WPMW Scan Configurable Settings', $settings);
			}
		}

		function getSettings() {
			if(null === $this->settings) {
				$this->settings = get_option('WPMW Scan Configurable Settings', array('file-pattern'=>array('*.bak.php','*.old.php','*.cache.php')));
			}
			return $this->settings;
		}
	}
}