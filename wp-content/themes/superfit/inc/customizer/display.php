<?php 

/**
 * Customizer Display
 *
 * @package superfit
 */

  function superfit_apply_color() {

    if( get_theme_mod('superfit_color_1') ){
      $color_1  =   esc_html( get_theme_mod('superfit_color_1') );
    }else{
      $color_1  =  '#111111';
    }

    if( get_theme_mod('superfit_color_2') ){
      $color_2  =   esc_html( get_theme_mod('superfit_color_2') );
    }else{
      $color_2  =  '#c83030';
    }

    if( get_theme_mod('superfit_color_3') ){
      $color_3  =   esc_html( get_theme_mod('superfit_color_3') );
    }else{
      $color_3  =  '#222222';
    }

    $custom_css = "
        a,
        a:hover,
        .dropdown-menu > .active > a, .dropdown-menu > .active > a:focus, .dropdown-menu > .active > a:hover,.top-sec .search-btn:hover{
            color: {$color_2};
        }
        .widget #wp-calendar caption{
            background: {$color_2};
        }
        
        #site-header .navbar-default .navbar-toggle,
        .comment .comment-reply-link,
        input[type='submit'], button[type='submit'], .btn, .comment .comment-reply-link,
        #main-navigation ul.navbar-nav > li.current-menu-item > a, #main-navigation ul.navbar-nav > li.current-menu-parent > a{
            background-color: {$color_2};
        }
        .comment .comment-reply-link,
        input[type='submit'], button[type='submit'], .btn, .comment .comment-reply-link{
            border: 1px solid {$color_2};
        }

        #site-header,footer.footer,.pagination .current{
            background-color: {$color_1};
        }
        .top-sec{
            background-color: {$color_3};
        }
        
        
      ";

    wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '', 'all' );
    wp_enqueue_style( 'superfit-main-stylesheet', get_template_directory_uri() . '/assets/css/style.css', array(), '', 'all' );
    wp_add_inline_style( 'superfit-main-stylesheet', $custom_css );
}

add_action( 'wp_enqueue_scripts', 'superfit_apply_color', 999 );