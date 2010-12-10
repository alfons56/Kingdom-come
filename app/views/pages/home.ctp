<h1>Hoiiiiiiiii</h1>
<?php 
echo
	$form->create('Player', array('action' => 'login')),
	$form->input('name'),
	$form->input('password'),
	$form->submit('Login'),
	$form->end();
?>