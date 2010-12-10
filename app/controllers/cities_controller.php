<?php
class CitiesController extends AppController {
	public $name = 'Cities';
	
//	public function index() {
//		$this->set('cities', $this->City->find('all'));
//	}
	
	public function add() {
		if (!empty($this->data)) {
			if ($this->City->save($this->data)) {
				$result = 'City added.';
			} else {
				$result = 'City not added. erreur!';
			}
		} else {
			$result = 'Adding city.';
		}
		$this->set('result', $result);
	}
	
	public function select() {
		Configure::write('debug', 0);
		$this->setPlayer($this->data['select_city']);
//		if (!empty($this->data['select_city'])) {
//			foreach ($this->currentPlayer['City'] as $city) {
//				if ($city['id'] == $this->data['select_city']) {
//					$this->currentPlayer['CurrentCity'] = $city;
//					break;
//				}
//			}
//			$this->Session->write('currentPlayer', $this->currentPlayer);
//			$this->set('currentPlayer', $this->currentPlayer);
//		}
	}
}
?>