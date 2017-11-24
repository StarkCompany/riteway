<?php
/*
**Edit Sign Page
*/
?>
<?php get_header(); ?>
			<div id="content" class="wrap cf">

				<div id="inner-content" class="cf">
                <?php if ( is_user_logged_in() ) { ?>

						<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">
							<?php if (have_posts()) :
								while (have_posts()) :
									the_post();
				?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">
									<h1 class="page-title" itemprop="headline">
										<span>
											<?php the_title(); ?> 
											<?php if ($_GET['order_accessories']) {	echo ' Accessories'; } ?>
											<?php if ($_GET['sign_status'] == 'fix') { echo ' Fix'; } ?>
											<?php if ($_GET['sign_status'] == 'down') {	echo ' Down'; } ?>&nbsp;at address:
										</span>
									<?php
										$post_id = $_GET['gform_post_id'];
										$queried_post = get_post($post_id);
										$address = $queried_post->post_title;
										echo $address;
									?>
									</h1>

								</header> <?php // end article header ?>

								<section class="entry-content cf <?php if ($_GET['order_accessories']) { echo 'sign-more-accessories'; } ?>" itemprop="articleBody">
                                    <div class="sign-data">
                                    	<?php
										$post_id = $_GET['gform_post_id'];
										$queried_post = get_post($post_id);
										$realtor = $queried_post->post_author;
										$address = $queried_post->post_title;
										$city = get_post_meta($post_id, 'city', false);
										$other_city = get_post_meta($post_id, 'other_city', false);
										$quadrant = get_post_meta($post_id, 'quadrant', false);
										$install_date = get_post_meta($post_id, 'install_date', false);

										?>
											<ul>
                                            	<li><span>Realtor: </span>
                                            		<span id='realtor' style="font-weight:normal;"><?php

                                            			the_author_meta( 'first_name' , $realtor );
                                            			echo ' ';
                                            			the_author_meta( 'last_name' , $realtor);
                                            			?>
                                            		</span>	
                                            	</li>
                                                <li><span>Address: </span><?php echo $address; ?></li>
                                                <li><span>City: </span><?php
												if ($city == 'Other') {
													echo $other_city;
												}
												else {
													echo end($city);
												} ?></li>
                                                <li><span>Quadrant: </span><?php echo end($quadrant); ?></li>
                                            </ul>
										<?php ?>
                                    </div>
									<?php
										// the content (pretty self explanatory huh)
										the_content();
										do_action('gform_pre_render_2', 'populate_posts');
										add_filter('gform_update_post/public_edit', '__return_true');
										do_action('gform_update_post/setup_form');
										gravity_form(1);

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
<script>
        jQuery(document).ready(function($) {

        	<? if($city == 'Imported'){ ?>
        		$('#field_1_4').removeClass('status-up').addClass('status-fix');
        		$('#field_1_8').removeClass('status-up').addClass('status-fix');
				$('#field_1_4').css('display', 'block', '!important');
				$('#field_1_8').css('display', 'block', '!important');
				$('#input_1_4').append($('<option>', {
					    value: 'Imported',
					    text: 'Imported'
					}));
				$('#input_1_8').append($('<option>', {
					    value: 'IM',
					    text: 'IM'
					}));
        	<?}?>

			if ($('#input_1_3').length) {
	        	$('#input_1_3').val(<?php echo $realtor?>);
	        	$(function(){
	   				if ($('body').is('.page-id-37')) {
						var theText = '<?php echo $blog_title;?>';
						$("#field_1_34 option:contains(" + theText + ")").attr('selected', 'selected');
	  				 }
				});
			}else{
				$('#realtor').text('<?php the_author_meta( "first_name" , $last_realtor_id );?>'+ ' ' + '<?php the_author_meta( "last_name" , $last_realtor_id );?>');
			}	
        });
</script> 	
