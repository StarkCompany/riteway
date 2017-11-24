<?php

define('SEND_EMAIL', 1);
define('UNIT_TEST_TITLE', 'UNIT TEST TITLE');
define('UNIT_TEST_AUTHOR', 'Riteway unit test');
define('UNIT_TEST_EMAIL', 'laurellindsay@gmail.com');

require_once( dirname( __FILE__ ) . '/../../../../wp-load.php' );

class RenewalCronHelper {

	private $_postIdx = 0;
	private $_wp = true;
	private $_blogs = array();
	private $_posts = array();
	private $_post = null;

	public function __construct() {
		if (isset($_GET['mode']) && $_GET['mode'] === 'unit-test') {

			require_once('./unit-test-blogs.php');

			$this->_wp = false;
			$this->_blogs = $blogs;
			$this->_posts = $posts;
			$this->_postIdx = count($posts);
		} else {
			$this->_blogs = wp_get_sites( 0, 'all' );
		}
	}

	public function __call($method, $arguments) {

		if ($this->_wp) {
			return call_user_func_array($method, $arguments);
		}

		$arguments = serialize($arguments);

		return "$method (" . $arguments . ");";
	}

	public function getBlogs() {
		return $this->_blogs;
	}

	public function get_the_author() {

		if ($this->_wp) {
			return get_the_author();
		}

		return UNIT_TEST_AUTHOR;
	}

	public function get_the_author_meta($meta) {

		if ($this->_wp) {
			return get_the_author_meta($meta);
		}

		return UNIT_TEST_EMAIL;
	}

	public function get_the_title() {

		if ($this->_wp) {
			return get_the_title();
		}

		return UNIT_TEST_TITLE;

	}

	public function get_field($field) {

		if ($this->_wp) {
			return get_field($field);
		}

		if (isset($this->_post->$field)) {
			return $this->_post->$field;
		}

		return $field;
	}

	public function update_field($field, $value) {

		if ($this->_wp) {
			return update_field($field, $value);
		}

	}

	public function update_post_meta($post_id, $meta_key, $meta_value) {

		if ($this->_wp) {
			return update_post_meta($post_id, $meta_key, $meta_value);
		}

	}

	public function get_post() {

		if ($this->_wp) {
			return get_post();
		}

		$this->_post = (object) array_shift($this->_posts);
		$this->_postIdx--;
		return $this->_post;

	}

	public function get_post_meta($post_id, $key, $single = false) {

		$post_meta = get_post_meta($post_id, $key, $single);
		$post_meta = end($post_meta);
		if ($this->_wp) {
			return $post_meta;
		}

		return null;
	}

	public function have_posts() {

		if ($this->_wp) {
			return have_posts();
		}

		return ($this->_postIdx);
	}


	public function log($msg) {
		global $blog_name;
		print(" $msg \n");
	}

}

$renewalCronHelper = new RenewalCronHelper();
$blogs = $renewalCronHelper->getBlogs();

