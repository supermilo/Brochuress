<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */
$el_class = $width = $css = $offset = $hide_on_desktop = $hide_on_tablet = $hide_on_mobile = $add_box_shadow = $shadow_color = $shadow_color_hover = $add_box_shadow_spacing = '';
$background_attachment = $background_position = $parallax = $hide_bg_tablet = $hide_bg_mobile = $hide_bg_medium = '';
$gradient_background = $gradient_overlay_background = false;
$animate_once = 'yes';
$sticky_on_scroll = '';
$distortion = $early_distortion_effect = $background_distortion_1 = $background_distortion_2 = $distortion_ease = $distortion_speed_in = $distortion_speed_out = $distortion_intensity = '';
$distortion_effect = 1;

$output = '';

// get shortcode attributes
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$css_classes = array(
	$this->getExtraClass( $el_class ),
	'wpb_column',
	'vc_column_container',
	$width,
);

if( vc_shortcode_custom_css_has_property( $css, array('border', 'background', 'background-image', 'background-color' ) ) || $bklyn_overlay || $distortion ) {
	$css_classes[]='vc_col-has-fill';
}

if( $distortion ) {
	$css_classes[] = 'ut-background-with-distortion-effect';
}

if( $early_distortion_effect == 'on' ) {
	$css_classes[] = 'ut-early-distortion-effect';
}

if( $sticky_on_scroll == 'on' ) {
    $css_classes[] = 'ut-stick-in-parent';
}

// animation
$animation_attributes = array();

/* fill animation classes */
if( !empty( $effect ) && $effect != 'none' ) {
    
    $css_classes[] = 'ut-animate-element';
    $css_classes[] = 'animated';             
                
    if( $animate_tablet == 'false' || !$animate_tablet ) {
        $css_classes[]  = 'ut-no-animation-tablet';
    }

    if( $animate_mobile == 'false' || !$animate_mobile ) {
        $css_classes[]  = 'ut-no-animation-mobile';
    }
    
    if( $animate_once == 'infinite' ) {
        $css_classes[]  = 'infinite';
    }
    
    $animation_attributes['data-effect'] = esc_attr( $effect );
    $animation_attributes['data-animateonce'] = esc_attr( $animate_once );
    
    //$animation_attributes['data-appear-top-offset'] = '-120';
    
    $delay_timer = isset( $delay_timer ) && $delay_timer != '' ? $delay_timer : 200;
    $animation_attributes['data-delay'] = $delay == 'true' ? esc_attr( $delay_timer ) : 0;
    
    $animation_duration = !empty( $animation_duration ) ? $animation_duration : '1s';
    $animation_attributes['data-animation-duration'] = esc_attr( $animation_duration );    
    
}

/* attributes string */
$animation_attributes = implode(' ', array_map(
    function ($v, $k) { return sprintf("%s=\"%s\"", $k, $v); },
    $animation_attributes,
    array_keys( $animation_attributes )
) );



/**
 * Custom CSS
 */

$column_inner_id = uniqid("ut_inner_column_");

$custom_css_style  = '';
$inner_css_classes = array();
$inner_attributes = array();

// box shadow
if( $add_box_shadow ) {
    $inner_css_classes[] = 'ut-column-shadow';
}

if( $add_box_shadow && $shadow_color ) {
    $custom_css_style .= '#' . $column_inner_id . '.ut-column-shadow { transition: box-shadow 0.3s ease-in-out; box-shadow: 0 0 20px ' . $shadow_color . '; }';        
}

if( $add_box_shadow && $shadow_color_hover ) {
    $custom_css_style .= '#' . $column_inner_id . ':hover.ut-column-shadow { box-shadow: 0 0 20px ' . $shadow_color_hover . '; }';        
}

if( $add_box_shadow && $add_box_shadow_spacing ) {
    $custom_css_style .= '#' . $column_inner_id . '.ut-column-shadow { margin: 20px; }';    
}

// create settings array
if( !empty( $atts['css'] ) && ut_vc_css_to_array( $atts['css'] ) ) {
    
    $vc_css = ut_vc_css_to_array( $atts['css'] );

    if( isset( $vc_css["background-color"] ) ) {
                
        if( function_exists("ut_create_gradient_css") && ut_create_gradient_css( $vc_css["background-color"] ) ) {
            
            // add background image
            $custom_css_style .= ut_create_gradient_css( $vc_css["background-color"], '#' . $column_inner_id ); 
            
            // remove vc background color
            $vc_css = ut_clean_up_vc_css_array( $vc_css, 'background-color' );
            
        }         
        
    }
    
    // background with gradient and background image
    if( isset( $vc_css["background"] ) ) {
        
        if( function_exists("ut_create_gradient_css") && ut_create_gradient_css( $vc_css["background"] ) ) {
            
            // add background image
            $custom_css_style .= ut_create_gradient_css( $vc_css["background"], '#' . $column_inner_id, false, 'background' ); 
            
            // remove vc background
            unset( $vc_css['background'] );
            
        }         
        
    }
    
    // remove image on mobile devices
    if( unite_mobile_detection()->isMobile() && $hide_bg_mobile ) {
        unset( $vc_css['background-image'] );
    }
    
    // remove image on tablet devices
    if( unite_mobile_detection()->isTablet() && $hide_bg_tablet ) {
        unset( $vc_css['background-image'] );
    }
    
    // custom background position
    if( $background_position ) {
        $vc_css['background-position'] = $background_position . ' !important;';     
    }
    
    // custom background attachment
    if( $background_attachment && !$parallax ) {
        $vc_css['background-attachment'] = $background_attachment . '!important;';
    }

    if( !empty( $vc_css['background-image'] ) ) {

        $inner_css_classes[] = 'ut-background-lozad';
        $inner_attributes[]  = 'data-background-image="' . ut_extract_custom_css_property( $css, 'background-image', true ) . '"';

        unset( $vc_css['background-image'] );

    }

    // re-assemble custom css
    $custom_css_style .= '#' . $column_inner_id . '{' . implode_with_key( $vc_css ) . '}';
    
}


