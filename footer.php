<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

	$theme_options = legendary_toolkit_get_theme_options();
	$footer_column_count = intval($theme_options['footer_columns']);
	$footer_column_class = ($footer_column_count) ? 'col-sm-' . 12 / $footer_column_count : 'col-sm-12';
?>
<?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #content -->
	<div id="footer">
    <?php get_template_part( 'footer-widget' ); ?>
	<?php if ($footer_column_count) : ?>
		<section>
			<div class="container">
				<div class="row">
					<?php for ($i=0; $i < $footer_column_count; $i++) : ?>
						<div class="<?php echo $footer_column_class;?>" id="footer_column_<?php echo $i+1;?>">
							<?php echo $theme_options['footer_column_'. ($i + 1) ];?>
						</div>
					<?php endfor;?>
				</div>
			</div>
		</section>
	<?php endif;?>
	<footer id="colophon" class="site-footer <?php echo wp_bootstrap_starter_bg_class(); ?>" role="contentinfo">
		<div class="container pt-3 pb-3">
            <div class="site-info">
			<?php if($theme_options['footer_bottom_content']):?>
				<div class="footer-bottom-content">
					<?php echo $theme_options['footer_bottom_content'];?>
				</div>
			<?php endif; ?>
            </div><!-- close .site-info -->
		</div>
	</footer><!-- #colophon -->


	</div><!--#footer-->
<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>