if ( 0 < count( $blogs ) ) {

	foreach ( $blogs as $blog ) {

		switch_to_blog( $blog[ 'blog_id' ] );

		$brokerageType = get_option('brokeragetype');
		$blog_name = get_option('blogname');

		$brokerageEmail = '';
		   
		switch($brokerageType) {
		    case A:

		      $rule = 'Renewal Sends to Brokerage Admin Role'; 

		      $args = array(
		        'blog_id'      => $GLOBALS['blog_id'],
		        'role'         => 'aamrole_5410d7b003aa5',
		        'meta_key'     => '',
		        'meta_value'   => '',
		        'meta_compare' => '',
		        'meta_query'   => array(),
		        'include'      => array(),
		        'exclude'      => array(),
		        'orderby'      => 'login',
		        'order'        => 'ASC',
		        'offset'       => '',
		        'search'       => '',
		        'number'       => '',
		        'count_total'  => false,
		        'fields'       => 'all',
		        'who'          => ''
		       );

		      break;

		    case B:

				$rule = 'Renewal Sends to Realtors and Not Brokerage Admin'; 

		      break;
		    
		    case C:

				$rule = 'Renewal Sends to Realtors'; 

		      break;

		    case D:

			  $rule = 'Renewal Sends to Brokerage Admin and Realtors'; 
		      $args = array(
		        'blog_id'      => $GLOBALS['blog_id'],
		        'role'         => 'aamrole_5410d7b003aa5',
		        'meta_key'     => '',
		        'meta_value'   => '',
		        'meta_compare' => '',
		        'meta_query'   => array(),
		        'include'      => array(),
		        'exclude'      => array(),
		        'orderby'      => 'login',
		        'order'        => 'ASC',
		        'offset'       => '',
		        'search'       => '',
		        'number'       => '',
		        'count_total'  => false,
		        'fields'       => 'all',
		        'who'          => ''
		       );

		      break;      
		}

		if ($brokerageType == 'A' || $brokerageType == 'D'){
			
			$brokerageUsers = get_users( $args );
			$users = json_decode(json_encode($brokerageUsers), true);

			foreach($users as $user){

				$brokerageEmail .= ', '.$user['data']['user_email'];

			}
		}

		$brokerageEmail = trim($brokerageEmail, ",");	

		$renewalCronHelper->log('<h1>'.$blog_name.'</h1>');
		$renewalCronHelper->log('<br>');
		$renewalCronHelper->log("Brokerage Type: " . $brokerageType);
		$renewalCronHelper->log('<br>');
		$renewalCronHelper->log($rule);
		$renewalCronHelper->log('<br>');				
		$renewalCronHelper->log('Brokerage Email: ' . $brokerageEmail);
		$renewalCronHelper->log('<br>');
		$renewalCronHelper->log("Switch to blog $blog_name - " . $blog['blog_id']);
		$renewalCronHelper->log("<br>");

		$blog_name = get_bloginfo( 'name' );

		$blog_posts_processed = 0;
		$blog_emails_sent = 0;

		$args = array (
			'blog_id' => $blog['blog_id'],
			'post_type' => 'signs'
		);

		$renewalCronHelper->query_posts( $args );

		if ( $renewalCronHelper->have_posts() ) {

			while ( $renewalCronHelper->have_posts() ) {

				the_post();

				$post = $renewalCronHelper->get_post();

				$post_id = $post->ID;

				$sign_request_status = $renewalCronHelper->get_field('sign_status');
				$sign_request_charge_renewal = $renewalCronHelper->get_field('charge_renewal');
				if(empty($sign_request_charge_renewal)){
					$sign_request_charge_renewal = 'true';
				}

				$renewalCronHelper->log("<br>");
				$renewalCronHelper->log("<br>");
				$renewalCronHelper->log("Checking Post: " . $post_id);
				$renewalCronHelper->log("<br>");
				$renewalCronHelper->log("Charge Renewal: " . $sign_request_charge_renewal);
				$renewalCronHelper->log("<br>");


				if (($sign_request_status == 'Sign Up' || $sign_request_status == 'Sign Fix')  && $sign_request_charge_renewal == 'true' ) {

					// Renewals sent out 2, 7, and 14 days prior to 6 month intervals
					// (6 months - 2 days)
					// (6 months - 7 days)
					// (6 months - 14 days)
					$RENEWAL_EMAIL_DAYS_PRIOR = array(2, 7, 14);
					$RENEWAL_TIME_MONTHS = 6;

					$now_date = date('m/d/Y');
					$now_day = date('d');
					$now_date_time = new DateTime($now_date);

					$cron_last_sent_renewal_field = $renewalCronHelper->get_post_meta($post_id, 'cron_last_sent_renewal');

					/*if (!empty($cron_last_sent_renewal_field) &&
						$cron_last_sent_renewal_field == $now_date)
					{
						$renewalCronHelper->log("Cron has already run for $now_date");
						continue;
					}*/

					$install_field = $renewalCronHelper->get_field('install_date');
					$install_date = strtotime(date('m/d/Y', strtotime($install_field)));
					$install_date = date('m/d/Y', $install_date);

					$install_date_time = new DateTime($install_field);
					$date_diff = $install_date_time->diff($now_date_time);

					$renewalCronHelper->log(
						"Install date - $install_date "
						. "- month diff = " . $date_diff->m
						. "- day diff = " . $date_diff->d
					);

					if ($date_diff->invert === 0 &&
						$date_diff->m > 0 &&
						$date_diff->m % ($RENEWAL_TIME_MONTHS - 1) === 0)
					{

						$renewalCronHelper->log("$install_date - search for 2, 7, 14 day renewals");

						foreach ($RENEWAL_EMAIL_DAYS_PRIOR as $days_prior) {

							$reminder_date = strtotime(date('m/d/Y', strtotime($install_field)) . "-$days_prior days");
							$reminder_day = date('d', $reminder_date);

							$renewalCronHelper->log('Checking reminder day - (' . $now_day . "=" . $reminder_day . ')');

							if ($now_day === $reminder_day) {

								$renewal_date = strtotime($now_date . "+$days_prior days");
								$renewal_date = date('m/d/Y', $renewal_date);

								$the_title = $renewalCronHelper->get_the_title();
								$address = $the_title;
								$city = $renewalCronHelper->get_field('city');
								$city_other = $renewalCronHelper->get_field('other_city');
								$quadrant = $renewalCronHelper->get_field('quadrant');
								$special_instructions =  $renewalCronHelper->get_field('special_instructions');
								$accessories = $renewalCronHelper->get_field('accessories');

								$author = $renewalCronHelper->get_the_author();
								$first_name = $renewalCronHelper->get_the_author_meta('first_name', $post_id);
								$last_name = $renewalCronHelper->get_the_author_meta('last_name', $post_id);

								// Determine Brokerage type and Email Renewal recipients
								
								switch($brokerageType) {
									case A:

										$renewalCronHelper->log('Brokerage Type A - Emailing Brokerage Accounts: '. $brokerageEmail);
										$email_recipient = $brokerageEmail;
										break;

									case B:

										$renewalCronHelper->log('Brokerage Type B - Emailing Realtor: '. $renewalCronHelper->get_the_author_meta('user_email'));
										$email_recipient = $renewalCronHelper->get_the_author_meta('user_email');
										break;

									case C:

										$renewalCronHelper->log('Brokerage Type C - Emailing Realtor: '. $renewalCronHelper->get_the_author_meta('user_email'));
										$email_recipient = $renewalCronHelper->get_the_author_meta('user_email');
										break;

									case D:
										
										$renewalCronHelper->log('Brokerage Type C - Emailing Brokerage Accounts and Realtor: '. $brokerageEmail .', '. $renewalCronHelper->get_the_author_meta('user_email'));
										$email_recipient = $brokerageEmail .', '.$renewalCronHelper->get_the_author_meta('user_email');
										break;
								}


								$subject = "($first_name $last_name) Sign Renewal Reminder: " . $address;
								//$subject = "$days_prior Day Sign Renewal Reminder: " .  $the_title;
								$headers = "From: Riteway Signs Admin <$admin_email>";
								$message = "This is your 6 month sign renewal reminder for:<br/>"
								. $address . "<br />"
								. $city . " " . $city_other . "<br /><br />"
								. "Sign Install Date: " . $install_date . "<br />"
								. "Sign Renewal Date: " . $renewal_date
								. "<br /><br />"
								. "PLEASE NOTE:"
								. "If your sign is not ordered down before the renewal date, you will be invoiced for an additional 6 month period."
								. "<br />"
								. "** If your listing is sold, you can post-date the removal, and eliminate a renewal fee**"
								. "Please visit our Terms & Conditions for more information.";

								if (SEND_EMAIL) {
									$renewalCronHelper->log($email_recipient);
									$renewalCronHelper->log('<br>');
									$renewalCronHelper->log($subject);
									$renewalCronHelper->log('<br>');
									$renewalCronHelper->log($message);
									$renewalCronHelper->log('<br>');
									add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
									wp_mail( $email_recipient, $subject, $message, $headers, $attachments );
								} else {
									$renewalCronHelper->log("Email Body - " . $message);
								}

								$blog_emails_sent++;

								$renewalCronHelper->update_post_meta($post_id, 'cron_last_sent_renewal', $now_date);
								$renewalCronHelper->log("Sending $days_prior day reminder email to $email_recipient");

								// Can only send one email reminder per post
								break;

							}

						}

					}

					$blog_posts_processed++;
				}
			}
		}

		$renewalCronHelper->log('<br>');
		$renewalCronHelper->log('<br>');
		$renewalCronHelper->log("-------------- Summary --------------");
		$renewalCronHelper->log('<br>');
		$renewalCronHelper->log('<br>');
		$renewalCronHelper->log("Processed = " . $blog_posts_processed);
		$renewalCronHelper->log('<br>');
		$renewalCronHelper->log("Emails Sent = " . $blog_emails_sent);
		$renewalCronHelper->log('<br>');
		$renewalCronHelper->log("Done\n");

		wp_reset_query();
		restore_current_blog();

	}
}
