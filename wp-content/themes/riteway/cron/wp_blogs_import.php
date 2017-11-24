<?php


//1.  This will add all the sites to the the wp_blogs table. 
//2.  Next run the table_create_import file.


$mysqli = new mysqli( "localhost", "root", "bluedevil" );
$domain = 'riteway.localhost:4567';
$database = 'riteway';

/* Create table doesn't return a resultset */
if ( $result = $mysqli->query( "SELECT * from oldrite.tblgroup" ) ) {
	while ( $row = $result->fetch_array() ) {
		$rows[] = $row;
	}

	//MUST SELECT DATABASE
	$mysqli->select_db( $database );

	foreach ( $rows as $row ) {

		$brokerage = $row['fldgroupname'];
		$row       = strtolower( $row['fldgroupname'] );
		$row       = str_replace( ' ', '-', $row );
		$row       = str_replace( '.', '-', $row );
		$row       = str_replace( ')', '-', $row );
		$row       = str_replace( '(', '-', $row );
		$row       = str_replace( '&', '-', $row );
		$row       = str_replace( '%', 'percent', $row );
		$row       = str_replace( '--', '-', $row );
		$row       = str_replace( '---', '-', $row );
		$row       = str_replace( '----', '-', $row );
		$row       = '/' . $row . '/';

		//Dupe check
		$exists = $mysqli->query( "SELECT blog_id from wp_blogs where path = '$row'" );

		if ( $exists->num_rows == 0 ) {
			echo '<br>';
			echo '<br>';
			echo $row . '---- DOES NOT EXIST INSERTING....';
			echo '<br>';
			echo '<br>';

			$insert = $mysqli->query( "INSERT INTO wp_blogs (site_id, domain, path, registered, last_updated, public) VALUES ('1', '$domain', '$row', '2015-01-27 12:01:10', '2015-01-27 12:03:10', 0)" );

		}

	}

}
