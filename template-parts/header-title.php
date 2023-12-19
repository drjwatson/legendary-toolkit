<?php 
$page_title = legendary_toolkit_get_theme_option('page_title');
$page_meta_title = esc_attr( get_post_meta( get_queried_object_ID(), 'll_page_title', true ) );
$page_title_content = legendary_toolkit_get_theme_option('page_title_content');
$single_layout = legendary_toolkit_get_theme_option('single_layout');
$tag_list = get_the_tag_list( '<ul class="tag-list"><li>', '</li><li>', '</li></ul>' );

if ($page_title && !is_front_page() && $page_meta_title != 'title_off' && !is_single()) : ?>
    <div id="page_title">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php 
                    echo do_shortcode($page_title_content);
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
<?php if (is_single() && $single_layout == 'single-modern') : 
    $title_background_color = legendary_toolkit_get_theme_option('blog_header_background');    
    $title_background_color = legendary_toolkit_get_theme_option('blog_header_content_color');
    $title_container_class = (toolkit_get_sidebar_selection()) ? 'container-fluid' : 'container';
?>
    <div id="page_title" class="title-single-modern">
        <div class="<?=$title_container_class;?>">
            <div class="row">
                <div class="<?=toolkit_get_primary_column_classes();?>">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-4">
                            <div class="pl-lg-4">
                                <h2><?php the_title() ; ?></h2>
                                <div class="entry-meta"><?=get_the_date();?></div>
                                <?php if ( $tag_list && ! is_wp_error( $tag_list ) ) { echo $tag_list; }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>