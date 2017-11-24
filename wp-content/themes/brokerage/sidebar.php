				<div id="sidebar1" class="sidebar m-all t-1of3 d-2of7 last-col cf" role="complementary">
                <div class="menu-toggle"><i class="fa fa-bars"></i></div>

					<?php if ( user_role_check( 'aamrole_5410d7b003aa5' )): ?>
                        <nav role="navigation" id="brokerage-nav" class="sidebar-nav">
                            <?php wp_nav_menu(array(
                            'container' => false,                           // remove nav container
                            'container_class' => 'menu cf',                 // class of container (should you choose to use it)
                            'menu' => __( 'Brokerage Menu', 'bonestheme' ), // nav name
                            'menu_class' => 'nav top-nav cf',               // adding custom nav class
                            'theme_location' => 'brokerage_menu',           // where it's located in the theme
                            'before' => '',                                 // before the menu
                            'after' => '',                                  // after the menu
                            'link_before' => '',                            // before each link
                            'link_after' => '',                             // after each link
                            'depth' => 0,                                   // limit the depth of the nav
                            'fallback_cb' => ''                             // fallback function (if there is one)
                            )); ?>
                        </nav>                      
                    <?php endif; ?>
					<?php if ( is_super_admin()): ?>
                        <nav role="navigation" id="brokerage-nav" class="sidebar-nav">
                            <?php wp_nav_menu(array(
                            'container' => false,                           // remove nav container
                            'container_class' => 'menu cf',                 // class of container (should you choose to use it)
                            'menu' => __( 'Brokerage Menu', 'bonestheme' ), // nav name
                            'menu_class' => 'nav top-nav cf',               // adding custom nav class
                            'theme_location' => 'brokerage_menu',           // where it's located in the theme
                            'before' => '',                                 // before the menu
                            'after' => '',                                  // after the menu
                            'link_before' => '',                            // before each link
                            'link_after' => '',                             // after each link
                            'depth' => 0,                                   // limit the depth of the nav
                            'fallback_cb' => ''                             // fallback function (if there is one)
                            )); ?>
                        </nav>                      
                    <?php endif; ?>
                    <?php if ( user_role_check( 'realtor' )): ?>
                        <nav role="navigation" id="realtor-nav" class="sidebar-nav">
                            <?php wp_nav_menu(array(
                            'container' => false,                           // remove nav container
                            'container_class' => 'menu cf',                 // class of container (should you choose to use it)
                            'menu' => __( 'Realtor Menu', 'bonestheme' ),	// nav name
                            'menu_class' => 'nav top-nav cf',               // adding custom nav class
                            'theme_location' => 'realtor_menu',          	// where it's located in the theme
                            'before' => '',                                 // before the menu
                            'after' => '',                                  // after the menu
                            'link_before' => '',                            // before each link
                            'link_after' => '',                             // after each link
                            'depth' => 0,                                   // limit the depth of the nav
                            'fallback_cb' => ''                             // fallback function (if there is one)
                            )); ?>
                        </nav>      
                    <?php endif; ?>
                    <?php dynamic_sidebar( 'sidebar1' ); ?>
                        
				</div>