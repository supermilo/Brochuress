<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package superfit
 */

get_header(); ?>

<div class="page-title-area">
    <div class="container">
        <h1 class="page-title"><?php _e('404','superfit'); ?></h1>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-title"><?php esc_html_e( 'Not Found', 'superfit' ); ?></h1>
            <p>
            <?php _e( 'The article you were looking for was not found. You may want to check your link or perhaps that page does not exist anymore. Maybe try a search?', 'superfit' ); ?>
            </p>
            <?php get_search_form(); ?>
        </div>

        <?php get_sidebar(); ?>

    </div>
</div>

<?php get_footer(); ?>