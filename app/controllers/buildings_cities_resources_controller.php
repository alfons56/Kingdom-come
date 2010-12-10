<?php
class BuildingsCitiesResourcesController extends AppController {
	public $name = 'BuildingsCitiesResources';

	public function index() {
		$this->set('buildings_cities_resources', $this->BuildingsCitiesResource->find('all'));
	}

}
?>