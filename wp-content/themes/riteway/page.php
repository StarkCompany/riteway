<?php get_header(); ?>

			<div id="content" class="wrap cf">
				<div id="inner-content" class="cf">
						<div id="main" class="m-all t-4of5 d-4of5 cf" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">
									<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
								</header> <?php // end article header ?>

								<section class="entry-content cf" itemprop="articleBody">
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
                                    
                                    
                                    <?php if (is_page('14')) { ?>

										<?php $loop = new WP_Query( array( 'post_type' => 'sign' ) ); ?>
                                        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                        <div class="sign-row row">
											<?php if(get_field('sign_images')): ?>
                                                <div class="sign-images m-1of4 t-1of4 d-1of4">
                                                    <div id="slider-<?php echo get_the_ID(); ?>" class="nivoSlider">
                                                        <?php while(has_sub_field('sign_images')): ?>
                                                            <?php 
                                                            $image = get_sub_field('sign_image');
                                                            $size = 'small';
                                                            if( $image ) {
                                                                echo wp_get_attachment_image( $image, $size );
                                                            } ?>
                                                        <?php endwhile; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class=" sign-content m-3of4 t-3of4 d-3of4">
                                                <h3><?php the_title(); ?></h3>
                                                <?php the_content(); ?>
                                            </div>
                                        </div>
                                        
                                        <?php endwhile; wp_reset_query(); ?>

									<?php } ?>
                                    
								<?php if (is_page('12')) { ?>
                                    <?php $loop = new WP_Query( array( 'post_type' => 'testimonial' ) ); ?>
                                    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                    <div class="testimonial-row row">
                                        <?php if(get_field('testimonial_image')): ?>
                                        <div class="testimonial-image m-1of5 t-1of5 d-1of5">
                                            <?php 
                                            $image = get_field('testimonial_image');
                                            $size = 'small';
                                            if( $image ) {
                                                echo wp_get_attachment_image( $image, $size );
                                            } ?>
                                        </div>
                                        <?php endif; ?>
                                        <div class="testimonial-content m-4of5 t-4of5 d-4of5">
                                            <?php the_content(); ?>
                                            <?php if(get_field('realtor_logo')): ?>
                                                <div class="realtor-image">
                                                    <?php 
                                                    $image = get_field('realtor_logo');
                                                    $size = '';
                                                    if( $image ) {
                                                        echo wp_get_attachment_image( $image, $size );
                                                    } ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <?php endwhile; wp_reset_query(); ?>

									<?php } ?>
                                           
								</section> <?php // end article section ?>
                                <?php if (is_page('16')) { ?> 
								<section>
                                	<h2>Returning Customers:</h2>
                                	<?php wp_login_form(); ?>
								</section>
								<?php } ?>
                                <?php if (is_page('18')) { ?> 
								<section>
                                	<h2>Returning Customers:</h2>
                                	<?php wp_login_form(); ?>
								</section>
								<?php } ?>
                                <?php if (is_page('20')) { ?> 
								<section>
                                	<h2>Returning Customers:</h2>
                                	<?php wp_login_form(); ?>
								</section>
								<?php } ?>

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

				</div>

			</div>

<?php get_footer(); ?>
