<?php get_header(); ?>

			<div id="content" class="wrap cf">

				<div id="inner-content" class="cf">

				<?php if ( is_user_logged_in() ) { ?>
						<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>

								</header> <?php // end article header ?>

								<section class="entry-content cf" itemprop="articleBody">
									<?php
										// the content (pretty self explanatory huh)
										the_content();

										/*
										 * Link Pages is used in case you have posts that are set to break into
										 * multiple pages. You can remove this if you don't plan on doing that.
										 *
										 * Also, breaking content up into multiple pages is a horrible experience,
										 * so don't do it. While there are SOME edge cases where this is useful, it's
										 * mostly used for people to get more ad views. It's up to you but if you want
										 * to do it, you're wrong and I hate you. (Ok, I still love you but just not as much)
										 *
										 * http://gizmodo.com/5841121/google-wants-to-help-you-avoid-stupid-annoying-multiple-page-articles
										 *
										*/
										wp_link_pages( array(
											'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'bonestheme' ) . '</span>',
											'after'       => '</div>',
											'link_before' => '<span>',
											'link_after'  => '</span>',
										) );
									?>
								</section> <?php // end article section ?>

								<?php if (is_page('12')) { ?>
								<section class="report">
                          			<?php if ( user_role_check( 'aamrole_5410d7b003aa5' )): ?>
										<?php echo do_shortcode('[user-meta-registration form="Register Realtor"]'); ?>
                                    <?php else: ?>
										<?php echo do_shortcode('[user-meta-registration form="Admin Add User"]'); ?>
                                    <?php endif; ?>
								</section>
                          		<?php } ?>

								<?php if (is_page('5')) { ?>
								<section class="report">
                          			<?php if ( user_role_check( 'realtor' )): ?>
										<?php include('reports/user-signs-up.php'); ?>
                                    <?php else: ?>
										<?php
                                        $blogusers = get_riteway_active_realtors();
                                        echo '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value"><option>Select a Realtor</option>';
                                        // Array of WP_User objects.
                                        foreach ( $blogusers as $user ) { ?>
                                            <?php echo '<option value="index.php?p=452&user_id=' . esc_html( $user->id ) . '">' . esc_html( $user->display_name ) . '</option>'; ?>
                                        <?php }
                                            echo '</select></form>';
                                        ?>
    	                           		<?php include('reports/signs-up.php'); ?>
                                    <?php endif; ?>
								</section>
                          		<?php } ?>

								<?php if (is_page('6')) { ?>
								<section class="report">
                            		<?php if ( user_role_check( 'realtor' )): ?>
										<?php include('reports/user-signs-down.php'); ?>
                                    <?php else: ?>
                                    	<?php
										$blogusers = get_riteway_active_realtors();
										echo '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value"><option>Select a Realtor</option>';
										// Array of WP_User objects.
										foreach ( $blogusers as $user ) { ?>
											<?php echo '<option value="index.php?p=456&user_id=' . esc_html( $user->id ) . '">' . esc_html( $user->display_name ) . '</option>'; ?>
										<?php }
										echo '</select></form>';
										?>
                                        <?php include('reports/signs-down.php'); ?>
                                    <?php endif; ?>
								</section>
                          		<?php } ?>

								<?php if(is_page( array ( 9 ) )) { ?>
                                <section>
                            		<?php if ( user_role_check( 'realtor' )): ?>
										<?php echo sign_edit_current_user_dropdown( 'signs' ) ?>
                                    <?php else: ?>
                                        <?php
                                        $blogusers = get_riteway_active_realtors();
                                        echo '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value"><option>Select a Realtor</option>';
                                        // Array of WP_User objects.
                                        foreach ( $blogusers as $user ) { ?>
                                            <?php echo '<option value="index.php?p=292&user_id=' . esc_html( $user->id ) . '&sign_status=down">' . esc_html( $user->display_name ) . '</option>'; ?>
                                        <?php }
                                            echo '</select></form>';
                                        ?>

                                    <?php endif; ?>
                                </section>
                                <?php } ?>

                                <?php if(is_page( array ( 498 ) )) { ?>
                                <section>
                            		<?php if ( user_role_check( 'realtor' )): ?>

                                    <?php else: ?>
                                    	<h2>Select a Realtor or a Brokerage User</h2>
                                        <?php
                                        $blogusers = get_riteway_active_realtors();
                                        echo '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value"><option>Select a Realtor</option>';
                                        // Array of WP_User objects.
                                        foreach ( $blogusers as $user ) { ?>
                                            <?php echo '<option value="index.php?p=144&user_id=' . esc_html( $user->id ) . '">' . esc_html( $user->display_name ) . '</option>'; ?>
                                        <?php }
                                            echo '</select></form>';
                                        ?>
                                        <?php
                                        $blogusers = get_users( 'orderby=display_name&role=aamrole_5410d7b003aa5' );
                                        echo '<form name="jump3"><select name="jump4" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value"><option>Select a Brokerage User</option>';
                                        // Array of WP_User objects.
                                        foreach ( $blogusers as $user ) { ?>
                                            <?php echo '<option value="index.php?p=144&user_id=' . esc_html( $user->id ) . '">' . esc_html( $user->display_name ) . '</option>'; ?>
                                        <?php }
                                            echo '</select></form>';
                                        ?>
                                    <?php endif; ?>
                                </section>
                                <?php } ?>


                                <?php if (is_page('292')) { ?>
                                <?php
								$user_id = $_GET['user_id'];
								?>

								<section>
                                    <?php if(sign_user_profile_dropdown( 'signs' )){ ?>
                                        <h2>Address of sign for <?php the_author_meta('display_name', $_GET['user_id']); ?></h2>
                                        <?php echo sign_user_profile_dropdown( 'signs' ); ?>
                                    <?php }else{ ?>
                                        <h2><?php the_author_meta('display_name', $user_id)?> has no other signs which can be ordered 'Down'</h2>
                                    <?php } ?> 

                                    <p><a href="index.php?p=452&user_id=<?php echo $_GET['user_id'] ?>">View signs up for this user</a></p>
                                </section>
                          		<?php } ?>

								<?php if(is_page( array ( 8 ) )) { //Order Sign Fix ?>
                              	<section>
									<?php if ( user_role_check( 'realtor' )): ?>
										<?php
										echo sign_edit_current_user_dropdown( 'signs' ) ?>
                                    <?php else: ?>
										<?php
                                        $blogusers = get_riteway_active_realtors();
                                        echo '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value"><option>Select a Realtor</option>';
                                        // Array of WP_User objects.
                                        foreach ( $blogusers as $user ) { ?>
                                            <?php echo '<option value="index.php?p=290&user_id=' . esc_html( $user->id ) . '&sign_status=fix">' . esc_html( $user->display_name ) . '</option>'; ?>
                                        <?php }
                                            echo '</select></form>';
                                        ?>
                                    <?php endif; ?>
                                </section>
                                <?php } ?>

                                <?php if (is_page('290')) { ?>
								<?php
								$user_id = $_GET['user_id'];

								?>
								<section>
                                    <?php if(sign_user_profile_dropdown_fix( 'signs' )){ ?>
                                    	<h2>Address to be fixed for <?php the_author_meta('display_name', $user_id); ?></h2>
        	                            <?php echo sign_user_profile_dropdown_fix( 'signs' ); ?>
                                    <?php }else{ ?>
                                        <h2><?php the_author_meta('display_name', $user_id)?> has no other signs which can be ordered 'Fixed'</h2>
                                    <?php } ?>        
                                </section>
                          		<?php } ?>

                                <?php if (is_page('10')) { ?>
								<section>
                                <?php if ( user_role_check( 'realtor' )): ?>
                                 	<?php echo sign_edit_current_user_dropdown( 'signs' ) ?>
                                <?php else: ?>

									<?php
                                    $blogusers = get_riteway_active_realtors();
                                    echo '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value"><option>Select a Realtor</option>';
                                    // Array of WP_User objects.
                                    foreach ( $blogusers as $user ) { ?>
                                        <?php echo '<option value="index.php?p=288&user_id=' . esc_html( $user->id ) . '&order_accessories=yes">' . esc_html( $user->display_name ) . '</option>'; ?>
                                    <?php }
                                        echo '</select></form>';
                                    ?>

								<?php endif; ?>
                                </section>
                          		<?php } ?>

                                <?php if (is_page('288')) { ?>
                                 <?php
								$user_id = $_GET['user_id'];
								?>
								<section>
                                	<h2>Address to be installed for <?php the_author_meta('display_name', $_GET['user_id']); ?></h2>
    	                            <?php echo sign_user_profile_dropdown( 'signs' ); ?>
                                </section>
                          		<?php } ?>


								<?php if(is_page( 490 )) { ?>
								<section>
									<?php
                                    $blogusers = get_riteway_active_realtors();
                                    echo '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value"><option>Select a Realtor</option>';
                                    // Array of WP_User objects.
                                    foreach ( $blogusers as $user ) {
										$user_id =  $user->id;
										$realtor_url = admin_url() . 'user-edit.php?user_id=' . $user_id;
										$name = $user->display_name;
										$email = $user->user_email;
                                        echo
                                        	'<option value="index.php?p=11&user_id=' . esc_html($user_id) .
                                        	'&realtor=' . esc_html( $name ) .
                                        	'&realtor_email=' . esc_html( $email ) .
                                        	'&realtor_url=' . urlencode( $realtor_url ) .
                                        	'">' . esc_html( $user->display_name ) . '</option>';
                                    }
                                    echo '</select></form>';
                                    ?>
                                </section>
                                <?php } ?>


                                <?php if(is_page( 13 )) { ?>
                              	<section class="report">
                                	<?php include('reports/user-list.php'); ?>
                                </section>
                                <?php } ?>

                                <?php if(is_page( 383 )) { //this is a temp placement?>
                              	<section>
									<?php
                                    $blogusers = get_riteway_active_realtors();
                                    echo '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value"><option>Select a Realtor</option>';
                                    // Array of WP_User objects.
                                    foreach ( $blogusers as $user ) {
                                        echo '<option value="index.php?p=7&user_id=' . esc_html( $user->id ) . '&_wpnonce=825b8ec756' . '">' . esc_html( $user->display_name ) . '</option>';
                                    }
                                    echo '</select></form>';
                                    ?>
                                </section>
                                <?php } ?>




                                <footer class="article-footer cf">

								</footer>

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
												<p><?php _e( 'This is the error message in the page.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>


							<?php get_sidebar(); ?>
				<?php } else { ?>
                	<div class="m-all t-5of7 d-5of7">
                    	<div class="custom-login-form">
                        	<h2>Sign In</h2>
		                    <?php echo do_shortcode("[user-meta-login]"); ?>
                        </div>
                    </div>
                    <div class="m-all t-2of7 d-2of7">
                    	<div class="get-account-widget">
                            <div class="content">
                                <ul>
                                    <li><a href="/register">Get an Account</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php };
                ?>
				</div>

			</div>

<?php get_footer(); ?>
