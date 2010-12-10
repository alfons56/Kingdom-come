<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @subpackage    cake.cake.libs.model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * This is a placeholder class.
 * Create the same file in app/app_model.php
 * Add your application-wide methods to the class, your models will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.model
 */
class AppModel extends Model {
	
	/**
	 * set_ids
	 *
	 * Takes find results and sets array keys to id if it is found
	 * 
	 *
	 */
	protected function set_ids($results) {
		//$return = array();
		if (is_array($results)) {
			foreach ($results as $key => $result) {
				if (is_numeric($key) and (!empty($result['id']))) {
					$return[$result['id']] = $this->set_ids($result);
				} else {
					$return[$key] = $this->set_ids($result);
				}
			}
		} else {
			$return = $results;
		}
		return $return;
	}
	
	public function find($conditions = null, $fields = array(), $order = null, $recursive = null) {
		$rows = parent::find($conditions, $fields, $order, $recursive);
		$rows = $this->set_ids($rows);
		//debug($rows);
		return $rows;
	}
}
?>