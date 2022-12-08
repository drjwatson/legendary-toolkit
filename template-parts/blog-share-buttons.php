<?php 
/* Social Share Buttons template for Wordpress
 */ 

$post_url = 'http' . ( isset( $_SERVER['HTTPS'] ) ? 's' : '' ) . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$featured_image_url = get_the_post_thumbnail_url();

?>
<section class="sharing-box">
    <h5 class="sharing-box-label">SHARE: </h5>
    <div class="share-button-wrapper">
        <a target="_blank" class="share-button share-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $post_url; ?>" title="Share on Facebook"><i class="fab fa-facebook"></i></a>
        <a target="_blank" class="share-button share-twitter" href="https://twitter.com/intent/tweet?url=<?php echo $post_url; ?>&text=<?php echo the_title(); ?>&via=<?php the_author_meta( 'twitter' ); ?>" title="Tweet this"><i class="fab fa-twitter"></i></a>
        <a target="_blank" class="share-button share-pinterest" href="https://pinterest.com/pin/create/link/?url=<?=$post_url;?>&media=<?=$featured_image_url;?>" title="Pin This"><i class="fab fa-pinterest"></i></a>
        <a data-toggle="tooltip" onclick="copyToClipboard('<?=$post_url;?>', this)" class="share-button share-copy" href="#" title="Copy Link"><i class="fa fa-copy"></i></a>
    </div>
</section>
<script>
    const unsecuredCopyToClipboard = (text) => { const textArea = document.createElement("textarea"); textArea.value=text; document.body.appendChild(textArea); textArea.focus();textArea.select(); try{document.execCommand('copy')}catch(err){console.error('Unable to copy to clipboard',err)}document.body.removeChild(textArea)};

    /**
     * Copies the text passed as param to the system clipboard
     * Check if using HTTPS and navigator.clipboard is available
     * Then uses standard clipboard API, otherwise uses fallback
    */
    const copyToClipboard = (content, el) => {
        if (window.isSecureContext && navigator.clipboard) {
            navigator.clipboard.writeText(content);
        } else {
            unsecuredCopyToClipboard(content);
        }
        jQuery(el).attr('title', 'Copied').tooltip('_fixTitle').tooltip('show');
    };
</script>