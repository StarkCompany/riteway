<?php get_header(); ?>

			<div id="content" class="wrap cf">

				<div id="inner-content" class="cf">
				<?php if ( is_user_logged_in() ) { ?>
						<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
									<?php
										$blog_title = get_bloginfo('name');
                                        echo '<h2><strong>Brokerage: ' . $blog_title . '</strong></h2>';
                                    ?>
                                    <?php
                                        $current_user = wp_get_current_user();
                                        $display_name = $current_user->display_name;
                                        if (!empty($current_user->user_firstname) && !empty($current_user->user_lastname)) {
	                                        $display_name = $current_user->user_firstname . ' ' . $current_user->user_lastname;
                                        }
                                        echo '<p>Welcome: ' . $display_name . '</p>';
                                    ?>

								</header> <?php // end article header ?>

								<section class="entry-content cf" itemprop="articleBody">
									<?php
										// the content (pretty self explanatory huh)
										the_content();
									?>
								</section> <?php // end article section ?>
                              	<section>
									<?php if ( user_role_check( 'realtor' )): ?>
										<?php echo sign_edit_current_user_dropdown( 'signs' ) ?>
                                    <?php else: ?>
                                    	<p>Please select Realtor from the menu below</p>
										<?php
                                        $blogusers = get_riteway_active_realtors();
                                        echo '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select a Realtor</option>';
                                        // Array of WP_User objects.
                                        foreach ( $blogusers as $user ) { ?>
                                            <?php echo '<option value="index.php?p=144&user_id=' . esc_html( $user->id ) . '">' . esc_html( $user->display_name ) . '</option>'; ?>
                                        <?php }
                                            echo '</select></form>';
                                        ?>
                                        <div class="action-links">
                                        	<ul>
                                            <li><a href="index.php?p=12">Add New User</a></li>
                                            <li><a href="index.php?p=13">Modify User</a></li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </section>
								<footer class="article-footer cf">

								</footer>

								<?php comments_template(); ?>

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
