<?php 

/**
 * theme template hooks
 *
 * @package superfit
 */

/**
 * Meta Tags
 */
function superfit_entry_meta(){

    $byline = sprintf(

        esc_html( '%s', 'superfit' ),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
    );

    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf( $time_string,
        get_the_date( DATE_W3C ),
        get_the_date(),
        get_the_modified_date( DATE_W3C ),
        get_the_modified_date()
    );

    $get_category_list = get_the_category_list( __( ', ', 'superfit' ) );
    $cat_list = sprintf( esc_html('%s', 'superfit'),
    $get_category_list
    );

    echo '<span class="posted-on">' . $time_string . '</span>'. $byline .'</span><span class="cat-list">'. $cat_list .'</span>';
}

function superfit_entry_meta_blog(){


    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf( $time_string,
        get_the_date( DATE_W3C ),
        get_the_date(),
        get_the_modified_date( DATE_W3C ),
        get_the_modified_date()
    );

    $get_category_list = get_the_category_list( __( ', ', 'superfit' ) );
    $cat_list = sprintf( esc_html('%s', 'superfit'),
    $get_category_list
    );

    echo '<span class="posted-on">' . $time_string . '</span><h1><a href="'. esc_url( get_permalink() ) .'">'. esc_html( get_the_title() ) .'</a></h1><span class="cat-list">'. $cat_list .'</span>';
}


add_action( 'superfit_entry_footer', 'superfit_post_cat', 10 );
add_action( 'superfit_entry_footer', 'superfit_next_prev_post', 15 );
add_action( 'superfit_entry_footer', 'superfit_author_bio', 20 );

function superfit_post_cat(){ 

    $get_category_list = get_the_category_list( __( ', ', 'superfit' ) );
    $cat_list = sprintf( esc_html('%s', 'superfit'),
    $get_category_list
    );

    ?>
    <div class="cat-tag-links">
        <?php if(has_tag()): ?>
        <p><i class="fa fa-tag" aria-hidden="true"></i><?php echo ' ' . get_the_tag_list('','',''); ?></p>
        <?php endif; ?>
    </div>
    <?php
}

function superfit_author_bio(){ ?>
    <div class="author-info">
      <div class="avatar">
        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ) , 100 ); ?></a>
      </div>
      <div class="info">
          <p class="author-name"><span><?php _e('Published By ','superfit'); ?></span><br><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a></p>
          <?php echo get_the_author_meta('description'); ?>
      </div>
      <span class="clearfix"></span>
    </div> 
    <?php
}

function superfit_next_prev_post(){
    ?>
        <div class="next-prev-post">
            <div class="prev col-xs-6">
                <span><?php esc_html_e('Previous','superfit'); ?></span><br>
                <?php previous_post_link('&larr; %link'); ?>
            </div>
            <div class="next col-xs-6">
                <span><?php esc_html_e('Next','superfit'); ?></span><br>
                <?php next_post_link('%link &rarr;'); ?>
            </div>
            <span class="clearfix"></span>
        </div>
    <?php
}

/**
 * site header
 */
