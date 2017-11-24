<?php
/*
Report Signs Up for single User
 *
*/

$sortableTable = generateTable(
	'UP',
	array(
		'author' => $_GET['user_id']
	)
);

echo $sortableTable;

?>
