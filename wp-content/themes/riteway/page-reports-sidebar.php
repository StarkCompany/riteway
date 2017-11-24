<?php
/*
 Template Name: Sidebar Report Pages
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header( 'reports' ); ?>

			<div id="content" class="wrap cf">

				<div id="inner-content" class="cf">
                    <div id="main" class="m-all t-2of3 d-3of4 cf" role="main">
                        <?php if ( is_super_admin() ) { ?>
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
                                <header class="article-header">
                                    <h1 class="page-title"><?php the_title(); ?></h1>
                                </header>
                                <section class="entry-content cf" itemprop="articleBody">
                                    <?php
                                        the_content();
    
                                        wp_link_pages( array(
                                            'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'bonestheme' ) . '</span>',
                                            'after'       => '</div>',
                                            'link_before' => '<span>',
                                            'link_after'  => '</span>',
                                        ) );
                                    ?>
                                </section>
                                
                                <section>
    
                                <?php if (is_page('247')) {
                                    include('reports/brokerages.php');
                                } ?>
                                <?php if (is_page('333')) { //Add Sign Up
									echo '<h2>Select a Brokerage to add a sign up</h2>';
                                    echo add_sign_select_brokerage();
                                } ?>
                                
                                <?php if (is_page('338')) { //Order Sign Down
									echo '<h2>Select a Brokerage to order a sign down</h2>';
                                    echo edit_signs_select_brokerage();
                                } ?>
                                
								<?php if (is_page('341')) { //Order Sign Down
									echo '<h2>Select a Brokerage to edit a sign</h2>';
                                    echo edit_signs_select_brokerage();
                                } ?>
                                
                                <?php if (is_page('345')) { //View Brokerage
									echo '<h2>Select a Brokerage to view</h2>';
                                    echo view_brokerage();
                                } ?>
                                
                                <?php if (is_page('347')) { //View Brokerage
									echo '<h2>Select a Brokerage to add a user</h2>';
                                    echo add_user_select_brokerage();
                                } ?>
                                
                                <?php if (is_page('349')) { //View Brokerage
									echo '<h2>Select a Brokerage to edit a user</h2>';
                                    echo edit_user_select_brokerage();
                                } ?>
                                
                                <?php if (is_page('351')) { //View Brokerage
									echo '<h2>Select a Brokerage to view a user</h2>';
                                    echo view_user_select_brokerage();
                                } ?>
                                
                                </section>

                            </article>
    
                            <?php endwhile; else : ?>
    
                                <article id="post-not-found" class="hentry cf">
                                        <header class="article-header">
                                            <h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
                                    </header>
                                        <section class="entry-content">
                                            <p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
                                    </section>
                                    <footer class="article-footer">
                                            <p><?php _e( 'This is the error message in the page-custom.php template.', 'bonestheme' ); ?></p>
                                    </footer>
                                </article>
                            <?php endif; ?>
						<?php } else {
							 echo "You do not have permission to view this page";
						} ?>
						
					</div>
                    <?php if ( is_super_admin() ) { ?>
                    <div id="sidebar1" class="sidebar m-all t-1of3 d-1of4 last-col cf" role="complementary">
                    
                            <nav role="navigation" id="Signs-nav" class="sidebar-nav">
                            	<h2>Signs</h2>
                                <?php wp_nav_menu(array(
                                'container' => false,                           // remove nav container
                                'container_class' => 'menu cf',                 // class of container (should you choose to use it)
                                'menu' => __( 'Signs Menu', 'bonestheme' ),	// nav name
                                'menu_class' => 'nav top-nav cf',               // adding custom nav class
                                'theme_location' => 'signs',		          	// where it's located in the theme
                                'before' => '',                                 // before the menu
                                'after' => '',                                  // after the menu
                                'link_before' => '',                            // before each link
                                'link_after' => '',                             // after each link
                                'depth' => 0,                                   // limit the depth of the nav
                                'fallback_cb' => ''                             // fallback function (if there is one)
                                )); ?>
                            </nav>
                            <nav role="navigation" id="users-nav" class="sidebar-nav">
                            	<h2>Users:</h2>
                                <?php wp_nav_menu(array(
                                'container' => false,                           // remove nav container
                                'container_class' => 'menu cf',                 // class of container (should you choose to use it)
                                'menu' => __( 'Users Menu', 'bonestheme' ), 	// nav name
                                'menu_class' => 'nav top-nav cf',               // adding custom nav class
                                'theme_location' => 'users',		           // where it's located in the theme
                                'before' => '',                                 // before the menu
                                'after' => '',                                  // after the menu
                                'link_before' => '',                            // before each link
                                'link_after' => '',                             // after each link
                                'depth' => 0,                                   // limit the depth of the nav
                                'fallback_cb' => ''                             // fallback function (if there is one)
                                )); ?>
                            </nav>                      
    
                            <nav role="navigation" id="accessories-nav" class="sidebar-nav">
                            	<h2>Accessories:</h2>
                                <?php wp_nav_menu(array(
                                'container' => false,                           	// remove nav container
                                'container_class' => 'menu cf',                 	// class of container (should you choose to use it)
                                'menu' => __( 'Accessories Menu', 'bonestheme' ),	// nav name
                                'menu_class' => 'nav top-nav cf',               	// adding custom nav class
                                'theme_location' => 'accessories',          		// where it's located in the theme
                                'before' => '',                                		// before the menu
                                'after' => '',                                  	// after the menu
                                'link_before' => '',                            	// before each link
                                'link_after' => '',                             	// after each link
                                'depth' => 0,                                   	// limit the depth of the nav
                                'fallback_cb' => ''                             	// fallback function (if there is one)
                                )); ?>
                            </nav>            
                            <nav role="navigation" id="reports-nav" class="sidebar-nav">
                            	<h2>Reports</h2>
                                <?php wp_nav_menu(array(
                                'container' => false,                           // remove nav container
                                'container_class' => 'menu cf',                 // class of container (should you choose to use it)
                                'menu' => __( 'Reports Menu', 'bonestheme' ),	// nav name
                                'menu_class' => 'nav top-nav cf',               // adding custom nav class
                                'theme_location' => 'reports',		          	// where it's located in the theme
                                'before' => '',                                 // before the menu
                                'after' => '',                                  // after the menu
                                'link_before' => '',                            // before each link
                                'link_after' => '',                             // after each link
                                'depth' => 0,                                   // limit the depth of the nav
                                'fallback_cb' => ''                             // fallback function (if there is one)
                                )); ?>
                            </nav>
                            
                            <nav role="navigation" id="website-nav" class="sidebar-nav">
                            	<h2>Website</h2>
                                <?php wp_nav_menu(array(
                                'container' => false,                           // remove nav container
                                'container_class' => 'menu cf',                 // class of container (should you choose to use it)
                                'menu' => __( 'Website Menu', 'bonestheme' ),	// nav name
                                'menu_class' => 'nav top-nav cf',               // adding custom nav class
                                'theme_location' => 'website',		          	// where it's located in the theme
                                'before' => '',                                 // before the menu
                                'after' => '',                                  // after the menu
                                'link_before' => '',                            // before each link
                                'link_after' => '',                             // after each link
                                'depth' => 0,                                   // limit the depth of the nav
                                'fallback_cb' => ''                             // fallback function (if there is one)
                                )); ?>
                            </nav>                      
                    </div>
                    <?php } ?>
				</div>
			</div>


<?php get_footer(); ?>
