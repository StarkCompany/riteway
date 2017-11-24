<?php
/*
 Template Name: Report Signs Up
 *
*/
?>

<?php // echo get_all_sites() ?>
<script>
jQuery(document).ready(function($) {
	$(function(){
	  $('#datatable').tablesorter({
		  sortList: [[0,0]]
	  });
	});
});
</script>
<h2>List of Brokerages</h2>
<table id="datatable" class='postlist no-mp table-brokerages'>
	<thead>
        <th>Brokerage</th>
        <th>Link</th>
	</thead>
    <tbody>
<?php 
// get all blogs
$blogs = wp_get_sites(0,'all');

if ( 0 < count( $blogs ) ) :
    foreach( $blogs as $blog ) : 
        switch_to_blog( $blog[ 'blog_id' ] );

        if ( get_theme_mod( 'show_in_home', 'on' ) !== 'on' ) {
            continue;
        }

        $description  = get_bloginfo( 'description' );
        $blog_details = get_blog_details( $blog[ 'blog_id' ] );
        ?>
        <tr class="brokerage-id-<?php echo  $blog_details->blog_id; ?>">
            <td><a href="<?php echo $blog_details->path ?>"><?php echo  $blog_details->blogname; ?></a></td>
            <td><a href="<?php echo $blog_details->path ?>">View Brokerage</a></td>
		</tr>
            
            <?php 
			wp_reset_query();
            restore_current_blog();
            ?>
        
<?php endforeach;
endif; ?>
	<tbody>
</table>