add_action( 'superfit_header', 'superfit_template_header' );
function superfit_template_header(){ ?>
    <header id="site-header">
        <div class="top-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 important-info">
                        <?php superfit_template_important_info(); ?>
                    </div>
                    <div class="col-md-6">
                        <a href="#" class="search-btn" data-toggle="modal" data-target="#searchmodal"><span class="fa fa-search"></span></a>
                        <?php 
                        
                        if ( has_nav_menu( 'social-nav' ) ) { ?>
                        <nav class="social-navigation" role="navigation" aria-label="<?php _e( 'Social Links Menu', 'superfit' ); ?>">
                            <?php
                
                            $menuParameters = array(
                              'theme_location' => 'social-nav',
                              'depth'           => 1,
                              'fallback_cb'     => false,
                              'link_before'    => '<span class="screen-reader-text">',
                              'link_after'     => '</span>' . superfit_get_svg( array( 'icon' => 'chain' ) ),
                            );

                            wp_nav_menu( $menuParameters );
                            ?>
                        </nav><!-- .social-navigation -->
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <nav class="navbar navbar-default" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navigation">
                    <span class="sr-only"><?php _e( 'Toggle navigation','superfit' ); ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>

                    <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ): 
                    ?>
                    <h1 id="logo"><?php the_custom_logo(); ?></h1>
                    <?php else : ?>
                    <h1 id="logo"><a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><?php echo esc_html( bloginfo('name') ); ?></a></h1>
                    <?php endif; ?>

                </div>

                <div class="collapse navbar-collapse" id="main-navigation">
                    <?php 
                    if ( has_nav_menu( 'main-nav' ) ) {
                    wp_nav_menu( array(
                    'theme_location'    => 'main-nav',
                    'depth'             => 5,
                    'container'         => 'false',
                    'container_class'   => 'collapse navbar-collapse',
                    'container_id'      => 'bs-navbar-collapse-1',
                    'menu_class'        => 'nav navbar-nav navbar-right',
                    'fallback_cb'       => 'superfit_primary_menu_fallback',
                    'walker'            => new wp_bootstrap_navwalker())
                    );
                    }
                    ?>
                </div><!-- /.navbar-collapse -->
            </nav>
        </div>
    </header>
<?php
}


/**
 * Footer Hooks
 */
add_action( 'superfit_footer', 'superfit_template_copyright', 10 );


function superfit_template_copyright(){ ?>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ): 
                ?>
                <h1 id="logo"><?php the_custom_logo(); ?></h1>
                <?php else : ?>
                <h1 id="logo"><a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><?php echo esc_html( bloginfo('name') ); ?></a></h1>
                <?php endif; ?>
            </div>
            <div class="col-md-9 footer-copyright">
                <?php echo bloginfo( 'name' ) . ' ' . '&#169; ' . __('copyright','superfit') . ' ' . date_i18n('Y');  ?>
                <span><?php if(is_home() || is_front_page()): ?>
                    <br><?php esc_html_e('Built with','superfit'); ?> <a href="<?php echo esc_url( __( 'https://wpdevshed.com/themes/superfit/', 'superfit' ) ); ?>"><?php printf( esc_html( '%s', 'superfit' ), 'Superfit' ); ?></a>     <span><?php _e('and','superfit'); ?></span> <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'superfit' ) ); ?>"><?php printf( esc_html( '%s', 'superfit' ), 'WordPress' ); ?></a>
                <?php endif; ?>
                </span>
            </div>
        </div>
    </div>
    <div class="modal fade" id="searchmodal" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><?php esc_html_e('Search For','superfit'); ?></h4>
            </div>
            <div class="modal-body">
              <?php echo get_search_form(); ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn" data-dismiss="modal"><?php esc_html_e('Close','superfit'); ?></button>
            </div>
          </div>
          
        </div>
      </div>
<?php
}

/**
 * Site information
 */
function superfit_template_important_info(){ 

    if(shortcode_exists( 'contact_details' )){

    $location   = strip_tags( do_shortcode('[contact_details format="horizontal" fields="address"]') );
    $phone      = strip_tags( do_shortcode('[contact_details format="horizontal" fields="phone"]') );
    $email      = strip_tags( do_shortcode('[contact_details format="horizontal" fields="email"]') );

    ?>
    <?php if( $location || $phone || $email ){ ?>
    
        <p><?php echo '<span class="fa fa-map-marker "></span>' . esc_html( $location ); ?></p>
        <p><?php echo '<span class="fa fa-phone"></span>' . esc_html( $phone ); ?></p>
        <p><?php echo '<span class="fa fa-envelope"></span>' . esc_html( $email ); ?></p>

    <?php } ?>
<?php
    }
}

