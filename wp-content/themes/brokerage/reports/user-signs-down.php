<?php
/*
Report Signs Down for single User
 *
*/

global $current_user;
get_currentuserinfo();

$sortableTable = generateTable(
	'DOWN',
	array(
		'author' => $current_user->ID
	)
);

echo $sortableTable;

?>

