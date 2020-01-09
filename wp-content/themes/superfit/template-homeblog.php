<?php
/**
 * Template Name: Blog Homepage
 *
 *
 * @package superfit
 */


get_header();  

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 1,
    'post__in'  => get_option( 'sticky_posts' ),
    'ignore_sticky_posts' => 1
);
$posts = new WP_Query( $args ); while ( $posts -> have_posts() ) : $posts -> the_post(); 
$thumb_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_id() ) ); ?>
<div class="home-banner" style="background-image: url( <?php echo esc_url( $thumb_url ); ?> );">
    <div class="container">
        <h1 class="home-banner-title"><?php the_title(); ?></h1>
        <p class="home-banner-meta"><?php superfit_entry_meta(); ?></p>
        <a href="<?php the_permalink(); ?>" class="btn"><?php esc_html_e('Read More','superfit'); ?></a>
    </div>
</div>
<?php endwhile;  wp_reset_query(); ?>

<div class="home-blog">
    <div class="container">
        <h3 class="sec-title"><?php esc_html_e('Latest Posts','superfit'); ?></h3>
        <div class="row">
            <?php 
                $clear = 1; 
                $args= array('post_type' => 'post' ,'post__not_in' => get_option( 'sticky_posts' ) ,'posts_per_page' => 6 );
                $posts = new WP_Query( $args );
                while ( $posts -> have_posts() ) : $posts -> the_post(); ?>
                    
                    <div class="col-xs-12 col-sm-6 col-md-4 blog-item">
                        <?php get_template_part( 'contents/content', 'blog' ); ?>
                    </div>

                <?php 
                    if($clear%3 == 0){
                        echo '<span class="clearfix clear-1"></span>';
                    }
                    if($clear%2 == 0){
                        echo '<span class="clearfix clear-2"></span>';
                    }
                    $clear++;
                endwhile; wp_reset_query(); ?>
        </div>
        <div class="read-more-blogs">
            <?php $view_more = get_theme_mod('superfit_view_more'); 
            if(!empty($view_more)) { ?><div class="col-md-12 view-more"><a href="<?php echo esc_url( $view_more ); ?>" class="btn"><?php esc_html_e('Read More Blogs','superfit'); ?></a></div><?php } ?>
        </div>
    </div>
</div>

<?php superfit_instagram_feed();

get_footer(); ?>