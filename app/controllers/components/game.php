<?php
class GameComponent extends Object {
	
	function initialize(&$controller, $settings) {
		//echo 'yup';
	}
	
	/**
	 * 
	 * Return Current ammount of resources in an array.
	 *
	 * @param $buildings reference to buildings_city record
	 * @param $options Array of options:
	 * 	building_queue_size: size of the guess what queue
	 * @param $update updates session and database if true, else only session, defaults to false
	 * @return i'll think of something
	 * @access public
	 */
	
	public function calcBuildingResources(&$buildings, $options = array(), $update = false) {
		$incoming = array();
		$outgoing = array();
		$upgrading_buildings = 0;
		$building_queue_size = (isset($options['building_queue_size'])) ? $options['building_queue_size'] : 1;
		foreach ($buildings as &$building) {
			if ($building['BuildingsCity']['upgrade_time'] > 0) {
				$upgrading_buildings += 1;
			}
			foreach ($building['Resource'] as $resource_key => &$resource) {
				$amount = 0;
				if ($building['Building']['type'] == 'gatherer') {
					if ($building['Building']['amount_per_hour'] > 0) {
						$amount = $building['Building']['amount_per_hour'] * ((time() - strtotime($resource['BuildingsCitiesResource']['update_time'])) / 3600);
						if (empty($resource['BuildingsCitiesResource']['orig_amount'])) {
							$resource['BuildingsCitiesResource']['orig_amount'] = $resource['BuildingsCitiesResource']['amount'];
						}
						$resource['BuildingsCitiesResource']['amount'] += floor($amount);
					}
				}
			}
		}
		foreach ($buildings as $building_key => &$building) {
			$building['queue_full'] = $upgrading_buildings >= $building_queue_size;
			foreach ($building['Building']['Resource'] as &$resource) {
				$resource['cost'] = $resource['BuildingsResource']['amount'] * (pow($building['Building']['cost_multiplier'], $building['BuildingsCity']['level']));
			}
		}
	}
	
	public function calcPlayerResources(&$player, $update = false) {
		$resources = '';
		$incoming = array();
		$outgoing = array();
		$storage = array();
		foreach ($player['CurrentCity']['BuildingsCity'] as $building_key => &$building) {
			foreach ($building['Resource'] as $resource_key => &$resource) {
				$amount = 0;
				if ($building['Building']['type'] == 'gatherer') {
					if ($building['Building']['amount_per_hour'] > 0) {
						$amount = $building['Building']['amount_per_hour'] * ((time() - strtotime($resource['BuildingsCitiesResource']['update_time'])) / 3600);
					}
				}
				$var = &$$resource['BuildingsCitiesResource']['type'];
				if (empty($var[$resource['id']])) {
					$var[$resource['id']] = $resource['BuildingsCitiesResource'];
					$var[$resource['id']]['name'] = $resource['name'];
				}
				$var[$resource['id']]['amount'] += floor($amount);
			}
		}
		$player['CurrentCity']['incoming'] = $incoming;
		$player['CurrentCity']['outgoing'] = $outgoing;
	}
	
	/**
	 * 
	 * Check if a building can be upgraded
	 *
	 * @param $building reference to building record
	 * @return not mutch.
	 * @access public
	 */
	public function isUpgradable(&$building) {
		
	}
}
?>