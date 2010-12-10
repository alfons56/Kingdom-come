<?php
class Building extends AppModel {
	public $name = 'Building';
	public $hasAndBelongsToMany = array('Resource');
//		'City' =>
//			array(
//				'unique' => false
//			),
//		
//	);
}
?>