<?php
class PlayersController extends AppController {
	public $name = 'Players';

	public function overview() {
		$this->set('player', $this->Player->find('first', array('recursive' =>  3, 'conditions' => array('Player.id' => $this->currentPlayer['Player']['id']))));
		//debug($this->currentPlayer);
	}
	
	public function login() {
		if ($this->currentPlayer = $this->Player->validateLogin($this->data['Player'])) {
			$this->Session->destroy();
			$this->setPlayer();
			//$this->currentPlayer['CurrentCity'] = $this->currentPlayer['City']['0'];
			//$this->Game->calcResources($this->currentPlayer);
			//$this->Session->write('currentPlayer', $this->currentPlayer);
			$this->redirect(array('controller' => 'pages', 'action' => 'overview'));
		} else {
			if ($this->Session->check('currentPlayer')) {
				$this->Session->destroy();
			}
		}
	}

	public function logout() {
		if ($this->Session->check('currentPlayer')) {
			$this->Session->destroy();
		}
		$this->redirect('/');
	}
}
?>