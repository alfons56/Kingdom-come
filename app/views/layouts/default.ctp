<?php
/**
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
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('CakePHP: the rapid development php framework:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		
		echo $this->Html->css('main');
		
		echo $javascript->link('prototype');
		
		echo $javascript->link('scriptaculous');

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<?php if (isset($currentPlayer['Player']['name'])) { ?>
				<h1>
					<?php  
					echo
						$ajax->link( 
							$currentPlayer['Player']['name'], 
							array('controller' => 'players', 'action' => 'overview'), 
							array('update' => 'page_content')
						)
					;
					?>
					<?php echo ' -> '; ?>
					
					
					<?php
					foreach ($currentPlayer['City'] as $city) {
						$options[$city['id']] = $city['name'];
					}
									
					echo
						$form->select('select_city', $options,
							$currentPlayer['CurrentCity']['id'], array('id' => 'select_city', 'empty' => false), false),
						$javascript->codeBlock(
							//"alert($('select_city').serialize());" .
							"$('select_city').observe('change', function(event) {" .
								$ajax->remoteFunction(
									array(
							    	'url' => array( 'controller' => 'cities', 'action' => 'select'),
							    	'update' => 'page_content',
										'with' => "$('select_city').serialize()"
									)
								) .
							"})"
						);
						echo ' ';
//						$total_incoming = array();
						$total_outgoing = array();
//						foreach($currentPlayer['CurrentCity']['incoming'] as $resource) {
//							$total_incoming[] = $resource['name'] . ': ' . floor($resource['amount']);
//						}
						foreach($currentPlayer['CurrentCity']['outgoing'] as $resource) {
							$total_outgoing[] = $resource['name'] . ': ' . $this->Number->format($resource['amount']);
						}
						echo '<span id="resource_box">' . implode(' | ', $total_outgoing) . '</span>';
					?>
					
				</h1>
			<?php } else { ?>
				<h1><?php echo $this->Html->link(__('CakePHP: the rapid development php framework', true), 'http://cakephp.org'); ?></h1>
			<?php } ?>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework', true), 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>