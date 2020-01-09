<?php 

/**
 * Customizer settings
 *
 * @package superfit
 */

if ( ! function_exists( 'superfit_theme_customizer' ) ) :
  function superfit_theme_customizer( $wp_customize ) {

    /* Homepage Sections */
    $wp_customize->add_section( 'superfit_post_section' , array(
      'title'       => __( 'Post Template', 'superfit' ),
      'priority'    => 30,
    ) );
    
    $wp_customize->add_setting( 'superfit_post_template', array(
      'default' => 'wside',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'superfit_sanitize_select',
    ));
    
    $wp_customize->add_control( 'superfit_post_template', array(
      'settings' => 'superfit_post_template',
      'label' => __( 'Select template:', 'superfit' ),
      'section' => 'superfit_post_section',
      'type' => 'select',
      'choices' => array(
        'wside' => __('With Sidebar (Default)', 'superfit' ),
        'full' => __('Fullwidth', 'superfit' ),
      ),
    ));

    /* Homepage Sections */
    $wp_customize->add_section( 'superfit_homepage' , array(
      'title'       => __( 'Homepage Sections', 'superfit' ),
      'priority'    => 30,
      'description' => __( 'Select a page to be assigned for each section', 'superfit' ),
    ) );

    $wp_customize->add_setting( 'superfit_section_1', array (
      'sanitize_callback' => 'superfit_sanitize_dropdown_pages',
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'superfit_section_1', array(
      'label'    => __( 'Section 1', 'superfit' ),
      'section'  => 'superfit_homepage',
      'settings' => 'superfit_section_1',
      'type'     => 'dropdown-pages'
    ) ) );

    $wp_customize->add_setting( 'superfit_section_2', array (
      'sanitize_callback' => 'superfit_sanitize_dropdown_pages',
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'superfit_section_2', array(
      'label'    => __( 'Section 2', 'superfit' ),
      'section'  => 'superfit_homepage',
      'settings' => 'superfit_section_2',
      'type'     => 'dropdown-pages'
    ) ) );

    $wp_customize->add_setting( 'superfit_section_3', array (
      'sanitize_callback' => 'superfit_sanitize_dropdown_pages',
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'superfit_section_3', array(
      'label'    => __( 'Section 3', 'superfit' ),
      'section'  => 'superfit_homepage',
      'settings' => 'superfit_section_3',
      'type'     => 'dropdown-pages'
    ) ) );

    $wp_customize->add_setting( 'superfit_view_more', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'superfit_view_more', array(
      'label'    => __( 'Enter Blog Url', 'superfit' ),
      'section'  => 'superfit_homepage',
      'settings' => 'superfit_view_more',
    ) ) );

  
  }
endif;
add_action('customize_register', 'superfit_theme_customizer');


/**
 * Sanitize checkbox
 */
if ( ! function_exists( 'superfit_sanitize_checkbox' ) ) :
  function superfit_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
      return 1;
    } else {
      return '';
    }
  }
endif;

/**
 * Sanitize text field html
 */
if ( ! function_exists( 'superfit_sanitize_field_html' ) ) :
  function superfit_sanitize_field_html( $str ) {
    $allowed_html = array(
    'a' => array(
    'href' => array(),
    ),
    'br' => array(),
    'span' => array(),
    );
    $str = wp_kses( $str, $allowed_html );
    return $str;
  }
endif;

if ( ! function_exists( 'superfit_sanitize_dropdown_pages' ) ) :
  function superfit_sanitize_dropdown_pages( $page_id, $setting ) {
    // Ensure $input is an absolute integer.
    $page_id = absint( $page_id );

    // If $page_id is an ID of a published page, return it; otherwise, return the default.
    return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
  }
endif;

function superfit_sanitize_select( $input, $setting ){
      
    //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
    $input = sanitize_key($input);

    //get the list of possible select options 
    $choices = $setting->manager->get_control( $setting->id )->choices;
                     
    //return input if valid or return default option
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
     
}