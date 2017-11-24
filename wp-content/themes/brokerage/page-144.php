<?php

//view profile

get_header();

?>

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
									<?php if ( user_role_check( 'realtor' )): ?>
                                        <a class="profilelink" href="index.php?p=264">Edit Profile</a>
                                    <?php else: ?>
                                        <a class="profilelink" href="index.php?p=264&user_id=<?php echo $_GET['user_id']; ?>">Edit Profile</a>
                                    <?php endif; ?>
									<?php
										// the content (pretty self explanatory huh)
										the_content();

										wp_link_pages( array(
											'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'bonestheme' ) . '</span>',
											'after'       => '</div>',
											'link_before' => '<span>',
											'link_after'  => '</span>',
										) );
									?>
								</section> <?php // end article section ?>

								<?php if ( user_role_check( 'realtor' )): ?>
                                	<section>
                                        <?php
                                        $user_id = get_current_user_id();
                                        $user = get_user_by( 'id', $user_id );
	                                        $display_name = $user->display_name;
	                                        if (!empty($user->user_firstname) && !empty($user->user_lastname)) {
		                                        $display_name = $user->user_firstname . ' ' . $user->user_lastname;
	                                        }
                                            echo '<p><strong>Name:</strong> ' . $display_name . '</p>';
                                            echo '<p><strong>Email Address:</strong> ' . $user->user_email . '</p>';

                                            $phone_number = get_user_meta($user_id, 'phone_number', true);
                                            if (!empty($phone_number)) {
	                                            echo '<p><strong>Phone Number:</strong> ' . $phone_number . '</p>';
	                                        }
											$extra_info = get_user_meta($user_id, 'extra_info', true);
	                                        if (!empty($extra_info)) {
	                                            echo '<p><strong>Additional Information:</strong><br/>' . $extra_info . '</p>';
	                                        }
                                        ?>
                                    </section>
                                    <section>
                                        <h2>Select a sign that is currently up</h2>
                                        <?php echo sign_edit_current_user_dropdown( 'signs' ) ?>
                                    </section>
								<?php else: ?>
                                    <section>
                                        <?php
                                        $user_id = $_GET['user_id'];
                                        $user = get_user_by( 'id', $user_id );
	                                        $display_name = $user->display_name;
	                                        if (!empty($user->user_firstname) && !empty($user->user_lastname)) {
		                                        $display_name = $user->user_firstname . ' ' . $user->user_lastname;
	                                        }
                                            echo '<p><strong>Name:</strong> ' . $display_name . '</p>';
                                            echo '<p><strong>Email Address:</strong> ' . $user->user_email . '</p>';

                                            $phone_number = get_user_meta($user_id, 'phone_number', true);
                                            if (!empty($phone_number)) {
	                                            echo '<p><strong>Phone Number:</strong> ' . $phone_number . '</p>';
	                                        }
											$extra_info = get_user_meta($user_id, 'extra_info', true);
	                                        if (!empty($extra_info)) {
	                                            echo '<p><strong>Additional Information:</strong><br/>' . $extra_info . '</p>';
	                                        }
                                        ?>
                                    </section>

                                    <section>
                                        <h2>Select a sign that is currently up</h2>
                                        <?php echo sign_up_selected_realtor_dropdown( 'signs' ) ?>
                                    </section>
                                    <section class="report">
                                        <?php include('reports/brokerage-single-user-signs-up.php'); ?>
                                    </section>
								<?php endif; ?>

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
