<?php
echo "<h1>$result</h1><br /><br />";
echo
	$form->create('City', array('action' => 'add')),
	$form->input('City.player_id', array('type'=>'hidden', 'value' => 1)),
	$form->input('City.name'),
	$form->end('Add city');
?>