<?php
class City extends AppModel {
	public $name = 'City';
	public $hasMany = array('BuildingsCity');
	public $hasAndBelongsToMany = array('Resources');
	//public $hasAndBelongsToMany = array('Building' => array('order' => 'Building.id'));
	
	
	
	/*
	
	insert into cities_resources (city_id, resource_id, amount, update_time) 
	values 
		(1, 1, 0, now()),
		(1, 2, 0, now()),
		(1, 3, 0, now()),
		(1, 4, 0, now()),
		(1, 5, 0, now()),
		
		(2, 1, 0, now()),
		(2, 2, 0, now()),
		(2, 3, 0, now()),
		(2, 4, 0, now()),
		(2, 5, 0, now()),
		
		(3, 1, 0, now()),
		(3, 2, 0, now()),
		(3, 3, 0, now()),
		(3, 4, 0, now()),
		(3, 5, 0, now()),
		
		(4, 1, 0, now()),
		(4, 2, 0, now()),
		(4, 3, 0, now()),
		(4, 4, 0, now()),
		(4, 5, 0, now())
		

	 */
}
?>