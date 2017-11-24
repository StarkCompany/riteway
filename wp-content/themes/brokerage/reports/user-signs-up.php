<?php
/*
Report Signs Up for single User
 *
*/

global $current_user;
get_currentuserinfo();

$sortableTable = generateTable(
	'UP',
	array(
		'author' => $current_user->ID
	)
);

echo $sortableTable;

?>

