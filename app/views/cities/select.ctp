<?php
//debug($currentPlayer);
echo 
	$javascript->codeBlock(
		$ajax->remoteFunction(
			array(
	    	'url' => array( 'controller' => 'players', 'action' => 'overview'),
	    	'update' => 'page_content',
			)
		)
	);
?>