/**
 * Homepage Sections
 */

add_action( 'superfit_home', 'superfit_template_section_1', 10 );
add_action( 'superfit_home', 'superfit_template_section_2', 20 );
add_action( 'superfit_home', 'superfit_template_section_3', 30 );
add_action( 'superfit_home', 'superfit_template_section_4', 40 );
add_action( 'superfit_home', 'superfit_instagram_feed', 50 );

function superfit_template_section_1(){

        $get_sec_1_id = get_theme_mod( 'superfit_section_1' );
        $post_1 = get_post( $get_sec_1_id );
        $thumb_url_1 = wp_get_attachment_url( get_post_thumbnail_id($get_sec_1_id) );
        $content_1 = apply_filters('the_content', $post_1->post_content);

        if( $get_sec_1_id ) :
    ?>
        <section id="section-1" class="home-sec" style="<?php if( $thumb_url_1 ) { ?> background-image: url( <?php echo esc_url( $thumb_url_1 ); ?> ); <?php } ?>">
            <div class="section-content container">
                <?php echo $content_1; ?>
            </div>
            <span class="clearfix"></span>
        </section>
    <?php endif;

}

function superfit_template_section_2(){

        $get_sec_2_id = get_theme_mod( 'superfit_section_2' );
        $post_2 = get_post( $get_sec_2_id );
        $content_2 = apply_filters('the_content', $post_2->post_content);

        if( $get_sec_2_id ) :
    ?>
        <section id="section-2" class="home-sec">
            <div class="section-content container">
                <?php echo $content_2; ?>
            </div>
            <span class="clearfix"></span>
        </section>
    <?php endif;

}

function superfit_template_section_3(){

        $get_sec_3_id = get_theme_mod( 'superfit_section_3' );
        $post_3 = get_post( $get_sec_3_id );
        $thumb_url_3 = wp_get_attachment_url( get_post_thumbnail_id($get_sec_3_id) );
        $content_3 = apply_filters('the_content', $post_3->post_content);

        if( $get_sec_3_id ) :
    ?>
        <section id="section-3" class="home-sec" style="<?php if( $thumb_url_3 ) { ?> background-image: url( <?php echo esc_url( $thumb_url_3 ); ?> ); <?php } ?>">
            <div class="section-content container">
                <div class="row">
                    <div class="col-md-6 pull-right">
                        <?php echo $content_3; ?>
                    </div>
                </div>
            </div>
            <span class="clearfix"></span>
        </section>
    <?php endif;

}

function superfit_template_section_4(){ ?>

    <section id="section-4" class="home-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12"><h3 class="section-title"><?php esc_html_e('Latest Posts','superfit'); ?></h3></div>
                <?php 
                query_posts( array( 'posts_per_page' => 3, 'post_type' => 'post' ) );
                while ( have_posts() ) : the_post(); ?>
                <div class="col-xs-12 col-sm-6 col-md-4 blog-item">
                    <?php get_template_part( 'contents/content', 'blog' ); ?>
                </div>
                <?php endwhile; wp_reset_postdata(); $view_more = get_theme_mod('superfit_view_more'); ?>
                <?php if(!empty($view_more)) { ?><div class="col-md-12 view-more"><a href="<?php echo esc_url( $view_more ); ?>" class="btn"><?php esc_html_e('Read More Blogs','superfit'); ?></a></div><?php } ?>
            </div>
        </div>
    </section>

    <?php
}

function superfit_instagram_feed() {

    if ( shortcode_exists( 'instagram-feed' ) ) { ?>
    <div class="home-feed">
        <div class="container">
            <h3 class="sec-title"><?php esc_html_e('instagram Feed','superfit'); ?></h3>
            <?php echo do_shortcode('[instagram-feed num=8 cols=4 imagepadding=10 showheader=false  showfollow=false]'); ?>
        </div>
    </div>
    <?php } 

}