<?php
class BuildingsCitiesResource extends AppModel {
	public $name = 'BuildingsCitiesResource';
	public $belongsTo = array('BuildingsCity', 'Resource');
}
?>