<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package superfit
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="page-title-area">
        <?php $thumb_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_id() ) ); ?>
        <a href="<?php the_permalink(); ?>" class="featured-img" style="background-image: url( <?php echo esc_url( $thumb_url ); ?> );"><?php if(has_post_thumbnail()){the_post_thumbnail('full');}else{ the_title(); } ?></a>
    </div>
    <div class="entry-meta-blog">
        <?php superfit_entry_meta_blog(); ?>
    </div>
</article><!-- #post-## -->