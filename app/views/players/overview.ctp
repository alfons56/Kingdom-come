<h2>Overzichtje</h2>

<?php 
//debug('Kosten oplossen!!');
echo $player['Player']['name'], '<br /><br />Steden:<br />';
echo '<ul>';
foreach ($player['City'] as $city) {
	$curIndi = ($city['id'] == $currentPlayer['CurrentCity']['id']) ? ' <--' : '';
	echo '<li>',
		$ajax->link(
			$city['name'],
			array( 'controller' => 'cities', 'action' => 'select'),
    	array('update' => 'page_content', 'with' => "'data[select_city] = " . $city['id'] . "'")
		),
		$curIndi, '</li>'
	;
	if (!empty($city['BuildingsCity'])) {
		echo '<li><ul>';
		foreach ($city['BuildingsCity'] as $building) {
			echo '<li>', 
				$ajax->link(
					$building['Building']['name'],
					array('controller' => 'buildings_cities', 'action' => 'view/' . $building['id']),
					array('update' => 'page_content')
				),
				//'<pre>' . print_r($building, true) . '</pre>',
				'</li>',
				'<li><ul>';
				foreach ($building['Resource'] as $resource) {
					echo '<li>' . $resource['BuildingsCitiesResource']['type'] . ': ' . $resource['name'] . ': ' . $resource['BuildingsCitiesResource']['amount'] . '</li>';
				}
				echo
					'</ul></li>';
		}
		echo '</ul></li>';
	}
}
echo '</ul>';
//debug($currentPlayer);
?>