<?php
echo
	"<h1>$result</h1><br />",
	$form->create('BuildingsCity'),
	$form->input('building_id'),
	$form->input('city_id'),
	$form->input('level'),
	$ajax->submit('Add building', array('url'=> array('controller' => 'buildings_cities', 'action'=>'add'), 'update' => 'page_content'));
	$form->end();
?>