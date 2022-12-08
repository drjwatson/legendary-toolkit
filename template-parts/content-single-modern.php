<div class="content-item single-layout-modern">
    <div class="row">
            <div class="col-lg-4">
                <div class="blog-img">
                    <?php if (get_the_post_thumbnail()):?>
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail(); ?>
                        </div>
                    <?php endif;?>
                    <?php get_template_part('template-parts/blog', 'share-buttons');?>
                </div>
            </div>
        <div class="col-lg-8">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-content pl-lg-4">
                    <?php
                    if ( is_single() ) :
                        the_content();
                    else :
                        the_excerpt();
                    endif;

                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
                            'after'  => '</div>',
                        ) );
                    ?>
                </div><!-- .entry-content -->

                <footer class="entry-footer">
                    <?php wp_bootstrap_starter_entry_footer(); ?>
                </footer><!-- .entry-footer -->
            </article><!-- #post-## -->
        </div>
    </div>
</div>