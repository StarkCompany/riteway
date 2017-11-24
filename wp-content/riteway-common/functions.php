<?php

require_once("Pagination/Pagination.class.php");

$SIGN_STATUS_SETUP = array(
	'UP' => array(
		'title' => 'Sign Up',
		'fields' => array(
			'post_id' => 'ID',
	        'realtor' => 'Realtor',
	        'address' => 'Address',
	        'city' => 'City',
	        'quadrant' => 'Quadrant', 
	        'install_date' => 'Install Date',
	        'renewal_date' => 'Renewal Date',
	        'charge_renewal' => 'Charge Renewal',
        	'comments' => 'Comments',
        	'accessories' => 'Accessories'
		)
	),

	'RENEWAL' => array(
		'title' => 'Sign Up',
		'fields' => array(
			'post_id' => 'ID',
	        'realtor' => 'Realtor',
	        'address' => 'Address',
	        'city' => 'City',
	        'quadrant' => 'Quadrant',
	        'install_date' => 'Install Date',
	        'renewal_date' => 'Renewal Date',
	        'charge_renewal' => 'Charge Renewal',	        
		)
	),

	'DOWN' => array(
		'title' => 'Sign Down',
		'fields' => array(
			'post_id' => 'ID',
	        'realtor' => 'Realtor',
	        'address' => 'Address',
	        'city' => 'City',
	        'quadrant' => 'Quadrant',
	        'post_modified' => 'Ordered Down',
	        'install_date' => 'Install Date',
	        'removal_date' => 'Removal Date',
        	'removal_instructions' => 'Removal Instructions',
        	'comments' => 'Comments',        	
        	'sign_down_reason' => 'Reason'
		)
	),

	'FIX' => array(
		'title' => 'Fix Sign',
		'fields' => array(
			'post_id' => 'ID',
	        'realtor' => 'Realtor',
	        'address' => 'Address',
	        'city' => 'City',
	        'quadrant' => 'Quadrant',
	        'install_date' => 'Install Date',
	        'renewal_date' => 'Renewal Date',
	        'special_instructions' => 'Instructions',
        	'comments' => 'Comments',	        
        	'accessories' => 'Accessories'
		)

	)
);

$SIGN_STATUS = array(
	'DOWN' => 'Sign Down',
	'UP' => 'Sign Up',
	'FIX' => 'Fix Sign'
);

$REQUEST_ACCOUNT_ENTRIES_ID = 2;
$CITY_QUADRANT_MAPPINGS = array(
	'Calgary' => array('NE', 'NW', 'SE', 'SW'),
	'Airdrie' => array('NE'),
	'Balzac' => array('NE'),
	'Bearspaw' => array('NW'),
	'Bragg Creek' => array('SW'),
	'Carseland' => array('NE'),
	'Chestermere' => array('NE'),
	'Cochrane' => array('NW'),
	'Conrich' => array('NE'),
	'Crossfield' => array('NE'),
	'Dalmead' => array('NE'),
	'Delacour' => array('NE'),
	'Dewinton' => array('SW'),
	'Elbow Valley' => array('SW'),
	'Heritage Pointe' => array('SW'),
	'High River' => array('SW'),
	'Aldersyde' => array('SW'),
	'Indus' => array('NE'),
	'Langdon' => array('NE'),
	'Lyalta' => array('NE'),
	'Millarville' => array('SW'),
	'Okotoks' => array('SW'),
	'Priddis' => array('SW'),
	'Springbank' => array('NW'),
	'Strathmore' => array('NE'),
	'Turner Valley' => array('SW'),
	'Black Diamond' => array('SW'),
	'Imported' => array('IM')
);

// Helpers

