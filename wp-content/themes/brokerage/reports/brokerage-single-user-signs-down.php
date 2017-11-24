<?php
/*
Report Signs Down for single User
 *
*/

$sortableTable = generateTable(
	'DOWN',
	array(
		'author' => $_GET['user_id']
	)
);

echo $sortableTable;

?>
