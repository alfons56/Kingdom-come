<?php
class CitiesResource extends AppModel {
	public $name = 'CitiesResource';
	public $belongsTo = array('City', 'Resource');
//		'City' =>
//			array(
//				'unique' => false
//			),
//		
//	);
}
?>