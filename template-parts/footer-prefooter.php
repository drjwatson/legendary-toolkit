<?php 
	$widget_id = toolkit_get_prefooter_selection();
    if ($widget_id) : ?>
        <section id="footer_pre_footer">
            <div class="container">
                <?php echo do_shortcode("[custom_widget id=$widget_id]");?>
            </div>
        </section>
    <?php endif;?>