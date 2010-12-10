<?php
class GameHelper extends AppHelper {
/**
 * Converts a string representing the format for the function strftime and returns a
 * windows safe and i18n aware format.
 *
 * @param string $format Format with specifiers for strftime function. 
 *    Accepts the special specifier %S which mimics th modifier S for date()
 * @param string UNIX timestamp
 * @return string windows safe and date() function compatible format for strftime
 * @access public
 */
	function timeLeft($time) {
		if (!is_numeric($time)) {
			$time = strtotime($time);
		}
		$time = $time - time();
		if ($time < 0) {
			return 'Done.';
		}
		$output = array();
		$days = floor($time / 86400);
		if ($days > 0) {
			$output[] .= "$days D";
			$time = $time - ($days * 86400);
		}
		$hours = floor($time / 3600);
		if ($hours > 0) {
			$output[] .= "$hours H";
			$time = $time - ($hours * 3600);
		}
		$minutes = floor($time / 60);
		if ($minutes > 0) {
			$output[] .= "$minutes M";
			$time = $time - ($minutes * 60);
		}
		if ($time > 0) {
			$output[] .= "$time S";
		}
		if (empty($output)) {
			$output[] = 'done';
		}
		return implode(', ', $output);
	}
}