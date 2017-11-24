<!doctype html>
<?php 
global $current_user;
get_currentuserinfo();
$blog_title = get_bloginfo();

?>
	<?php print_r($_GET, true); ?>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>
        <?php if (is_page(array(295, 37)) ) { ?>
        	<?php if ($_GET['order_accessories']) { ?>
			<script>
            jQuery(document).ready(function() {
				jQuery("#input_1_30 option[value='yes']").attr('selected', 'selected');
			});
			</script>
        	<?php } ?>
		<?php } ?>
		<?php if (is_page(array(295, 37)) ) { ?>
        <?php if ($_GET['sign_status'] == 'fix') { ?>
			<script>
            jQuery(document).ready(function() {
				jQuery("#input_1_5 option[value='Fix Sign']").attr('selected', 'selected');
			});
			</script>
        <?php } ?>
        <?php if ($_GET['sign_status'] == 'down') { ?>
			<script>
            jQuery(document).ready(function() {
				jQuery("#input_1_5 option[value='Sign Down']").attr('selected', 'selected');
			});
			</script>
        <?php } ?>
        <script>
        jQuery(document).ready(function($) {

        	$(function(){
   				if ($('body').is('.page-id-295')) {
					var theText = '<?php echo $blog_title;?>';
					$("#field_1_34 option:contains(" + theText + ")").attr('selected', 'selected');
        			$('#field_1_34').hide();
  				 }
			});

			<?php if($current_user->roles['1'] == 'aamrole_5410d7b003aa5'){?>

				$('#field_1_3').removeClass('hide-field realtor-dd');
				
			<?php } ?>
			<?php if($current_user->roles['0'] == 'realtor'){?>

				$('#field_1_34').hide();
				
			<?php } ?>

			$("#input_1_4").change(function(){
			 	if ($('#input_1_4').val() != 'Calgary'){
			 		$('#field_1_8').hide();
			 	}
			 	if ($('#input_1_4').val() == 'Calgary'){
			 		$('#field_1_8').show();
			 		$('#input_1_8').append($('<option>', {
					    value: 0,
					    text: 'Select a Quadrant'
					}));
					$("#input_1_8").val(0);
			 	}
			});		

	        console.log($('.gield_description').length);

			if ($('#input_1_5').length) {
                if(document.getElementById('input_1_5').value == "Sign Up") {
                    $('.status-down').hide();
                    $('.status-fix').hide();
                    $('.status-up').show();
                }
                if(document.getElementById('input_1_5').value == "Fix Sign") {
                    $('.status-down').hide();
                    $('.status-up').hide();
                    $('.status-fix').show();
                }
                if(document.getElementById('input_1_5').value == "Sign Down") {
                    $('#input_1_1').prop('readonly', true);
                    $('.status-up').hide();
                    $('.status-fix').hide();
                    $('.status-down').show();
                }

	            $("#input_1_5").change(function(){

	                if ( $(this).val() == "Sign Down" ) {
	                    $('#input_1_1').prop('readonly', true);
	                    $('.status-up').hide();
	                    $('.status-fix').hide();
	                    $('.status-down').show();
	                }
	                if( $(this).val() == "Fix Sign" ) {
	                    $('.status-down').hide();
	                    $('.status-up').hide();
	                    $('.status-fix').show();
	                }
	                if( $(this).val() == "Sign Up" ) {
	                    $('.status-down').hide();
	                    $('.status-fix').hide();
	                    $('.status-up').show();
	                }
	            });
			}
        });
		jQuery.noConflict();

		  jQuery(document).ready(function($) {
			var dateMin = new Date();
		    dateMin.setDate((dateMin.getDate() + 2) + (dateMin.getHours() >= 14 ? 1 : 0));
			$( "#input_1_7" ).datepicker({
				minDate: dateMin,
				beforeShowDay: function(date) {
				  var day = date.getDay();
				  return [(day != 0 && day != 1)];
				}
			});
			$( "#input_1_9" ).datepicker({
				minDate: dateMin,
				beforeShowDay: function(date) {
				  var day = date.getDay();
				  return [(day != 0 && day != 1)];
				}
			});
			$( "#input_1_12" ).datepicker({
				minDate: dateMin,
				beforeShowDay: function(date) {
				  var day = date.getDay();
				  return [(day != 0 && day != 1)];
				}
			});
			$( "#input_1_26" ).datepicker({
				minDate: dateMin,
				beforeShowDay: function(date) {
				  var day = date.getDay();
				  return [(day != 0 && day != 1)];
				}
			});
		  });
        </script>
        <?php } ?>
	</head>

	<body <?php body_class( ); ?>>

		<div id="container">

			<header class="header" role="banner">

				<div id="inner-header" class="wrap cf">

					<?php // to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> ?>
					<div id="logo" class="h1 m-1of2 t-1of2 d-1of2">
                        <a href="<?php echo home_url(); ?>" rel="nofollow">
                       	 <img src="<?php echo get_stylesheet_directory_uri(); ?>/riteway-logo.gif" width="420" height="110">
                        </a>
                    </div>


					<?php // if you'd like to use the site description you can un-comment it below ?>
					<?php // bloginfo('description'); ?>


					<div class="m-1of2 t-1of2 d-1of2" id="header-block">
                    	<div class="phone-number">
                            <span>Call Us!</span>
                            <span class="phone-number">403.236.3432</span>
                        </div>
					</div>
                    <div class="m-1of2 t-all d-all" id="navbar">
                        <nav role="navigation" id="primary-nav" class="primary-nav">
                            <?php wp_nav_menu(array(
                            'container' => false,                           // remove nav container
                            'container_class' => 'menu cf',                 // class of container (should you choose to use it)
                            'menu' => __( 'The Main Menu', 'bonestheme' ),  // nav name
                            'menu_class' => 'nav top-nav cf',               // adding custom nav class
                            'theme_location' => 'main-nav',                 // where it's located in the theme
                            'before' => '',                                 // before the menu
							'after' => '',                                  // after the menu
							'link_before' => '',                            // before each link
							'link_after' => '',                             // after each link
							'depth' => 0,                                   // limit the depth of the nav
                            'fallback_cb' => ''                             // fallback function (if there is one)
                            )); ?>
                        </nav>
                        <?php
						if ( is_user_logged_in() ) { ?>
							<div class="logged-in-links">
								<a href="<?php echo wp_logout_url(); ?>" title="Logout">Logout</a>
								<a href="index.php?p=264" rel="nofollow">Change Password</a>
							</div>
						<?php } else {
							echo '<div class="logged-in-links"><p>Please login or register</p></div>';
						};
						?>
                    </div>

				</div>

			</header>