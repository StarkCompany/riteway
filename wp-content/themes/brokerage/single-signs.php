<?php get_header(); ?>

			<div id="content" class="wrap cf">
            <?php if ( is_user_logged_in() ) { ?>
				<div id="inner-content" class="cf">
					<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

					<!--removed while loop to show only 1 sign info -->
						<?php if (have_posts()) : the_post(); ?>


			   				<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
                				<header class="article-header">
									<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
									<p class="byline vcard">
                    					<?php printf( __( 'Ordered <time class="updated" datetime="%1$s" pubdate>%2$s</time> by Realtor: <span class="author">%3$s</span>', 'bonestheme' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) )); ?>
                  					</p>
                				</header> <?php // end article header ?>

                				<section class="entry-content cf" itemprop="articleBody">
                					<span class="progress">Step 3 of 4: Confirm Details</span>
                					<div class="sign-data">
                    					<div>
					                    	<span>Sign Summary:</span>
					                    	<br />
					                    	This is the current status of the sign
					                    </div>
					                    <?php
									    echo '<div id="sign-status"><span>Sign Status: </span>' . get_field('sign_status') . '</div>';
										echo '<div><span>Realtor: </span>';
										echo get_riteway_realtor_full_name();
										echo '</div>';
										echo '<div>
						  					  <span>Address: </span>';
											the_title();
										echo '</div>';
										$post_id = get_the_ID();
										$city = get_post_meta($post_id, 'city', false);
										$city = end($city);
										$quadrant = get_post_meta($post_id, 'quadrant', false);
										$quadrant = end($quadrant);
										$install_date = get_post_meta($post_id, 'install_date', false);
										$install_date = end($install_date);
										if ($city == 'Other') {
											echo '<div><span>City: </span>' . $city . '</div>';
										}
										elseif ($city !== 'Other') {
											echo '<div><span>City: </span>' . $city . '</div>';
										};
										if ($quadrant) {
											echo '<div><span>Quadrant: </span>' . $quadrant . '</div>';
										}
										else {
											echo '<div><span>Quadrant: </span> - </div>';
										}
										echo '<div><span>Install Date: </span>' . $install_date . '</div>';
										$date_renewal = $install_date;
										$date_renewal = strtotime(date("m/d/Y", strtotime($date_renewal)) . " +6 month");
										$date_renewal = date("m/d/Y",$date_renewal);
										echo '<div><span>Renewal Date: </span>' . $date_renewal . '</div>';
										$special_instructions = get_the_content();
										if (!empty($special_instructions)) {
											echo '<div>';
							  				echo '<span>Special Instructions: </span>';
							  				echo $special_instructions;
											echo '</div>';
										}

										$accessory_values = get_post_custom_values('accessories');
										if (!empty($accessory_values)) {
											echo '<div><span>Accessories: </span>';
											echo '<ul>';
											foreach ( $accessory_values as $values => $value ) {
												echo '<li>' . $value . '</li>';
											}
											echo '</ul>';
											echo '</div>';
										}

										$accessories_intructions = the_field('accessories_instructions');
										if (!empty($accessories_intructions)) {
											echo '<div><span>Accessories Instructions: </span>';
											echo '<p>';
												echo $accessories_intructions;
											echo '</p>';
											echo '</div>';
										}
										?>
					                    <?php if (get_post_custom_values('add_more_accessories') === 'yes') { ?>
				                    	<div>
				                            <span>More Accessories Install Date: </span>
				                            <?php $date_values = get_post_custom_values('more_accessories_date');
				                            echo $date_values[0];
				                            ?>
				                        </div>
				                        <div>
				                        	<span>More Accessories:</span>
											<?php $more_values = get_post_custom_values( 'more_accessories');
				                            echo '<ul>';
				                            foreach ( $more_values as $values => $value ) {
				                                echo '<li>' . $value . '</li>';
				                            }
				                            echo '</ul>';
				                            ?>
				                        </div>
				                        <div>
				                        	<span>More Accessories Details: </span>
				                            <?php $detail_values = get_post_custom_values('more_accessories_details');
				                            echo '<div>';
				                            foreach ( $detail_values as $values => $value ) {
				                                echo '<p>' . $value . '</p>';
				                            }
				                            echo '</div>';
				                            ?>
				                        </div>
						            <?php } ?>
				                    <?php if (get_field('removal_date')) { ?>
											<div>
					                    		<span>Removal Date: </span> <? echo get_field('removal_date'); ?>
				                    		</div>
									<?php } ?>
									<?php if (get_field('removal_instructions')) { ?>
						                    <div>
						                        <span>Removal Instructions: </span>
						                        <p><?php echo the_field('removal_instructions') ?></p>
						                    </div>
				                    <?php } ?>
									<?php if (get_post_custom_values( 'sign_down_reason')) { ?>
						                    <div>
						                        <span>Removal Reason: </span>
												<?php $removal_values = get_post_custom_values( 'sign_down_reason');
												echo '<ul>';
												foreach ( $removal_values as $values => $value ) {
													echo '<li>' . $value . '</li>';
												}
												echo '</ul>';
						                        ?>
						                    </div>
				                    <?php } ?>
									<?php if (get_field('fix_date')) { ?>
						                    <div>
						                        <span>Date to be Fixed: </span> <?php echo get_field('fix_date'); ?>
						                    </div>
				                    <?php } ?>
									<?php if (get_field('fix_instructions')) { ?>
						                    <div>
						                        <span>Special Fix Instructions: </span>
						                        <p><?php echo the_field('fix_instructions') ?></p>
						                    </div>
				                    <?php } ?>
				                    <?php if (get_post_custom_values( 'fix_reasons')) { ?>
						                    <div>
						                        <span>Details of Sign Repair Needed: </span>
												<?php $fix_values = get_post_custom_values( 'fix_reasons');
												echo '<ul>';
												foreach ( $fix_values as $values => $value ) {
													echo '<li>' . $value . '</li>';
												}
												echo '</ul>';
						                        ?>
						                    </div>
				                    <?php } ?>
				                    <?php if (get_field('other_fix_details')) { ?>
				                    <div>
				                        <span>Other Fix Instructions: </span>
				                        <p><?php echo the_field('other_fix_details'); ?></p>
				                    </div>
				                    <?php } ?>

									<?php
									if (!empty($_GET['order_accessories'])) {
										$edit_page_id = 37;
										do_action( 'gform_update_post/edit_link', array(
											'post_id' => $post->ID,
											'url' => home_url('/edit-sign/?order_accessories=yes'),
											'text' => 'Order Accessories'
										) );
									}
									else if (!empty($_GET['sign_status']) == 'fix') {
										$edit_page_id = 37;
										do_action( 'gform_update_post/edit_link', array(
											'post_id' => $post->ID,
											'url' => home_url('/edit-sign/?sign_status=fix'),
											'text' => 'Order Sign Fix'
										) );
									}
									else if (!empty($_GET['sign_status']) == 'down') {
										$edit_page_id = 37;
										do_action( 'gform_update_post/edit_link', array(
											'post_id' => $post->ID,
											'url' => home_url('/edit-sign/?sign_status=down'),
											'text' => 'Order Sign Down'
										) );
									}
									else {
										$edit_page_id = 37;
										$edit_link = explode('/', $_SERVER['REQUEST_URI']);
										?>

										<a class="gform_update_post_link" href="http://<?php echo $_SERVER['HTTP_HOST']?>/<?php echo $edit_link[1]?>/edit-sign/?gform_post_id=<?=$post->ID?>" title="Edit Sign">Edit Sign</a>
										<?php /* do_action( 'gform_update_post/edit_link', array(
											'post_id' => $post->ID,
											'url' => home_url('/edit-sign/'),
											'text' => 'Edit Sign'
										) );*/
									}

											wp_link_pages( array(
						                      'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'bonestheme' ) . '</span>',
						                      'after'       => '</div>',
						                      'link_before' => '<span>',
						                      'link_after'  => '</span>',
						                    ) );
						                  ?>
						                  </div>
						                </section> <?php // end article section ?>
						              </article> <?php // end article ?>
								<?php // endwhile;?>

						<?php else : ?>

							<article id="post-not-found" class="hentry cf">
									<header class="article-header">
										<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
									</header>
									<section class="entry-content">
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
									</section>
									<footer class="article-footer">
											<p><?php _e( 'This is the error message in the single.php template.', 'bonestheme' ); ?></p>
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
