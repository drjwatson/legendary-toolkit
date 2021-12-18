<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>


<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header();
?>
			<div class="wrapper">
				<div class="page-content-cover">
					<section class="not-found-cover" style="text-align:center;">
						<header class="page-header">
							<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'wp-bootstrap-starter' ); ?></h1>
						</header><!-- .page-header -->
						<!-- <p style="text-align:center;padding:80px 20px;">Sorry, that page was not found, please use the main navigation to find what you're looking for...</p> -->
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'wp-bootstrap-starter' ); ?></p>

						<?php
							get_search_form();
						?>
						
					</section>
				</div>
			</div>


<?php
// get_sidebar();
get_footer();
