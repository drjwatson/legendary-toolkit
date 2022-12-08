<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

add_filter( 'excerpt_more', 'toolkit_excerpt_more_grid' ); 
?>

<div class="content-item archive-layout-grid-item">
	<a href="<?=get_the_permalink();?>">
		<div class="blog-img">
			<div class="post-thumbnail">
				<?php if(has_post_thumbnail()):?>
					<?php the_post_thumbnail(); ?>
				<?php endif;?>
			</div>
		</div>
	</a>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php 
            $tag_list = get_the_tag_list( '<ul class="tag-list"><li>', '</li><li>', '</li></ul>' );

            if ( $tag_list && ! is_wp_error( $tag_list ) ) {
                echo $tag_list;
            }
            ?>
            <div class="entry-meta"><?=get_the_date();?></div>
            <?php
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            ?>
		</header><!-- .entry-header -->
		<div class="entry-content">
			<?php
                $excerpt = get_the_excerpt();
				echo $excerpt;
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
        <div class="archive-entry-footer">
            <a class="read-more-link" href="<?=get_the_permalink();?>">Read More <i class="fa fa-long-arrow-alt-right"></i></a>
        </div>
		<footer class="entry-footer">
			<?php wp_bootstrap_starter_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</article><!-- #post-## -->
</div>