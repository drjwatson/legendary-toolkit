<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<div class="zoom-container">
	<div class="post-thumbnail zoom-image" style="background:url('<?php echo the_post_thumbnail_url('full');?>');background-size:cover;height:75vh;background-position:center center;">
	</div>
</div>

<style>
.single-post .container.content-item {
  border: 6px solid white;
  box-shadow: 0px 1px 8px rgb(0 0 0 / 25%);
  position:relative;
  top:-100px;
  background:white;
  padding:0 40px;

}

.single-post article p img {
  border: 6px solid white;
  box-shadow: 0px 1px 8px rgb(0 0 0 / 25%);
}

.single-post section#primary{
  padding:0;
}

.zoom-container{
  overflow:hidden;
}

.zoom-image {
    transform: scale(1); /* Start slightly zoomed in */
    transition: transform linear;
    transform-origin: center;
}

html {
  scroll-behavior: smooth !important;
}


</style>


<script>
function lerp(start, end, amount) {
    return (1 - amount) * start + amount * end;
}

var targetScroll = 0;
var currentScroll = 0;
var lerpAmount = 0.1; // Adjust this for smoother or quicker transitions

function updateScroll() {
    targetScroll = window.scrollY;
    requestAnimationFrame(animate);
}

function animate() {
    currentScroll = lerp(currentScroll, targetScroll, lerpAmount);

    // Calculate scale and opacity based on scroll
    var divHeight = document.querySelector('.zoom-container').offsetHeight;
    var scale = 1 + (currentScroll / divHeight) * 0.3; // Zooms in as you scroll
    var opacity = 1 - (currentScroll / divHeight); // Fades out as you scroll

    // Apply scale and opacity
    var image = document.querySelector('.zoom-image');
    image.style.transform = 'scale(' + scale + ')';
    image.style.opacity = opacity;

    // Continue the animation as long as there's a noticeable difference
    if (Math.abs(currentScroll - targetScroll) > 0.5) {
        requestAnimationFrame(animate);
    }
}

window.addEventListener('scroll', updateScroll);


document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    document.querySelector(this.getAttribute('href')).scrollIntoView({
      behavior: 'smooth'
    });
  });
});

</script>



<div class="container content-item">
	<?php if(has_post_thumbnail()):?>
	
	<?php endif;?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php wp_bootstrap_starter_posted_on(); ?>
				<div class="post-categories">Categories: <?php the_category(', '); ?> </div>
			</div><!-- .entry-meta -->
			<?php
			endif; ?>
		</header><!-- .entry-header -->
		<div class="entry-content">
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