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
                                    <div class="sign-data">
                                    	<?php
										$user_id = $_GET['realtor'];
										$realtor = get_user_by( 'id', $user_id );
										$realtorFullName = $realtor->first_name . ' ' . $realtor->last_name;
										$sign_status = $_GET['sign_status'];
										$address = $_GET['address'];
										$city = $_GET['city'];
										$city = $_GET['other_city'];
										$quadrant = $_GET['quadrant'];
										$install_date = $_GET['install_date'];
										$install_instructions = $_GET['install_instructions'];
										$accessories = $_GET['accessories'];
										?>
                                        	<h3><strong>Sign Status:</strong> <?php echo $sign_status; ?></h3>
											<ul>
                                            	<li><span>Realtor: </span><?php echo $realtorFullName; ?></li>
                                                <li><span>Address: </span><?php echo $address; ?></li>
                                                <li><span>City: </span><?php
												if ($city == 'Other') {
													echo $other_city;
												}
												else {
													echo $city;
												} ?></li>
                                                <li><span>Quadrant: </span><?php echo $quadrant; ?></li>
                                                <li><span>Date Installed: </span><?php echo $install_date; ?></li>
                                                <li><span>Special Install Instructions: </span><br/><?php echo $install_instructions; ?></li>
                                                <li><span>Accessories: </span><?php echo $accessories; ?></li>
                                            </ul>
										<?php ?>
                                    </div>
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
