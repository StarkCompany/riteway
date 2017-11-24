<?php

// Step 3 export Customers table as csv and import using plugin
//Step 4

$mysqli = new mysqli( "localhost", "root", "bluedevil" );
$domain = 'riteway.localhost:4567';
$database = 'riteway';

if($result = $mysqli->query( "SELECT fldName, c.fldgroupid, g.fldgroupname from tblCustomer as c LEFT JOIN tblgroup as g ON c.fldgroupid = g.id")) {

	while ( $row = $result->fetch_assoc() ) {
		print_r($row);
	}

}


//MUST SELECT DATABASE
//$mysqli->select_db( $database );

//if($result = $mysqli->query( "SELECT * from wp_blogs WHERE blog_id != 1")) {