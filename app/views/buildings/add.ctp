<?php
echo 
	"<h1>$result</h1><br /><br />",
	$form->create('Building'),
	$form->input('Building.name'),
	$ajax->submit('Add building', array('url'=> array('controller' => 'buildings', 'action'=>'add'), 'update' => 'page_content'));
	$form->end();
?>