function buildFilteredQueryArgs(
	$status,
	$queryArgs = array(),
	$required = array(),
	$post_type = 'signs'
) {

	global $_GET;

	$queryArgs['post_type'] = $post_type;

	$filterBy = array(
		'quadrant',
		'city',
		'install_date',
		'removal_date',
	);
	$metaQuery = array();

	if (!empty($status)) {
		array_push($metaQuery, array(
			'key' => 'sign_status',
			'value' => $status
		));
	}

	foreach ($filterBy as $field) {

		if (!empty($_GET[$field]) && $_GET[$field] !== 'All') {

			array_push($metaQuery, array(
				'key' => $field,
				'value' => $_GET[$field]
			));
		}
	}

	//Show Fix Signs as still Signs Up.
	if($metaQuery[0]['value'] == 'Sign Up'){
			$metaQuery[0]['value'] = array('Sign Up', 'Fix Sign');
	}


	if (!empty($required)) {
		foreach ($required as $req) {
			array_push($metaQuery, array(
				'key' => $req,
				'compare' => 'EXISTS'
			));
		}
	}
	if (!empty($metaQuery)) {
		$queryArgs['meta_query'] = $metaQuery;
	}

	$queryArgs['posts_per_page'] = -1;

	return $queryArgs;

}

function get_riteway_active_realtors() {
	global $blog_id;
	$getUsersParams = array(
		'blog_id' => $blog_id,
		'orderby' => 'display_name',
		'role' => 'realtor',
		'meta_key' => 'user_meta_user_status',
		'meta_value' => 'active'
	);
	return get_users($getUsersParams);
}

function get_riteway_realtor_full_name() {
	$realtor_fname = get_the_author_meta('first_name');
	$realtor_lname = get_the_author_meta('last_name');
	if (empty($realtor_fname) || empty($realtor_lname)) {
		return get_the_author_meta('display_name');
	}
	return $realtor_fname . ' ' . $realtor_lname;
}

// Filters
function populate_deleted_username() {
	$user = get_user_by('id', $_GET['user_id']);
	return "<a href='" . admin_url() . "'>" . "(" . $user->display_name . ") " . $user->user_login . "</a>";
}

function populate_admin_users_url() {
	return admin_url() . 'users.php';
}

function populate_admin_request_account_url($REQUEST_ACCOUNT_ENTRIES_ID) {
	return admin_url() . 'admin.php?page=gf_entries&id=' . $REQUEST_ACCOUNT_ENTRIES_ID;
}

add_filter("gform_field_value_deleted_username", "populate_deleted_username");
add_filter("gform_field_value_admin_users_url", "populate_admin_users_url");
add_filter("gform_field_value_admin_request_account_url", "populate_admin_request_account_url");


// Actions
function riteway_registration_save( $user_id ) {
	update_user_meta($user_id, 'user_meta_user_status', 'inactive');
}

add_action( 'user_register', 'riteway_registration_save', 10, 1 );

// UI related functions

function generateCityQuadrantScript() {
	global $CITY_QUADRANT_MAPPINGS;
	$jsonMappings = json_encode($CITY_QUADRANT_MAPPINGS);

	return <<<EOL
<script type="text/javascript">

	jQuery(document).ready(function () {
		var cityEl = jQuery('.city-dynamic-dropdown select');
		jsonMappings = $jsonMappings;

		cityEl.bind('change', function () {
			var quadrantEl = jQuery('.quadrant-dynamic-dropdown select');
			var quadMaps = jsonMappings[this.value];
			var options = '';
			for (var quad in quadMaps) {
				options += '<option>' + quadMaps[quad] + '</option>';
			}
			quadrantEl.html(options);
		});

	});
</script>
EOL;
}

function getExportScripts() {
	$filename = get_the_title() .'-' . date('m-d-Y');;
return <<<EOL
<div class="export-links">
    <a  class="black-btn" download="$filename.xls"
    		href="#xls"
    		onclick="return ExcellentExport.excel(this, 'datatable', '');">
    	Export to Excel
    </a>
    <a class="black-btn"
    	download="$filename.csv"
    	href="#csv"
    	onclick="return ExcellentExport.csv(this, 'datatable');">
		Export to CSV
	</a>
</div>
EOL;
}

