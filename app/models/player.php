<?php
class Player extends AppModel {
	public $name = 'Player';
	public $hasMany = 'City';
	public $actsAs = array('Containable');
	
	function validateLogin($data) {
		$this->recursive = 3;
		$this->contain(array( 
			'City.BuildingsCity.Building.Resource', 'City.BuildingsCity.Resource'
		));
		$player = $this->find(array('name' => $data['name'], 'password' => md5($data['password'])));
		if (!empty($player)) {
			return $player;
		}
		return false;
	}
}
?>