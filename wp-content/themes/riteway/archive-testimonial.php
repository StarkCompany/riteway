<?php
/*
 * CUSTOM POST TYPE ARCHIVE TEMPLATE
 *
 * This is the custom post type archive template. If you edit the custom post type name,
 * you've got to change the name of this template to reflect that name change.
 *
 * For Example, if your custom post type is called "register_post_type( 'bookmarks')",
 * then your template name should be archive-bookmarks.php
 *
 * For more info: http://codex.wordpress.org/Post_Type_Templates
*/
?>

<?php get_header(); ?>

			<div id="content" class="wrap cf">

				<div id="inner-content" class="cf">

						<div id="main" class="m-all t-5of5 d-5of5 cf" role="main">

								<header class="archive-header">
									<h1 class="page-title"><?php post_type_archive_title(); ?></h1>
								</header>

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

								<section class="entry-content cf">

									<div class="testimonial-image m-all t-1of5 d-1of5">
										<?php 
                                        $image = get_field('testimonial_image');
                                        $size = 'testimonial-image'; // (thumbnail, medium, large, testimonial-image full or custom size)
                                        if( $image ) {
                                            echo wp_get_attachment_image( $image, $size );
                                        } ?>
                                    </div>
                                    <div class="testimonial-content m-all t-4of5 d-4of5">
										<?php the_content(); ?>
                                        <div class="realtor-image">
											<?php 
                                            $image = get_field('realtor_logo');
                                            $size = 'realtor-logo'; // (thumbnail, medium, large, full or custom size)
                                            if( $image ) {
                                                echo wp_get_attachment_image( $image, $size );
                                            } ?>
                                        </div>
                                    </div>

								</section>

								<footer class="article-footer">

								</footer>

							</article>

							<?php endwhile; ?>


							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the custom posty type archive template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>

				</div>

			</div>

<?php get_footer(); ?>
