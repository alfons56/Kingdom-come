<?php
class BuildingsCity extends AppModel {
	public $name = 'BuildingsCity';
	public $belongsTo = array('Building', 'City');
	public $hasAndBelongsToMany = array('Resource' => array('order' => 'BuildingsCitiesResource.type'));
	public $actsAs = array('Containable');
	public $order = array('BuildingsCity.building_id' => 'asc');
	public $validate = array(
		'level' => array(
			'rule' => 'numeric',
			'required' => true,
			'message' => 'Numer invulle eikol.'
		)
	);
	
	public function do_level_up($player_id) {
		$this->contain('City', 'Building', 'Resource', 'Building.Resource');
		$buildings_cities = $this->find('all', array('conditions' => array('City.player_id' => $player_id), 'recursive' => 2));
		foreach ($buildings_cities as $building) {
			//debug($building);
			if (($building['BuildingsCity']['upgrade_time'] > 0) and (($building['BuildingsCity']['upgrade_time'] - time()) < 0)) {
				$data = array();
				$data['id'] = $building['BuildingsCity']['id'];
				$data['level'] = $building['BuildingsCity']['level'] + 1;
				$data['upgrade_time'] = 0;
				$this->save($data);
				$resources = $this->BuildingsCitiesResource->find('all', array(
					'conditions' => array(
						'buildings_city_id' => $building['BuildingsCity']['id']
					)
				));
				foreach ($resources as $resource) {
					$data = array();
					if (($building['Building']['type'] == 'gatherer') and ($resource['BuildingsCitiesResource']['type'] == 'outgoing')) {
						$this->BuildingsCitiesResource->id = $resource['BuildingsCitiesResource']['id'];
						$data['amount'] = $resource['BuildingsCitiesResource']['amount'] + (floor($building['Building']['amount_per_hour'] * (($building['BuildingsCity']['upgrade_time'] - strtotime($resource['BuildingsCitiesResource']['update_time'])) / 3600)));
						$data['update_time'] = date('c', $building['BuildingsCity']['upgrade_time']);
						$this->BuildingsCitiesResource->save($data);
					}
				}
			}
		}
	}
}

/*

insert into buildings_cities
	(buildings_city_id, resource_id, type, amount, update_time)
values
	(70, 1, 'outgoing', 0, now()),
	(71, 1, 'outgoing', 0, now());

 */

?>