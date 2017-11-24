<?php
/*
Report List of Users
 *
*/
?>

<?php // echo get_all_sites() ?>
<script>
jQuery(document).ready(function($) {
	$(function(){
	  $('#datatable').tablesorter();
	});
});
</script>


<?php
$blogusers = get_users( 'role=realtor' );
echo '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select a User to Edit</option>';
// Array of WP_User objects.
foreach ( $blogusers as $user ) { ?>
	<?php echo '<option value="index.php?p=264&user_id=' . esc_html( $user->id ) . '">' . esc_html( $user->display_name ) . '</option>'; ?>
<?php }
	echo '</select></form>';
?>

<table id="datatable" class='postlist no-mp m-all t-all d-all'>
	<thead>
        <th>Name</th>
        <th>Email</th>
        <th>Link</th>
	</thead>
    <tbody>
<?php
$blogusers = get_riteway_active_realtors();
// Array of WP_User objects.
foreach ( $blogusers as $user ) { ?>
	<tr>
    	<td>
        	<?php echo '<a href="index.php?p=264&user_id=' . esc_html( $user->id ) . '">' . esc_html( $user->display_name ) . '</a>'; ?>
        </td>
	    <td>
        	<?php echo esc_html( $user->user_email ); ?>
        </td>
        <td>
	        <?php echo '<a href="index.php?p=264&user_id=' . esc_html( $user->id ) . '">Edit User</a>'; ?>
        </td>
    </tr>
<?php } ?>
	<tbody>
</table>