/**
 * Overlay Settings
 */

$overlay_style_id = uniqid("ut_column_overlay_");
$overlay_effect_id = uniqid("ut-section-overlay-effect-");

if( $bklyn_overlay && $bklyn_overlay_color ) {
    
    if( function_exists("ut_create_gradient_css") && ut_create_gradient_css( $bklyn_overlay_color ) ) {
        
        $custom_css_style .= ut_create_gradient_css( $bklyn_overlay_color, '#' . $overlay_style_id, ( $bklyn_overlay_pattern ? $bklyn_overlay_pattern_style : false ) );   
        $gradient_overlay_background = true;
        
    } else {
       
        $custom_css_style .= '#' . $overlay_style_id . '{ background-color: ' . $bklyn_overlay_color . ';}';
        
    }
    
}

if( $bklyn_overlay_pattern && !$gradient_overlay_background && 'bklyn-custom-pattern' == $bklyn_overlay_pattern_style && !empty( $bklyn_overlay_custom_pattern ) ) {
    
    $bklyn_overlay_custom_pattern = wp_get_attachment_url( $bklyn_overlay_custom_pattern );        
    $custom_css_style .= '#' . $overlay_style_id . '{ background-image: url( ' . esc_url( $bklyn_overlay_custom_pattern ) . '); }'; 
    
} 

if( $bklyn_overlay ) {
    
    /* add parent css class */
    $css_classes[] = 'bklyn-column-with-overlay';

}

if( $bklyn_overlay && $bklyn_overlay_effect ) {
    
	wp_enqueue_script( 'ut-particles-js' );
	
    /* add parent css class */
    $css_classes[] = 'bklyn-section-with-overlay-effect';
	
	// $effect config
	$overlay_effect_config = ut_create_overlay_effect_settings( $atts );	
	
}

/**
 * Responsive Settings
 */

if( $hide_bg_tablet ) {
    $inner_css_classes[] = 'hide-bg-on-tablet';
}        
    
if( $hide_bg_mobile ) {
    $inner_css_classes[] = 'hide-bg-on-mobile';
} 

if( $hide_bg_medium ) {
    $inner_css_classes[] = 'hide-bg-on-medium';
}

// responsive classes
if( $hide_on_desktop ) {
    $css_classes[] = 'hide-on-desktop';
}

if( $hide_on_tablet ) {
    $css_classes[] = 'hide-on-tablet';
}

if( $hide_on_mobile ) {
    $css_classes[] = 'hide-on-mobile';
}


/**
 * Design and Custom CSS
 */

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );

// attributes
$wrapper_attributes = array();
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
$wrapper_attributes[] = $animation_attributes;


/**
 * Column Output
 */

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
	
    $output .= '<div id="' . $column_inner_id . '" class="vc_column-inner ' . implode(' ', $inner_css_classes ) . '" ' . implode( ' ', $inner_attributes ) . '>';

		// Background Distortion
		if( $distortion && !$parallax ) {

			// Start Class
			$distortion = new UT_Distortion_Background( $atts );

			// Set Images
			$distortion->set_default_image( $background_distortion_1 );
			$distortion->set_hover_image( $background_distortion_2 );

			// Set Effect
			$distortion->set_effect( $distortion_effect );

			$output .= $distortion->html();

		}

		// column overlay
		if( $bklyn_overlay ) {

			$output .= '<div id="' . $overlay_style_id . '" class="bklyn-overlay ' . ( $bklyn_overlay_pattern ? $bklyn_overlay_pattern_style : '' ) . '">';

				if( $bklyn_overlay_effect ) {

					$output .= '<div id="' . $overlay_effect_id . '" class="bklyn-overlay-effect" data-effect-config=\'' . json_encode( $overlay_effect_config ) . '\'></div>';	

				}

			$output .= '</div>';

		}

    	$output .= '<div class="wpb_wrapper">';
            
            // row content
            $output .= wpb_js_remove_wpautop( $content );
    
        $output .= '</div>';

    $output .= '</div>';

	// custom css
    if( !empty( $custom_css_style ) ) {
        $output .= '<style type="text/css">' . $custom_css_style . '</style>';
    }

$output .= '</div>';

echo $output;