<?php

// 4. Take resulting query and import. This should assign user levels, correct password and usersnames to the correct sites.
/*
 * Set User_id to the next increment value of the database before generating sql.
 */


$mysqli = new mysqli( "localhost", "root", "bluedevil" );
$domain = 'riteway.localhost:4567';
$database = 'riteway';
$user_id = '77';

$mysqli->select_db( 'oldrite' );

if($result = $mysqli->query( "SELECT fldName, fldpassword, fldEmail, fldadmin, c.fldgroupid, g.fldgroupname from tblCustomer as c LEFT JOIN tblgroup as g ON c.fldgroupid = g.id")) {

	while ( $row = $result->fetch_assoc() ) {
		$rows[] = $row;
	}

	$result->free();
	$mysqli->select_db( $database );


	foreach ($rows as $row){

		//The STR replace here needs to match the STR replace on the blog import or we will have orphans.
		$group       = strtolower( $row['fldgroupname'] );
		$group       = str_replace( ' ', '-', $group );
		$group       = str_replace( '.', '-', $group );
		$group      = str_replace( ')', '-', $group );
		$group       = str_replace( '(', '-', $group );
		$group       = str_replace( '&', '-', $group );
		$group       = str_replace( '%', 'percent', $group );
		$group       = str_replace( '--', '-', $group );
		$group       = str_replace( '---', '-', $group );
		$group       = str_replace( '----', '-', $group );
		$group 		 =  '/' . $group . '/';

		$row['path'] = $group;

		$blogsql = "SELECT blog_id from wp_blogs where path='".$group."'";

		if($blog_result = $mysqli->query( $blogsql )) {
			
			$blog_id = $blog_result->fetch_assoc();
			$row['blog_id'] = $blog_id['blog_id'];
		
		}

		if($row['path'] == '//'){
			$row['path'] = '/no-brokerage/';
			$row['blog_id'] = '19';
		}

		$create .= "
			INSERT INTO `wp_users`
			(`user_login`, `user_pass`, `user_nicename`, `user_email`,
			`user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`)
			VALUES 
			('".$row['fldName']."', MD5('".$row['fldpassword']."'), '".$row['fldName']."', '".$row['fldEmail']."',
			'', '".date('Y-m-d H:i:s')."', '', '0', '".$row['fldName']."');";

		$create .= "
			INSERT INTO wp_usermeta (user_id, meta_key, meta_value) 
			VALUES ('".$user_id."','first_name', '".$row['fldName']."');";

		$create .= "
			INSERT INTO wp_usermeta (user_id, meta_key, meta_value) 
			VALUES ('".$user_id."','primary_blog', '".$row['blog_id']."');";

		if($row['fldadmin'] == '1'){


			//a:2:{s:17:"crony_full_access";b:1;s:21:"aamrole_5410d7b003aa5";b:1;}
			$create .= "
				INSERT INTO wp_usermeta (user_id, meta_key, meta_value) 
				VALUES ('".$user_id."','wp_".$row['blog_id']."_capabilities', 'a:2:{s:17:\"crony_full_access\";b:1;s:21:\"aamrole_5410d7b003aa5\";b:1;}');";
			$create .= "
				INSERT INTO wp_usermeta (user_id, meta_key, meta_value) 
				VALUES ('".$user_id."','wp_".$user['blog_id']."_user_level', '1');";				

		}else{

			$create .= "
				INSERT INTO wp_usermeta (user_id, meta_key, meta_value) 
				VALUES ('".$user_id."','wp_".$row['blog_id']."_capabilities', 'a:1:{s:7:\"realtor\";b:1;}');";	
			$create .= "
				INSERT INTO wp_usermeta (user_id, meta_key, meta_value) 
				VALUES ('".$user_id."','wp_".$user['blog_id']."_user_level', '0');";	

		}	

		$create .= "
			INSERT INTO wp_usermeta (user_id, meta_key, meta_value) 
			VALUES ('".$user_id."','user_meta_user_status', 'active');";

		$user_id++;

	}
}
print_r($create);
