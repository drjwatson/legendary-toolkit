<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */
$theme_options = legendary_toolkit_get_theme_options();
$show_sidebar_archive = (array_key_exists('show_sidebar_archive', $theme_options) && $theme_options['show_sidebar_archive']) ? $theme_options['show_sidebar_archive'] : false;
$container_column_class = ($show_sidebar_archive) ? 'col-lg-8' : 'col-lg-12';
get_header(); ?>

	<section id="primary" class="content-area col-sm-12 <?=$container_column_class;?>">
		<div id="main" class="site-main" role="main">

		<?php
		// echo $show_sidebar_archive;
		if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</div><!-- #main -->
	</section><!-- #primary -->

<?php
if ($show_sidebar_archive) {
	get_sidebar();
}

get_footer();
