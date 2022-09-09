<?php 
    $logo = legendary_toolkit_get_theme_option('logo');
    if (array_key_exists('type', $args) && $args['type'] == 'scrolling') {
        $logo = legendary_toolkit_get_theme_option('scrolling_logo');
    }
    $logo_url = ($logo) ? esc_url(wp_get_attachment_image_url($logo, 'medium')) : '';
    $id = array_key_exists('id', $args) ? $args['id'] : '';
    $class = (array_key_exists('class', $args)) ? $args['class'] : '';
    if ( $logo ): ?>
        <a href="<?=esc_url( home_url( '/' )); ?>">
            <img class="<?=$class;?>" id="<?=$id;?>" src="<?=$logo_url; ?>" alt="<?=esc_attr( get_bloginfo( 'name' ) ); ?>">
        </a>
    <?php else : ?>
        <a class="site-title" href="<?=esc_url( home_url( '/' )); ?>"><?php esc_url(bloginfo('name')); ?></a>
    <?php endif; ?>