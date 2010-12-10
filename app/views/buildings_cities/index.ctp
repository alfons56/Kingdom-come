<?php
if (isset($result)) {
	echo $result;
}
//debug($buildings_cities);
echo '<ul>';
foreach($buildings_cities as $key => $building) {
	$incoming = array();
	$outgoing = array();
	foreach ($building['Resource'] as $resource) {
		$update = floor(((time() - strtotime($resource['BuildingsCitiesResource']['update_time']))));
		if ($resource['BuildingsCitiesResource']['type'] == 'incoming') {
			$incoming[] = "{$resource['name']}: {$resource['BuildingsCitiesResource']['amount']}";
		} else {
			$outgoing[] = "{$resource['name']}: {$resource['BuildingsCitiesResource']['amount']}";
		}
	}
	$cost_arr = array();
	$can_build = true;
	foreach ($building['Building']['Resource'] as $key => $cost) {
		if ((!empty($currentPlayer['CurrentCity']['outgoing'][$key])) and ($currentPlayer['CurrentCity']['outgoing'][$key]['amount'] > $cost['cost'])) {
			$class = 'green_light';
		} else {
			$class = 'red_light';
			$can_build = false;
		}
		$cost_arr[] = '<span class="' . $class . '">' . $cost['name'] . ': ' . floor($cost['cost']) . '</span>';
	}
	$items = array();
	echo '<li>', 
		$html->div('resource_item',
			$html->image($building['Building']['thumbnail'], array('class' => 'bullet')) .
			$ajax->link(
				$building['Building']['name'] . ' lvl: ' . $building['BuildingsCity']['level'],
				array('controller' => 'buildings_cities', 'action' => 'view/' . $building['BuildingsCity']['id']),
				array('update' => 'page_content')
			)
		)
	;
	echo '</li>';
	if ($building['BuildingsCity']['upgrade_time'] > 0) {
		$items[] =
			$html->div('resource_item',
				$html->image('icons/bullet_add.png', array('class' => 'bullet')) .
				'Upgrading: ' . $game->timeLeft($building['BuildingsCity']['upgrade_time'])
			);
	} else {
		if ($can_build) {
			if ($building['queue_full']) {
				$items[] =
					$html->div('resource_item',
					$html->image('icons/bullet_delete.png', array('class' => 'bullet')) .
						__('Upgrade: ', true) .
					implode(', ', $cost_arr)
				);
			} else {
				$items[] =
					$html->div('resource_item',
					$html->image('icons/bullet_add.png', array('class' => 'bullet')) .
					$ajax->link(
						__('Upgrade: ', true),
						array('controller' => 'buildings_cities', 'action' => 'index', $building['BuildingsCity']['id']),
						array('update' => 'page_content')
					) .
					implode(', ', $cost_arr)
				);
			}
		} else {
			$items[] = $html->div('resource_item',
				$html->image('icons/bullet_delete.png', array('class' => 'bullet')) .
				__('Upgrade: ', true) . implode(', ', $cost_arr)
			);
		}
	}
	if (!empty($incoming)) {
		$items[] = $html->div('resource_item',
			$html->image('icons/bullet_go.png', array('class' => 'bullet')) .
			__('Voorraad: ', true) . implode(', ', $incoming)
		);
	}
	if (!empty($outgoing)) {
		$items[] = $html->div('resource_item',
			$html->image('icons/bullet_back.png', array('class' => 'bullet')) .
			__('Levert: ', true) . implode(', ', $outgoing)
		);
	}
	echo '<li><ul>';
	foreach ($items as $item) {
		echo '<li>' . $item . '</li>';
	}
	echo '</ul></li>';
}
echo '</ul>',
	'<br />',
	$html->div('menu_item',
		$ajax->link(
			__('Add building', true),
			array('controller' => 'buildings_cities', 'action' => 'add'),
			array('update' => 'page_content')
		)
	);
?>