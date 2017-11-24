<?php  
include(dirname( __FILE__ ) . '/../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

do_action('update_charge');

?>
 