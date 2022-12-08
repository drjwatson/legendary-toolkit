<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); 
$archive_layout = legendary_toolkit_get_theme_option('archive_layout');
?>

	<section id="primary" class="content-area col-sm-12 <?=toolkit_get_primary_column_classes();?>">
		<div id="main" class="site-main" role="main">
		<?php
		if ( have_posts() ) {
			$layout_classes = ($archive_layout) ? 'archive-wrapper-' . $archive_layout : '';
			echo "<div class='$layout_classes'>";
			while ( have_posts() ) : the_post();
				if ($archive_layout) {
					get_template_part( 'template-parts/content', $archive_layout );	
				}
				else {
					get_template_part( 'template-parts/content', get_post_format() );
				}
			endwhile;
			echo "</div>";
			the_posts_pagination();
		}
		else {
			get_template_part( 'template-parts/content', 'none' );
		}
		?>

		</div><!-- #main -->
	</section><!-- #primary -->
<?php
get_sidebar();
get_footer();

