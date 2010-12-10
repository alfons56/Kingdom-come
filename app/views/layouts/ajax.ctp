<?php 
foreach($currentPlayer['CurrentCity']['outgoing'] as $resource) {
	$total_outgoing[] = $resource['name'] . ': ' . $this->Number->format($resource['amount']);
}
echo
	$this->Javascript->codeBlock("
		$('resource_box').innerHTML = '" . implode(' | ', $total_outgoing) . "';
	");
echo $content_for_layout;
if (Configure::read('debug') == 2) {
	echo $this->element('sql_dump');
}
?>