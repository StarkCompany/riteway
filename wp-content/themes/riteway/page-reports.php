<?php
/*
 Template Name: Report Pages
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
                    <div id="main" class="m-all t-all d-all cf" role="main">
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
                                <section class="report">

                                <?php if (is_page('2')) {
                                    include('reports/signs-up.php');
                                } ?>

                                <?php if (is_page('249')) {
                                    include('reports/signs-down.php');
                                } ?>

                                <?php if (is_page('263')) {
                                    include('reports/signs-renewals.php');
                                } ?>

                                <?php if (is_page('266')) {
                                    include('reports/signs-accessories.php');
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
				</div>
			</div>


<?php get_footer(); ?>
