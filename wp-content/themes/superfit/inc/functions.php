<?php 

/**
 * theme main functions
 *
 * @package superfit
 */

/**
 * load template hooks
 */
require get_template_directory() . '/inc/template-hooks.php';

/**
 * social media nav
 */
require get_template_directory() . '/inc/social-nav.php';

/**
 * load bootstrap navwalker
 */
if ( ! class_exists( 'wp_bootstrap_navwalker' )) {
  require get_template_directory() . '/assets/wp_bootstrap_navwalker.php'; /* Theme wp_bootstrap_navwalker display */
}
/**
 * customizer
 */
require get_template_directory() . '/inc/customizer/controls.php';
require get_template_directory() . '/inc/customizer/display.php';

/**
 * Theme setup
 */
add_action( 'after_setup_theme', 'superfit_theme_setup' );
function superfit_theme_setup() {

    load_theme_textdomain( 'superfit', get_template_directory() . '/inc/translation' );

    add_action( 'wp_enqueue_scripts', 'superfit_scripts_and_styles', 999 );

    add_action( 'widgets_init', 'superfit_register_sidebars' );

    superfit_theme_support();

    global $content_width;
    if ( ! isset( $content_width ) ) {
    $content_width = 640;
    }

    // Thumbnail sizes
    add_image_size( 'superfit-600', 600, 600, true );
    add_image_size( 'superfit-300', 300, 300, true );

} 

/**
 * register sidebar
 */
function superfit_register_sidebars() {

  register_sidebar(array(
    'id' => 'sidebar1',
    'name' => __( 'Posts Widget Area', 'superfit' ),
    'description' => __( 'The Posts Widget Area.', 'superfit' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widgettitle">',
    'after_title' => '</h3>',
  ));

  register_sidebar(array(
    'id' => 'home-widget',
    'name' => __( 'Home Widget Area', 'superfit' ),
    'description' => __( 'The Home Widget Area.', 'superfit' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widgettitle">',
    'after_title' => '</h3>',
  ));

}

/**
 * enqueue scripts and styles
 */
function superfit_scripts_and_styles() {

    global $wp_styles; 

    wp_enqueue_script( 'jquery-modernizr', get_template_directory_uri() . '/assets/js/modernizr.custom.min.js', array('jquery'), '2.5.3', false );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '', true );
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/fonts/font-awesome.min.css', array(), '', 'all' );
    wp_enqueue_style('superfit-google-fonts-Roboto', '//fonts.googleapis.com/css?family=Roboto:300,300i,400,700');
    wp_enqueue_style('superfit-google-fonts-Oswald', '//fonts.googleapis.com/css?family=Oswald:700,400');
    wp_enqueue_script( 'superfit-jquery-menu', get_template_directory_uri() . '/assets/js/menu.js', array('jquery'), '', true );

    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }

}

/**
 * theme support
 */
function superfit_theme_support() {

    add_theme_support( 'post-thumbnails' );

    set_post_thumbnail_size( 600, 600 );

    add_theme_support( 'custom-background',
    array(
    'default-image' => '',    // background image default
    'default-color' => 'ffffff',    // background color default (dont add the #)
    'wp-head-callback' => '_custom_background_cb',
    'admin-head-callback' => '',
    'admin-preview-callback' => ''
    )
    );

    add_theme_support('automatic-feed-links');

    add_theme_support( 'title-tag' );

    add_theme_support( 'custom-logo' );

    register_nav_menus(
    array(
    'main-nav' => __( 'Main Nav', 'superfit' ),
    'social-nav' => __( 'Social Nav', 'superfit' ),
    )
    );
  
}

function superfit_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'superfit_content_width', 840 );
}
add_action( 'after_setup_theme', 'superfit_content_width', 0 );

/**
 * Comment layout
 */
function superfit_comments( $comment, $args, $depth ) { ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('comments'); ?>>

      <header class="comment-author vcard">
        <?php echo get_avatar( $comment,60 ); ?>
      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php esc_html_e( 'Your comment is awaiting moderation.', 'superfit' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'superfit' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'superfit' ),'  ','') ) ?>
        <a href="<?php comment_link(); ?>"><time datetime="<?php echo comment_time(get_option( 'date_format' )); ?>"><?php comment_date(); ?></time></a>
        <?php comment_text() ?>
        <p class="reply-link"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
      </section>
<?php
} // don't remove this bracket!

/**
 * reoder comment form fields
 */
function superfit_move_comment_field_to_bottom( $fields ) {
  $comment_field = $fields['comment'];
  unset( $fields['comment'] );
  $fields['comment'] = $comment_field;
  return $fields;
}

add_filter( 'comment_form_fields', 'superfit_move_comment_field_to_bottom' );

/**
 * wp_nav_menu Fallback
 */
function superfit_primary_menu_fallback() {
    ?>

    <ul id="menu-main-menu" class="nav navbar-nav navbar-right">
        <?php
        wp_list_pages(array(
            'depth'        => 1,
            'exclude' => '', //comma seperated IDs of pages you want to exclude
            'title_li' => '', //must override it to empty string so that it does not break our nav
            'sort_column' => 'post_title', //see documentation for other possibilites
            'sort_order' => 'ASC', //ASCending or DESCending
        ));
        ?>
    </ul>

    <?php
}

add_filter('excerpt_more', 'superfit_new_excerpt_more');
function superfit_new_excerpt_more($more) {
  if ( is_admin() ) {
     return $more;
  }
  global $post;
  return '<a class="moretag" href="'. esc_url( get_permalink($post->ID) ) . '">' . __('Read more','superfit') . '</a>';
}
add_filter('excerpt_more', 'superfit_new_excerpt_more');

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/plugin/class-tgm.php';

add_action( 'tgmpa_register', 'fintess_pro_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the superfit library
 * and one from the .org repo.
 *
 * The variable passed to fintess_pro_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into fintess_pro_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function fintess_pro_register_required_plugins() {
 
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
 
 
        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name'      => __('Bookly #1 WordPress Booking Plugin (Lite Version)','superfit'),
            'slug'      => 'bookly-responsive-appointment-booking-tool',
            'required'  => false,
        ),

        array(
            'name'      => __('Better Contact Details','superfit'),
            'slug'      => 'better-contact-details',
            'required'  => false,
        ),

        array(
            'name'      => __('Instagram Feed','superfit'),
            'slug'      => 'instagram-feed',
            'required'  => false,
        ),
 
    );
 
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'superfit-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'superfit' ),
            'menu_title'                      => __( 'Install Plugins', 'superfit' ),
            'installing'                      => __( 'Installing Plugin: %s', 'superfit' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'superfit' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' , 'superfit'), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' , 'superfit'), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' , 'superfit'), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' , 'superfit'), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' , 'superfit'), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' , 'superfit'), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' , 'superfit'), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' , 'superfit'), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' , 'superfit'),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' , 'superfit'),
            'return'                          => __( 'Return to Required Plugins Installer', 'superfit' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'superfit' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'superfit' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
 
    tgmpa( $plugins, $config );
 
}