function getTableSorterScript($id = 'datatable') {
return <<<EOL
	<script>
	jQuery(document).ready(function($) {
		$(function(){
		  $('#$id').tablesorter();
		});
	});
	</script>
EOL;
}

function openTableMarkup() {
	return '<table id="datatable" class="postlist no-mp"><thead>';
}

function closeTableMarkup() {
	return '</thead></table>';
}

function generateAllBrokerageTables($status = null, $required = array()) {
	$blogs = wp_get_sites( 0, 'all' );
	echo getScripts();
	$sortableTable = openTableMarkup();
	$showHeader =  true;

	if ( 0 < count( $blogs ) ) {
		foreach ( $blogs as $blog ) {


			switch_to_blog( $blog[ 'blog_id' ] );

	        $blog_details = get_blog_details( $blog[ 'blog_id' ] );

			$brokerageDetails =
				'<a href="' . $blog_details->path . '">' . $blog_details->blogname . '</a>';

			$sortableTable .= generateTable(
				$status,
				array(),
				true,
				$required,
				array(
					'Signs Up' => '',
					'Brokerage' => $brokerageDetails
				),
				$showHeader,
				false
			);

			$showHeader =  false;
		}
	}

	$sortableTable .= closeTableMarkup();

	return $sortableTable;
}

function getScripts($export = true) {
	$scripts = getTableSorterScript();
	if ($export) {
		$scripts .= getExportScripts();
	}
	return $scripts;
}

