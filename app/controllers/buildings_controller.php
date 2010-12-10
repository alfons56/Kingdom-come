<?php
class BuildingsController extends AppController {
	public $name = 'Buildings';
	
	public function index() {
		//$this->Building->contain(array('BuildingsPlayer.player_id' => $this->currentPlayer['Player']['id']));
		$this->Buildings->contain('City', 'Resource', 'BuildingsCity.Resource');
		$this->set('buildings', $this->Building->find('all'
		
		//, array('conditions' => array('BuildingsPlayer.player_id' => $this->currentPlayer['Player']['id']))
		
		));
		//$this->set('buildings', $this->currentPlayer['Building']);
	}
	
	public function add() {
		if (!empty($this->data)) {
			$this->set('data', $this->data);
			if ($this->Building->save($this->data)) {
				$result = 'Building added.';
			} else {
				$result = 'Building not added. erreur!';
			}
		} else {
			$result = 'Adding building.';
		}
		$this->set('result', $result);
	}
}
?>