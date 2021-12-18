<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */
$theme_options = legendary_toolkit_get_theme_options();
$show_sidebar_single = (array_key_exists('show_sidebar_single', $theme_options) && $theme_options['show_sidebar_single']) ? $theme_options['show_sidebar_single'] : false;
$container_column_class = ($show_sidebar_single) ? 'col-lg-8' : 'col-lg-12';
get_header(); ?>

	<section id="primary" class="content-area col-sm-12 <?=$container_column_class;?>">
		<div id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );

			    the_post_navigation();
				?><div class="widget_shopping_cart_content"><?php
				// woocommerce_mini_cart();
				?></div><?php

		endwhile; // End of the loop.
		?>

		</div><!-- #main -->
	</section><!-- #primary -->

<?php
if ($show_sidebar_single) {
	get_sidebar();
}
get_footer();