function generateTable(
	$status = null,
	$queryArgs = array(),
	$export = true,
	$required = array(),
	$insertColumns = array(),
	$showHeader = true,
	$openCloseMarkup = true
	)
{

	global $current_user;
	global $SIGN_STATUS_SETUP;
	global $sign_count;

	$config = $SIGN_STATUS_SETUP[$status];
	$fields = $config['fields'];

	$html = '';
	$header = '';
	$rows = '';


	if ($openCloseMarkup) {
		$html = openTableMarkup();

		$scripts = getTableSorterScript();
		if ($export) {
			$scripts .= getExportScripts();
		}

	}

	if ($showHeader) {

		$insertColumns['Signs Up'] = $sign_count;
		if(($current_user->roles['1'] == 'aamrole_5410d7b003aa5') || ($current_user->roles['0'] == 'realtor')){
			unset($insertColumns['Charge Renewal']);
			unset($fields['charge_renewal']);
		}
		
		foreach ($insertColumns as $key => $value) {
			$header .= '<th>' . $key . '</th>';
		}
		foreach ($fields as $key => $value) {

			if($key != 'post_id'){
				$header .= '<th>' . $value . '</th>';
			}
		}

	}

	$i = 0;
	$args = buildFilteredQueryArgs(
		$SIGN_STATUS_SETUP[$status]['title'],
		$queryArgs,
		$required
	);

/*
	// TODO Pagination
	$count_posts = wp_count_posts();
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$page--;
	$limit =  500;

$page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;
$pagination = (new Pagination());
$pagination->setCurrent($page);
$pagination->setTotal(20000);
$pagination->alwaysShowPagination();
$markup = $pagination->parse();


*/
    query_posts( $args );

	if ( have_posts() ) {

		while( have_posts() ) {

			the_post();

			$rows .= '<tr>';

			$sign_count++;
			$insertColumns['Signs Up'] = $sign_count;
			if (sizeof($insertColumns)) {
				foreach ($insertColumns as $key => $value) {
					$rows .= '<td>' . $value . '</td>';
				}
			}

			foreach ($fields as $key => $value) {

				$post_id = get_the_ID();

				if($value != 'ID'){

					$rows .= '<td>';

					switch ($key) {

						case 'post_id':
							$rows .= get_the_ID();
							break;
						case 'accessories':
							$val = '-';
							if (get_post_custom_values($key)) {
								$values = get_post_custom_values($key);
								$val = '<ul>';
								foreach ( $values as $values => $value ) {
									$val .= '<li>' . $value . '</li>';
								}
								$val .= '</ul>';
							}
							if (get_post_custom_values('more_accessories')) {
								$custom_values = get_post_custom_values('more_accessories');
								$val .= '<ul><li><strong>More Accessories:</strong></li>';
								foreach ( $custom_values as $custom_values => $custom_value ) {
									$val .= '<li>' . $custom_value . '</li>';
								}
								$val .= '</ul>';
							}

							$rows .= $val;
							break;
						case 'sign_down_reason':
							$val = '-';
							if (get_post_custom_values($key)) {
								$values = get_post_custom_values($key);
								$val = '<ul>';
								foreach ( $values as $values => $value ) {
									$val .= '<li>' . $value . '</li>';
								}
								$val .= '</ul>';
							}
							$rows .= $val;
							break;

						case 'address':
							if($_SERVER['REQUEST_URI'] == '/reports/signs-up/'){
								$permalink = get_permalink();
								$str = explode('/', $permalink);
								$str['3'] = $str['3'].'/signs';
								$permalink = implode('/', $str);
								$rows .= '<a href="' . $permalink . '">' . get_the_title() . '</a>';
							}else{
								$rows .= '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
							}	
							break;

						case 'comments':
							$val = get_the_content();
							if (empty($val)) {
								$val = '-';
							}else{
								/*if($_REQUEST['URI'] ='/2-percent-realty/signs-up/'){
									$val = '<a href="' . get_permalink() . '">View</a>';
									
								}else{*/
									$val = get_the_content();
								/*}*/
								
							}

							$rows .= $val;
							break;
						case 'post_modified':
							$val = get_the_modified_date('m/d/Y');

							if (empty($val)) {
								$val = '-';
							}
							$rows .= $val;
							break;
						case 'quadrant':
							$val = get_post_meta($post_id, 'quadrant', false);
							if (empty($val)) {
								$val = '-';
							}
							$rows .= end($val);
							break;
						case 'install_date':
							$date = get_post_meta($post_id, 'install_date', false);
							$date = end($date);
							$date = strtotime(date("m/d/Y", strtotime($date)));
							$date = date("m/d/Y", $date);
							$rows .= $date;
							break;
						case 'removal_date':
						case 'removal_instructions':
							$val = '-';
							if (get_field($key)) {
								$val = get_field($key);
							}
							$rows .= $val;
							break;

						case 'renewal_date':
							$date = get_post_meta($post_id, 'install_date', false);
							$date = end($date);
							$date = strtotime(date("m/d/Y", strtotime($date)) . " +6 month");
							$date = date("m/d/Y", $date);
							$rows .= $date;
							break;

						case 'charge_renewal':
							$val = get_post_meta($post_id, 'charge_renewal', true);
							$blog_id = get_current_blog_id();
							if ($val == 'false') {
								$val = 'No Charge';
							}else{
								$val = 'Charge';
							}
							$rows .= '<a href="#" data-name="'.$blog_id.'" data-pk="'.$post_id.'" class="sign'.$post_id.' signs editable editable-click">'.$val.'</a>';
										

							break;
						case 'city':
							$city = '-';
							if (get_field('city')) {
								if (get_field('city') == 'Other') {
									$city = get_field('other_city');
								} else {
									$city = get_post_meta($post_id, 'city', false);
								}
							}
							$rows .= end($city);
							break;

						case 'realtor':
							$rows .= get_riteway_realtor_full_name();
							break;

						default:
							break;
					}

					$rows .= '</td>';
				}	
			}

			$rows .= '</tr>';
		}

	}

	wp_reset_query();
	restore_current_blog();

	if ($showHeader) {
		$header .= '</thead>';
	}

	$html .= $header . $rows;

	if ($openCloseMarkup) {
		$html .= closeTableMarkup();
	}

	return
		$scripts .
		$html
	;
}
