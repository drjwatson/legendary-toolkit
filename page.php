<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */
$sidebar = esc_attr( get_post_meta( get_the_ID(), 'll_page_sidebar', true ) );
$primary_column_class = (!$sidebar) ? 'col-md-12' : 'col-md-7';
$sidebar_position = esc_attr( get_post_meta( get_the_ID(), 'll_sidebar_position', true ) );
$primary_order_class = 'order-md-1';
$primary_offset = ($sidebar_position == 'right') ? 'offset-md-2': '';
$sidebar_order_class = 'order-md-2';
if ($sidebar_position == 'left') {
	$primary_order_class = 'order-md-2';
	$sidebar_order_class = 'order-md-1';
}
get_header(); ?>
<section id="primary" class="content-area <?=$primary_column_class;?> <?=$primary_order_class;?> <?=$primary_offset;?>">
	<div id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</div><!-- #main -->
</section><!-- #primary -->
<?php if ($sidebar && $sidebar_position) : ?>
	<section id="custom_sidebar" class="col-md-3 <?=$sidebar_order_class;?>">
		<?php echo do_shortcode("[custom_widget id=$sidebar]");?>
	</section>
<?php endif;?>
<?php
get_footer();