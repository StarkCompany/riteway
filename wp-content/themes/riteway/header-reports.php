<!doctype html>

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
		<link href="/wp-content/themes/riteway/library/css/bootstrap.css" rel="stylesheet">
		<script src="/wp-content/themes/riteway/library/js/jquery-2.1.3.js"></script>
    	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    	<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    	<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
   
		
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>
		<?php if (is_page('14')) { ?>
			<script type="text/javascript">
            jQuery(document).ready(function($) {
				<?php $loop = new WP_Query( array( 'post_type' => 'sign' ) ); ?>
				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                    $(window).load(function() {
                        $('#slider-<?php echo get_the_ID(); ?> ').nivoSlider({
                            effect: 'fade',               // Specify sets like: 'fold,fade,sliceDown'
                            slices: 15,                     // For slice animations
                            boxCols: 8,                     // For box animations
                            boxRows: 4,                     // For box animations
                            animSpeed: 500,                 // Slide transition speed
                            pauseTime: 3000,                // How long each slide will show
                            startSlide: 0,                  // Set starting Slide (0 index)
                            directionNav: false,             // Next & Prev navigation
                            controlNav: false,               // 1,2,3... navigation
                            controlNavThumbs: false,        // Use thumbnails for Control Nav
                            pauseOnHover: false,             // Stop animation while hovering
                            manualAdvance: false,           // Force manual transitions
                            prevText: 'Prev',               // Prev directionNav text
                            nextText: 'Next',               // Next directionNav text
                            randomStart: false,             // Start on a random slide
                            beforeChange: function(){},     // Triggers before a slide transition
                            afterChange: function(){},      // Triggers after a slide transition
                            slideshowEnd: function(){},     // Triggers after all slides have been shown
                            lastSlide: function(){},        // Triggers when last slide is shown
                            afterLoad: function(){}         // Triggers when slider has loaded
                        });
                    });
				<?php endwhile; wp_reset_query(); ?>
            } );
            </script>
		<?php } ?>
	</head>

	<body <?php body_class(); ?>>

		<div id="container">

			<header class="header" role="banner">

				<div id="inner-header" class="wrap cf">

					<?php // to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> ?>
					<div id="logo" class="h1 m-1of2 t-1of2 d-1of2">
                    	<?php
						if (get_field('logo', 'option')) { ?>
							<a href="<?php echo home_url(); ?>" rel="nofollow">
							<?php 
								$image = get_field('logo', 'option');
								if( !empty($image) ):
									$url = $image['url'];
								?>
								<img src="<?php echo $url; ?>"width="420" height="110" />
							<?php endif; ?>
							</a>
						<?php }
						else {
							echo '<a href="' . home_url() . '" rel="nofollow">' . bloginfo('name') . '</a>';
						}
						?>
                    </div>


					<?php // if you'd like to use the site description you can un-comment it below ?>
					<?php // bloginfo('description'); ?>


					<div class="m-1of2 t-1of2 d-1of2" id="header-block">
                    	<div class="phone-number">
                            <span>Call Us!<span> 
                            <?php if (get_field('phone_number', 'option')) {
                                echo '<span class="phone-number">' . get_field('phone_number', 'option') . '</span>';
                            }?>
                        </div>
					</div>
                    <div class="m-1of2 t-all d-all" id="navbar">
                        <nav role="navigation" id="primary-nav" class="primary-nav">
                        	<div class="menu-toggle"><i class="fa fa-bars"></i></div>
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
                    </div>

				</div>

			</header>