<?php
/**
 * The main template file.
 *
 *
 * @package superfit
 */

get_header(); ?>


<div class="page-title-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="page-title"><?php esc_html_e('Blog','superfit'); ?></h1>
            </div>
            <?php if(function_exists('bcn_display')){ ?>
                <div class="col-sm-6 breadcrumbs">
                    <?php bcn_display(); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <?php 
            $clear = 1; 
            while ( have_posts() ) : the_post(); ?>
                
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
            endwhile; ?>

        <div class="pagination">
            <?php the_posts_pagination(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>