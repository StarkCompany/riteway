<?php


//Run Last -- This will add all the signs to the wp_$_posts table of the respective site.
//
//sudo ./mdbconvert.sh riteway.mdb oldrite
//
//  May 10th Dump
// [ID: 453057005 - 453101970] - Approx 6,400 signs.
// 
// First Dump -- [ID: 453057005 -  453103508] -- 2nd Dump -453105076 -- 3rd - 453106660 -- 4th - 453108196

$mysqli = new mysqli( "localhost", "root", "bluedevil" );
$domain = 'riteway.localhost:4567';
$database = 'riteway';


if ( $signresult = $mysqli->query( "SELECT tblSignDetail.fldLocation, tblSignDetail.fldStatus, 
	tblSignDetail.flddate, tblSignDetail.flddate2, tblSignDetail.fldComments, tblCustomer.fldFullName, tblSignDetail.ID from oldrite.tblSignDetail left join oldrite.tblCustomer 
	ON tblSignDetail.fldID = tblCustomer.fldId where flddate > '2014-01-01' and tblSignDetail.ID > '453108196' ORDER BY tblSignDetail.ID LIMIT 1500" ) ) {
	
	while ( $signrow = $signresult->fetch_array() ) {
		$signrows[] = $signrow;
	}

	//MUST SELECT DATABASE
	$mysqli->select_db( $database );

	$mappedUsers = array();

	foreach ( $signrows as $signrow ) {


		//Got our sign here, need to map user from oldrite to riteway on userlogin which is = to fullName.
		//print_r($signrow);
		//echo '<br>';
		//echo '<br>'; 

		//We can't attribute any signs to a user if there is no name.  For now forget them. 
		if($signrow['fldFullName'] != ''){

			//Get users from wordpress DB
			$userresult = $mysqli->query( "SELECT ID, user_login from wp_users where user_login='".$signrow['fldFullName']."'" );	
			while ( $userrow = $userresult->fetch_array() ) {
				$userrows[] = $userrow;
			}

				foreach ( $userrows as $userrow ) {

					$signrow['ID'] = $userrow['ID'];
					$signrow['user_login'] = $userrow['user_login'];

				}	

			//Get users meta from wordpress DB
			$usermetaresult = $mysqli->query( "SELECT user_id, meta_key, meta_value from wp_usermeta where user_id='".$signrow['ID']."'" );	

			while ( $usermetarow = $usermetaresult->fetch_array() ) {
				$usermetarows[] = $usermetarow;
			}

			//print_r($usermetarows);

			foreach ( $usermetarows as $usermetarow ) {
	 
				if($usermetarow['meta_key'] == 'primary_blog'){

							$signrow['blog_id'] = $usermetarow['meta_value'];
							$blog = $mysqli->query( "SELECT path from wp_blogs where blog_id='".$signrow['blog_id']."'" );	
							$blogpath = $blog->fetch_array();
							$signrow['path'] = $blogpath['path'];
							//echo '<br>';
							//echo '<br>'; 
				}	
			}
		}else{
			//Unset from Array if no name
			unset($signrow);
		}	
		//These are the signs mapped to the USER ID and USER_LOIGN in the wp_users table.
		//Next step insert this date into the wp_posts table in the correct 'site'
		$mappedUsers[] = $signrow;	

	}	

	foreach($mappedUsers as $key=>$value){
	    if(is_null($value) || $value == '')
	        unset($mappedUsers[$key]);
	}

}

	$create = '';
	//Set post ID for each sign import
	$id ='7000';
	foreach($mappedUsers as $sign){

		// Calgary time - Mountain Time
		$calgary = new DateTimeZone('America/Denver');
		$gmt = new DateTimeZone('GMT');

		$date = new DateTime($sign['flddate'], $calgary);

		// Change the timezone to GMT.
		$date->setTimezone($gmt);

		// Now print the date/time it would in the GMT timezone
		// as opposed to the default timezone it was created with.
		 $gmt_convert = $date->format('Y-m-d H:i:s');

		$slug      = strtolower( $sign['fldLocation'] );
		$slug       = str_replace( ' ', '-', $slug );

		if(empty($sign['blog_id'])){
			$sign['blog_id'] = '15';
		}

		//Remember to remove for final import
		//if($sign['blog_id'] < 25){

		$create .= "INSERT INTO `wp_".$sign['blog_id']."_posts` 
		(`ID`,`post_author`, `post_date`, `post_date_gmt`, `post_content`, 
			`post_title`, `post_excerpt`, `post_status`, `comment_status`, 
			`ping_status`, `post_password`, `post_name`, `to_ping`, 
			`pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, 
			`post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, 
			`comment_count`) 
		VALUES (
			'".$id."',
			'".$sign['ID']."', 
			'".$sign['flddate']."', 
			'".$gmt_convert."', 
			'".str_replace( "'", "\'", $sign['fldComments'])."', 
			'".str_replace( "'", "\'",$sign['fldLocation'])."', 
			'', 
			'publish', 
			'closed', 
			'closed', 
			'', 
			'".$sign['ID']."', 
			'', 
			'', 
			'2015-03-15', 
			'2015-03-15', 
			'', 
			'0', 
			'".$domain.$sign['path']."?post_type=signs&#038;p=645', 
			'0', 
			'signs', 
			'', 
			'0');";
		
		$originalDate = $sign['flddate'];
		$newDate = date("m/d/Y", strtotime($originalDate));


		$create .= "INSERT INTO `wp_".$sign['blog_id']."_postmeta` (`post_id`, `meta_key`, `meta_value`) 
		VALUES ('".$id."', 'install_date', '".$newDate."');";

		$create .= "INSERT INTO `wp_".$sign['blog_id']."_postmeta` (`post_id`, `meta_key`, `meta_value`) 
		VALUES ('".$id."', 'city', 'Imported');";

		$create .= "INSERT INTO `wp_".$sign['blog_id']."_postmeta` (`post_id`, `meta_key`, `meta_value`) 
		VALUES ('".$id."', 'quadrant', 'IM');";

		if($sign['fldStatus'] == '1'){
			$create .= "INSERT INTO `wp_".$sign['blog_id']."_postmeta` (`post_id`, `meta_key`, `meta_value`) 
			VALUES ('".$id."', 'sign_status', 'Sign Up');";	
		}else{
			$create .= "INSERT INTO `wp_".$sign['blog_id']."_postmeta` (`post_id`, `meta_key`, `meta_value`) 
			VALUES ('".$id."', 'sign_status', 'Sign Down');";
		}	
		

		$id++;

		$file = 'signs.sql';
			// Open the file to get existing content
		$current = file_get_contents($file);

			// Write the contents back to the file
		file_put_contents($file, $create);
		}

	//}



