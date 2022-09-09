<?php 
    $favicon = esc_url(wp_get_attachment_image_url(legendary_toolkit_get_theme_option('favicon'), 'medium'));
?>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
    <?php if ( $favicon ) : ?>
        <link rel="shortcut icon" href="<?=$favicon;?>" />
    <?php endif;?>
</head>