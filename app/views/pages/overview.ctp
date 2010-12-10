<?php
echo
	$html->div('menu', 
		$html->div('menu_item',
			$ajax->link( 
				__('Overview', true), 
				array('controller' => 'players', 'action' => 'overview'), 
				array('update' => 'page_content')
			)
		) .
		$html->div('menu_item',
			$ajax->link( 
				__('Buildings', true), 
				array('controller' => 'buildings_cities', 'action' => 'index'), 
				array('update' => 'page_content')
			)
		) .
		'<br />' .
		$html->div('menu_item',
			$html->link( 
		    __('Logout', true), 
		    array('controller' => 'players', 'action' => 'logout')
			)
		),
		array('id' => 'menu')
	),
	$html->div('page_content', '', array('id' => 'page_content')),
	$javascript->codeBlock(	
		$ajax->remoteFunction( 
		    array( 
		    	'url' => array('controller' => 'players', 'action' => 'overview'), 
		    	'update' => 'page_content'
		    ) 
		)
	);
?>