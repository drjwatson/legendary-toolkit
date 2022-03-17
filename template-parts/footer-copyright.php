<?php
    $footer_bottom_content = legendary_toolkit_get_theme_option('footer_content_bottom');
    if($footer_bottom_content):
?>
<footer id="colophon" class="site-footer <?php echo wp_bootstrap_starter_bg_class(); ?>" role="contentinfo">
    <div class="container pt-3 pb-3">
        <div class="site-info">
            <div class="footer-bottom-content">
                <?php echo wpautop($footer_bottom_content);?>
            </div>
        </div><!-- close .site-info -->
    </div>
</footer><!-- #colophon -->
<?php endif; ?>