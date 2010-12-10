<?php
//debug($building);
foreach ($building['Building']['Resource'] as $cost) {
	if ($building['BuildingsCity']['level'] == 0) {
		$price = $cost['BuildingsResource']['amount'];
	} else {
		$price = $cost['BuildingsResource']['amount'] * $building['Building']['cost_multiplier'] * ($building['BuildingsCity']['level']);
	}
	$cost_arr[] = $cost['name'] . ': ' . $price;
}
if (empty($cost_arr)) {
	throw new Exception('BuildingsResource not set!'); //forgot to add the buildingcost idiot!
}
echo
	$building['Building']['name'],
	'<ul><li>level: ' . $building['BuildingsCity']['level'] . '</li>',
	'<li>cost: ' . implode(' / ', $cost_arr) . '</li>';
if (!empty($building['Resource'])) {
	$incoming = '';
	$outgoing = '';
	foreach ($building['Resource'] as $resource) {
		if ($resource['BuildingsCitiesResource']['type'] == 'incoming') {
			$incoming .= '<li>' . $resource['name'] . ': ' . $resource['BuildingsCitiesResource']['amount'] . '</li>';
		} else {
			$outgoing .= '<li>' . $resource['name'] . ': ' . $resource['BuildingsCitiesResource']['amount'] . '</li>';
		}
	}
	echo ($incoming == '') ? '' : '<li>Vooraad</li><ul>' . $incoming . '</ul>';
	echo ($outgoing == '') ? '' : '<li>Levert</li><ul>' . $outgoing . '</ul>';
}



echo '<li>Upgrade</li></ul>';
?>