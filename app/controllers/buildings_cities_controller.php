<?php
class BuildingsCitiesController extends AppController {
	public $name = 'BuildingsCities';
	
	public function index($building_city_id = 0) {
		if ($building_city_id > 0) {
			$this->upgrade($building_city_id);
		}
		$this->BuildingsCity->contain('Building', 'Resource', 'Building.Resource');
		$buildings_cities = $this->BuildingsCity->find('all', array(
			'conditions' => array(
				'BuildingsCity.city_id' => $this->currentPlayer['CurrentCity']['id']
			),
			'recursive' => 2
		));
		$this->Game->calcBuildingResources($buildings_cities, array('building_queue_size' => $this->currentPlayer['Player']['building_queue_size']));
		$this->set('buildings_cities', $buildings_cities);
	}
	
	public function view($id) {
		$this->BuildingsCity->contain('Building', 'Resource', 'Building.Resource');
		$this->set('building', $this->BuildingsCity->find('first', array(
			'conditions' => array('BuildingsCity.id' => $id),
			'recursive' => 2
		)));
	}
	
	private function upgrade($building_city_id) {
		$building_queue_size = $this->currentPlayer['Player']['building_queue_size'];
		$this->BuildingsCity->contain(array('Building.Resource'));
		$this->BuildingsCity->recursive = 2;
		$buildings = $this->BuildingsCity->find('all', array('conditions' => array('city_id' => $this->currentPlayer['CurrentCity']['id'])));
		$upgrading_buildings = $last_upgrade_time = 0; 
		foreach ($buildings as $building) {
			if ($building['BuildingsCity']['id'] == $building_city_id) {
				$this->data = $building;
			}
			if ($building['BuildingsCity']['upgrade_time'] > 0) {
				$upgrading_buildings += 1;
				if ($building['BuildingsCity']['upgrade_time'] > $last_upgrade_time) {
					$last_upgrade_time = $building['BuildingsCity']['upgrade_time'];
				}
			}
		}
		
		if ($upgrading_buildings >= $building_queue_size) {
			$this->set('result', 'Building queue is full!');
		} else {
			$negative_amounts = array();
			$positive_amounts = 0;
			$can_build = true;
			foreach ($this->data['Building']['Resource'] as $cost) {
				$price = floor($cost['BuildingsResource']['amount']) * pow($this->data['Building']['cost_multiplier'], $this->data['BuildingsCity']['level']);
				$in_store = floor($this->currentPlayer['CurrentCity']['outgoing'][$cost['id']]['amount']);
				if ($in_store < $price) {
					$negative_amounts[] = $cost['name'] . ': ' . (string)floor($price - $in_store);
				} else {
					$positive_amounts += floor($price);
				}
			}
			if (!empty($negative_amounts)) {
				$this->set('result', 'You are short: ' . implode(' / ', $negative_amounts));
				$can_build = false;
			}
			if ($can_build) {
				if ($last_upgrade_time == 0) {
					$last_upgrade_time = time();
				}
				$this->data['BuildingsCity']['upgrade_time'] = $last_upgrade_time + $positive_amounts;
				if ($this->BuildingsCity->save($this->data)) {
					$this->set('result', 'Upgrading');
				} else {
					$this->set('result', 'Failure');
				}
			}
		}
	}
	
	private function add() {
		if (!empty($this->data)) {
			$this->set('data', $this->data);
			$this->BuildingsCity->create();
			if ($this->BuildingsCity->save($this->data)) {
				$result = 'Building added.';
			} else {
				$result = 'Building not added. erreur!';
			}
		} else {
			$result = 'Adding building.';
		}
		$this->set('result', $result);
		$this->set('cities', $this->BuildingsCity->City->find('list', array(
			'fields'=>array('id','name')
		)));
		$this->set('buildings', $this->BuildingsCity->Building->find('list', array(
			'fields'=>array('id','name')
		)));
	}
}
?>