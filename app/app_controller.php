<?php
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
class AppController extends Controller {
	public $helpers = array('Html','Form','Javascript','Ajax', 'Session', 'Number', 'Game');
	public $components = array('RequestHandler', 'Session', 'Game');
	public $currentPlayer = null;
	public $obStarted = false;

	function __construct() {
		parent::__construct();
		if (Configure::read('debug') > 0) {
			$this->scaffold = null;
			$this->obStarted = ob_start();
		}
	}

	function __destruct() {
		if ($this->obStarted) {
			$output = ob_get_clean();
			$output = tidy_repair_string($output, array('indent' => true, 'output-xhtml' => true), 'utf8');
			echo $output;
		}
	}

	public function setPlayer ($city_id = 0) {
		if ($city_id == 0) {
			foreach($this->currentPlayer['City'] as $city) {
				$city_id = $city['id'];
				break;
			}
		}
		$this->currentPlayer['CurrentCity'] = $this->currentPlayer['City'][$city_id];
		$this->Game->calcPlayerResources($this->currentPlayer);
		$this->Session->write('currentPlayer', $this->currentPlayer);
	}
	
	public function beforeFilter() {
		if (!$this->setMainVars()) {
			if (!in_array($this->here, array('/', '/players/login', '/players/logout'))) {
				$this->redirect('/');
			}
		}
	}

	public function setMainVars() {
		if ($this->currentPlayer = $this->Session->read('currentPlayer')) {
			$this->building_level_up();
			$this->Game->calcPlayerResources($this->currentPlayer);
			$this->set('currentPlayer', $this->currentPlayer);
			//debug($this->currentPlayer);
			return true;
		}
		return false;
	}
	
	protected function building_level_up() {
		$this->loadModel('BuildingsCity');
		$this->BuildingsCity->do_level_up($this->currentPlayer['Player']['id']);
	}

}
?>