<?php

if (!defined('ABSPATH')) {
    exit; // exit if accessed directly
}

if ( ! function_exists( 'ut_search_sub_array' ) ) :

    function ut_search_sub_array( $array, $value ) {

        foreach( $array as $key => $subarray ){

            if( $value == $key ) {

                return $subarray;

            }

        }

        return false;

    }

endif;


/**
 * Simplify Google Font Array for faster loading
 *
 * @param  array $fonts
 * @return array
 *
 */

function ut_simplify_google_fonts( $fonts ) {

    if( empty( $fonts ) ) {

        return array();

    }

    // set missing subsets
    foreach( $fonts as $key => $font ) {

        if( empty( $font['font-subset'] ) ) {

            $fonts[$key]['font-subset'] = 'latin'; // default subset

        }

        if( empty( $font['font-style'] ) ) {

            $fonts[$key]['font-style'] = 'normal'; // default style

        }

    }

    // option relations
    $google_options_relations = array(
        // main navigation relations
        'ut_global_navigation_font_type' => array(
            'ut_global_navigation_submenu_font_style',
            'ut_global_navigation_modules_font_style',
            'ut_global_navigation_modules_font_style',
            'ut_global_mobile_navigation_font_style',
            'ut_global_mobile_navigation_sub_font_style'
        ),
        // overlay navigation relations
        'ut_overlay_navigation_font_type' => array(
            'ut_global_overlay_navigation_submenu_websafe_font_style'
        )

    );

    // create new font array
    $font_array = array();
    $font_array['subsets'] = array();

    foreach( $fonts as $key => $font ) {

        if( empty( $font['font-family'] ) ) {
            continue;
        }

        // create new array for this font
        if( !array_key_exists( $font['font-family'], $font_array )  ) {

            $font_array[$font['font-family']] = array();

        }

        // font weight
        if( !empty( $font['font-weight'] ) ) {

            if ( isset( $font_array[ $font['font-family'] ]['font-setting'] ) ) {

                if ( ! in_array( $font['font-weight'] . $font['font-style'], $font_array[ $font['font-family'] ]['font-setting'] ) ) {

                    $font_array[ $font['font-family'] ]['font-setting'][] = $font['font-weight'] . $font['font-style'];

                }

            } else {

                $font_array[ $font['font-family'] ]['font-setting'] = array( $font['font-weight'] . ':' . $font['font-style'] );

            }

        }

        // related font settings
        if( isset( $google_options_relations[$key] ) ) {

            foreach( $google_options_relations[$key] as $related_option ) {

                $related_option_value = ot_get_option( $related_option );

                if( $related_option_value ) {

                    // font style fallback
                    $related_option_value['font-style'] = ! empty( $related_option_value['font-style'] ) ? $related_option_value['font-style'] : 'normal';

                    if ( ! empty( $related_option_value['font-weight'] ) ) {

                        if ( isset( $font_array[ $font['font-family'] ]['font-setting'] ) ) {

                            if ( ! in_array( $related_option_value['font-weight'] . $related_option_value['font-style'], $font_array[ $font['font-family'] ]['font-setting'] ) ) {

                                $font_array[ $font['font-family'] ]['font-setting'][] = $related_option_value['font-weight'] . $related_option_value['font-style'];

                            }

                        } else {

                            $font_array[ $font['font-family'] ]['font-setting'] = array( $related_option_value['font-weight'] . ':' . $related_option_value['font-style'] );

                        }

                    }

                }

            }

        }

        // font subset
        if( !in_array( $font['font-subset'], $font_array['subsets'] ) ) {

            $font_array['subsets'][] = $font['font-subset'];

        }

    }

    return $font_array;

}

if ( ! function_exists( 'ut_create_google_font_link' ) ) :

    function ut_create_google_font_link() {

        $transient = 'ut-google-fonts-enqueue';

        if( false === ( get_transient( $transient ) ) ) {

            /* needed vars */
            $google_url = '//fonts.googleapis.com/css?family=';

            /* catch for all google typography settings */
            $option_keys = array();

            /* custom array of all affected option tree options */
            $google_options = array(
                'ut_body_font_type' 				   		    => 'ut_google_body_font_style',
                'ut_global_header_text_logo_font_type' 		    => 'ut_global_header_text_google_font_style',
                'ut_global_navigation_font_type' 			    => 'ut_global_navigation_google_font_style',
                'ut_global_navigation_submenu_font_type' 	    => 'ut_global_navigation_submenu_google_font_style',
                'ut_global_navigation_modules_font_type' 	    => 'ut_global_navigation_modules_google_font_style',
                'ut_global_navigation_buttons_font_type' 	    => 'ut_global_navigation_buttons_google_font_style',
                'ut_global_megamenu_column_title_font_type'	    => 'ut_global_megamenu_column_title_google_font_style',
                'ut_breadcrumb_font_type'                       => 'ut_google_breadcrumb_style',
                'ut_overlay_navigation_font_type' 		        => 'ut_google_overlay_navigation_style',
                'ut_front_hero_font_type' 					    => 'ut_google_front_page_hero_font_style',
                'ut_front_catchphrase_top_font_type' 		    => 'ut_google_front_catchphrase_top_font_style',
                'ut_front_catchphrase_font_type' 			    => 'ut_google_front_catchphrase_font_style',
                'ut_split_hero_font_type'					    => 'ut_google_split_hero_font_style',
                'ut_blog_hero_font_type' 					    => 'ut_google_blog_hero_font_style',
                'ut_blog_catchphrase_top_font_type' 		    => 'ut_google_blog_catchphrase_top_font_style',
                'ut_blog_catchphrase_font_type' 			    => 'ut_google_blog_catchphrase_font_style',
                'ut_global_h1_font_type' 					    => 'ut_h1_google_font_style',
                'ut_global_h2_font_type' 					    => 'ut_h2_google_font_style',
                'ut_global_h3_font_type' 					    => 'ut_h3_google_font_style',
                'ut_global_h4_font_type' 					    => 'ut_h4_google_font_style',
                'ut_global_h5_font_type' 					    => 'ut_h5_google_font_style',
                'ut_global_h6_font_type' 					    => 'ut_h6_google_font_style',
                'ut_global_headline_font_type' 				    => 'ut_global_google_headline_font_style',
                'ut_global_page_headline_font_type' 		    => 'ut_global_page_google_headline_font_style',
                'ut_global_lead_font_type' 					    => 'ut_google_lead_font_style',
                'ut_csection_header_font_type' 				    => 'ut_csection_header_google_font_style',
                'ut_csection_lead_font_type'				    => 'ut_csection_lead_google_font_style',
                'ut_global_portfolio_title_font_type' 		    => 'ut_google_portfolio_title_font_style',
                'ut_global_portfolio_title_below_font_type'     => 'ut_google_portfolio_title_below_font_style',
                'ut_global_portfolio_category_font_type' 	    => 'ut_google_portfolio_category_font_style',
                'ut_blockquote_font_type' 					    => 'ut_google_blockquote_font_style',
                'ut_global_blog_widgets_headline_font_type'     => 'ut_global_blog_widgets_headline_google_font_style',
                'ut_footer_widgets_headline_font_type' 		    => 'ut_footer_widgets_headline_google_font_style',
                'ut_lightbox_font_type'                         => 'ut_lightbox_google_font_style',
                'ut_react_portfolio_title_font_type'            => 'ut_google_react_portfolio_title_font_style',
                'ut_react_portfolio_background_title_font_type' => 'ut_google_react_portfolio_background_title_font_style'
            );

            // fill option keys
            foreach( $google_options as $key => $google_option) {

                if( ot_get_option( $key, 'ut-font' ) == 'ut-google' ) {

                    $option_keys[$key] = ot_get_option( $google_option );

                }

            }

            // simplify
            $_option_keys = ut_simplify_google_fonts( $option_keys );

            // no fonts to proceed
            if( empty( $_option_keys ) ) {
                return;
            }

            // setup query strings
            $fonts      = array();
            $query_args = array();

            foreach( $_option_keys as $key => $option ) {

                if( $key == 'subsets' ) {
                    continue;
                }

                $google_fonts = ut_search_sub_array( ut_recognized_google_fonts(), $key );

                if( $google_fonts ) {

                    // replace whitespace with +
                    $family = preg_replace("/\s+/" , '+' , $google_fonts['family'] );

                    if( isset( $option['font-setting'] ) ) {

                        $fonts[] = $family . ':' . implode( ',', $option['font-setting'] );

                    } else {

                        $fonts[] = $family;

                    }

                }

            }

            // fonts
            $query_args['family'] = implode( '|', $fonts );

            // needed subsets
            $query_args['subsets'] = implode( ',', $_option_keys['subsets'] );

            // font display swap @todo option
            $query_args['display'] = 'swap';

            // final string
            $query_string = add_query_arg( $query_args, $google_url );

            if( !empty( $query_string ) ) {

                set_transient( $transient, $query_string );

            }

        } else {

            $query_string = get_transient( $transient );

        }

        if( !empty( $query_string ) && is_string( $query_string ) ) {

            wp_enqueue_style( 'ut-google-fonts', $query_string );

            // old configuration - delete it and start again
        } elseif( !empty( $query_string ) && is_array( $query_string ) ) {

            delete_transient( $transient );
            ut_create_google_font_link();

        }

    }

endif;








function unite_scripts() {

	global $wp_query;

	$min = NULL;

	if( !WP_DEBUG ){
		$min = '.min';
	}

	/*
	 * CSS
	 */

	/* Google Fonts */
	ut_create_google_font_link(); 

	/* Fonts */
	wp_enqueue_style(
		'ut-main-font-face',
		THEME_WEB_ROOT . '/css/ut-fontface' . $min . '.css'
	); 

	/* Font Awesome */
	wp_enqueue_style(
		'ut-fontawesome',
		THEME_WEB_ROOT . '/css/font-awesome' . $min . '.css'
	); 

	/* Brooklyn Icons */
	wp_enqueue_style(
		'ut-bklynicons',
		THEME_WEB_ROOT . '/css/bklynicons/bklynicons.css'
	); 

	/* Responsive Grid */
	wp_enqueue_style(
		'ut-responsive-grid',
		THEME_WEB_ROOT . '/css/ut-responsive-grid' . $min . '.css' 
	);

	/* Animate CSS */
	wp_enqueue_style(
		'ut-animate',
		THEME_WEB_ROOT . '/css/ut.animate' . $min . '.css'
	);

	/* Superfish */
	wp_enqueue_style(
		'ut-superfish',
		THEME_WEB_ROOT . '/css/ut-superfish' . $min . '.css'
	);

	/* Fancy Slider */
	if( ut_return_hero_config( 'ut_hero_type' ) == 'transition' ) {

		wp_enqueue_style(
			'ut-fancy-slider',
			THEME_WEB_ROOT . '/css/ut-fancyslider' . $min . '.css'
		);

	}        

	/* Flexslider */
	wp_enqueue_style(
		'ut-flexslider',
		THEME_WEB_ROOT . '/css/flexslider' . $min . '.css'
	);

	/* Lightgallery */
	wp_enqueue_style(
		'ut-lightgallery',
		THEME_WEB_ROOT . '/assets/vendor/lightGallery/css/lightgallery' . $min . '.css'
	);            

	/* Brookyln Shop CSS */
	if( is_woocommerce_activated() ) {

		wp_enqueue_style(
			'ut-theme-shop',
			THEME_WEB_ROOT . '/css/ut.brooklyn-shop' . $min . '.css'
		);

	}

	/* Brookyln CSS */
	wp_enqueue_style(
		'ut-main-style',
		get_stylesheet_uri(),
		array(), 
		UT_THEME_VERSION
	);	

	/* Brookyln Theme CSS */
	wp_enqueue_style(
		'ut-theme-style',
		THEME_WEB_ROOT . '/css/ut.theme' . $min . '.css',
		array('ut-main-style'), 
		UT_THEME_VERSION
	); 

	if( isset( $_GET['vc_editable'] ) && $_GET['vc_editable'] == 'true' ) {

        wp_enqueue_style(
            'ut-frontend-editor',
            THEME_WEB_ROOT . '/css/ut-frontend-editor' . $min . '.css',
            'ut-main-style',
            UT_THEME_VERSION
        );

    }

    /*wp_enqueue_style(
		'ut-theme-temp-style',
		THEME_WEB_ROOT . '/css/temp.css',
		array('ut-main-style'), 
		UT_THEME_VERSION
	); */ 
    
    
	/*
	 * Register JS
	 */


	/* Particles  JS for Section and Rows */
	wp_register_script(
		'ut-particles-js', 
		THEME_WEB_ROOT . '/js/particles' . $min . '.js',
		array('jquery'), 
		UT_THEME_VERSION
	);

	/* Particle Effects for buttons */
	wp_register_script(
		'ut-anime-js', 
		THEME_WEB_ROOT . '/js/anime/anime.min.js',
		array('jquery'), 
		UT_THEME_VERSION,
		true
	);

	wp_register_script(
		'ut-button-particles-js', 
		THEME_WEB_ROOT . '/js/anime/button-particles.min.js',
		array('ut-anime-js'), 
		UT_THEME_VERSION,
		true
	);
    
    /* Reveal FX */
    wp_register_script(
		'ut-revealfx-js', 
		THEME_WEB_ROOT . '/js/anime/revealfx.min.js',
		array('ut-anime-js'), 
		UT_THEME_VERSION,
		true
	);

    /* Bubble Box */
    wp_register_script(
        'ut-morph-box-js',
        THEME_WEB_ROOT . '/js/ut-morph-box.js',
        array( 'three-js', 'ut-greensock-tweenlite', 'ut-greensock-easepack', 'ut-greensock-css' ),
        UT_THEME_VERSION,
        true
    );

	/* JS for Background Distortion */
	wp_register_script(
		'three-js', 
		THEME_WEB_ROOT . '/js/three/three.min.js',
		array('jquery'), 
		UT_THEME_VERSION
	);

	wp_register_script(
		'ut-greensock-tweenmax', 
		THEME_WEB_ROOT . '/js/greensock/TweenMax.min.js', 
		array(), 
		'1.0',
		true 
	);  

	wp_register_script(
		'ut-distortion-js', 
		THEME_WEB_ROOT . '/js/ut-distortion' . $min . '.js',
		array( 'jquery','three-js','ut-greensock-tweenmax' ), 
		UT_THEME_VERSION
	);

    /* pixi */
    wp_register_script(
		'ut-pixi-js', 
		THEME_WEB_ROOT . '/js/pixi/pixi.min.js',
		array(), 
		UT_THEME_VERSION
	);
    
    wp_register_script(
		'ut-pixi-sound-js', 
		THEME_WEB_ROOT . '/js/pixi/pixi-sound.min.js',
		array( 'ut-pixi-js' ), 
		UT_THEME_VERSION
	);

    /* Flickity */
    wp_register_script(
        'ut-flickity-js',
        THEME_WEB_ROOT . '/js/flickity/flickity.pkgd.min.js',
        array('jquery'),
        UT_THEME_VERSION
    );

    /* React Slider */
    wp_register_script(
        'ut-reactslider-js',
        THEME_WEB_ROOT . '/js/ut-react-slider' . $min . '.js',
        array( 'jquery', 'ut-greensock-tweenmax', 'ut-mobileevents-js' ),
        UT_THEME_VERSION
    );

    /* SVG Library */
    wp_register_script(
        'ut-svg-js',
        THEME_WEB_ROOT . '/js/anime/svg.js',
        array( 'jquery' ),
        UT_THEME_VERSION,
        true
    );

	/* Page Morphing */
	wp_register_script(
		'ut-ballon-js', 
		THEME_WEB_ROOT . '/js/morphing/balloon' . $min . '.js',
		array( 'jquery' ), 
		UT_THEME_VERSION,
		true
	);

	wp_register_script(
		'ut-digital-js', 
		THEME_WEB_ROOT . '/js/morphing/digital' . $min . '.js',
		array( 'jquery' ), 
		UT_THEME_VERSION,
		true
	);

	wp_register_script(
		'ut-fluid-js', 
		THEME_WEB_ROOT . '/js/morphing/fluid' . $min . '.js',
		array( 'jquery' ), 
		UT_THEME_VERSION,
		true
	);

	wp_register_script(
		'ut-water-js', 
		THEME_WEB_ROOT . '/js/morphing/water' . $min . '.js',
		array( 'jquery' ), 
		UT_THEME_VERSION,
		true
	);

	wp_register_script(
		'ut-drawsvg-js', 
		THEME_WEB_ROOT . '/js/drawsvg/jquery.drawsvg' . $min . '.js',
		array( 'jquery' ), 
		UT_THEME_VERSION,
		true
	);

	wp_register_script(
		'ut-drawsvg-js', 
		THEME_WEB_ROOT . '/js/drawsvg/jquery.drawsvg' . $min . '.js',
		array( 'jquery' ), 
		UT_THEME_VERSION,
		true
	);

	wp_register_script(
		'ut-vivus-js', 
		THEME_WEB_ROOT . '/js/vivus/vivus' . $min . '.js',
		array(), 
		UT_THEME_VERSION,
		true
	);

	wp_register_script(
		'ut-smooth-scroll', 
		THEME_WEB_ROOT . '/js/SmoothScroll' . $min . '.js',
		array(), 
		UT_THEME_VERSION
	);


    /* video */
    wp_register_script(
        'ut-bgvid',
        THEME_WEB_ROOT . '/js/jquery.mb.YTPlayer' . $min . '.js',
        array('jquery'),
        '3.2.5',
        true
    );

    wp_register_script(
        'ut-vimeo-api',
        THEME_WEB_ROOT . '/js/vimeo.player' . $min . '.js',
        array('jquery'),
        '1.0.0',
        true
    );

    wp_register_script(
        'ut-bgvid-vimeo',
        THEME_WEB_ROOT . '/js/jquery.vimelar' . $min . '.js',
        array('jquery'),
        '1.1.9',
        true
    );

    wp_register_script(
        'ut-video-lib',
        THEME_WEB_ROOT . '/js/ut-videoplayer-lib' . $min . '.js',
        array('jquery'),
        '1.0',
        true
    );

    /* Greensock */
    wp_register_script(
        'ut-greensock-tweenlite',
        THEME_WEB_ROOT . '/js/greensock/TweenLite.min.js',
        array(),
        '2.1.3',
        true
    );

    wp_register_script(
        'ut-greensock-easepack',
        THEME_WEB_ROOT . '/js/greensock/EasePack.min.js',
        array( 'ut-greensock-tweenlite' ),
        '1.16.0',
        true
    );

    wp_register_script(
        'ut-greensock-css',
        THEME_WEB_ROOT . '/js/greensock/CSSPlugin.min.js',
        array( 'ut-greensock-tweenlite' ),
        '2.1.3',
        true
    );

    /* Mobile Events */
    wp_register_script(
        'ut-mobileevents-js',
        THEME_WEB_ROOT . '/js/mobileevents/jquery.mobile-events' . $min . '.js',
        array(),
        '2.0.0',
        true
    );

	/*
	 * Enqueue JS
	 */

	/* jquery */
	wp_enqueue_script( 'jquery' );

	/* browser and mobile detection */
	wp_enqueue_script( 
		'modernizr',
		THEME_WEB_ROOT . '/js/modernizr' . $min . '.js', 
		array('jquery'), 
		'2.6.2'
	);

	/* preloader */
	if( ot_get_option('ut_use_image_loader') == 'on' ) {

		$loader_for = ot_get_option('ut_use_image_loader_on');
		$loader_match = false;

		if( !empty( $loader_for ) && is_array( $loader_for ) ) :    

			foreach( $loader_for as $key => $conditional ) {

				if( $conditional() && $conditional != 'is_singular' ) {

					$loader_match = true;

					/* front page gets handeled as a page too */
					if( $conditional == 'is_page' && is_front_page() ) {

						$loader_match = false;

					} elseif( $conditional == 'is_single' && is_singular('portfolio') ) {

						$loader_match = false;

					} else {

						/* we have a match , so we can stop the loop */
						break;

					}

				}

				if( $conditional( 'portfolio' ) && $conditional == 'is_singular' ) {

					$loader_match = true;
					break;

				}

			}

		endif;

		if( $loader_match ) :

			wp_enqueue_script(
				'ut-loader',
				THEME_WEB_ROOT . '/js/jquery.queryloader2' . $min . '.js',
				array('jquery'),
				'2.9.0',
				false
			);

			if( ot_get_option('ut_morph_image_loader', 'off') == 'on' ) {

				wp_enqueue_script('ut-anime-js');
				wp_enqueue_script( ot_get_option( 'ut_morph_image_loader_effect', 'ut-fluid-js' ) );

			}

			if( ot_get_option('ut_image_loader_style', 'style_one') == 'text_draw' ) {

                wp_enqueue_script('ut-anime-js');
				// wp_enqueue_script('ut-drawsvg-js');

			}

			// pre loader settings
			$loader_settings = array( 
				'loader_active'     => true, 
				'loader_logo'       => ot_get_option( 'ut_image_loader_logo' ), 
				'style'             => ot_get_option( 'ut_image_loader_style', 'style_one' ), 
				'loader_percentage' => ot_get_option( 'ut_show_loader_percentage', 'on' ), 
				'loader_text'       => ot_get_option( 'ut_image_loader_text', 'loading' ),
				'text_logo'         => '<div class="site-logo"><h1 class="logo">' . get_bloginfo( "name" ) . '</h1></div>',                    
				'line_color'        => ot_get_option( 'ut_image_loader_text_draw_line_color' , get_option('ut_accentcolor' , '#F1C40F') ),
				'text_start_color'  => ot_get_option( 'ut_image_loader_text_draw_start_color' , get_option('ut_accentcolor' , '#F1C40F') ),
				'text_end_color'    => ot_get_option( 'ut_image_loader_text_draw_end_color' , get_option('ut_accentcolor' , '#F1C40F') ),
			);

			wp_localize_script( 'ut-loader' , 'preloader_settings' , $loader_settings );

		endif;

	}

	/* overlay animation effect */
	if( ut_return_hero_config( 'ut_hero_overlay_effect', 'off' ) == 'on' ) {

		wp_enqueue_script('ut-greensock-tweenlite');
		wp_enqueue_script('ut-greensock-easepack');

		wp_enqueue_script(
			'ut-animation-frame', 
			THEME_WEB_ROOT . '/js/greensock/AnimationFrame.js', 
			array('ut-greensock-easepack'),
			'1.0',
			true
		);

		/* connecting dots overlay */
		if( apply_filters( 'ut_show_hero', false ) && ut_return_hero_config('ut_hero_overlay_effect') == 'on' && ut_return_hero_config( 'ut_hero_overlay_effect_style' ) == 'dots' ) {

			wp_enqueue_script(
				'ut-connecting-dots',
				THEME_WEB_ROOT . '/js/canvas.connectingdots' . $min . '.js', 
				array('ut-animation-frame'),
				'1.0', 
				true
			);            

		}

		/* rising bubbles overlay */
		if( apply_filters( 'ut_show_hero', false ) && ut_return_hero_config('ut_hero_overlay_effect') == 'on' && ut_return_hero_config( 'ut_hero_overlay_effect_style' ) == 'bubbles' ) {

			wp_enqueue_script(
				'ut-rising-bubbles',
				THEME_WEB_ROOT . '/js/canvas.risingbubbles' . $min . '.js', 
				array('ut-animation-frame'),
				'1.0',
				true
			);

		}

	}



	$ut_main_hero_button_settings    = ut_collect_option( 'ut_main_hrbtn' );
	$ut_second_hero_button_settings  = ut_collect_option( 'ut_second_hrbtn' );

	if( ut_return_hero_config( 'ut_main_hero_button' ) && !empty( $ut_main_hero_button_settings['particle_effect'] ) || ut_return_hero_config( 'ut_second_hero_button', 'off' ) == 'on' && !empty( $ut_second_hero_button_settings['particle_effect'] ) ) {

		wp_enqueue_script('ut-button-particles-js'); 

	}

	/* rain effect */
	if( apply_filters( 'ut_show_hero', false ) && ut_return_hero_config( 'ut_hero_rain_effect' , 'off' ) == 'on' ) {

		wp_enqueue_script(
			'ut-rain',
			THEME_WEB_ROOT . '/js/rainyday' . $min . '.js', 
			array('jquery'),
			'1.0',
			true
		);
        
        if( ut_return_hero_config('ut_hero_rain_sound' , 'off') == 'on' ) {
            
            wp_enqueue_script( 'ut-pixi-sound-js' );
            
        } 

	}

	/* fancy slider */
	if( ut_return_hero_config( 'ut_hero_type' ) == 'transition' ) {

		wp_enqueue_script(
			'ut-fancy-slider',
			THEME_WEB_ROOT . '/js/ut-fancyslider' . $min . '.js',
			array('jquery'),
			'1.0',
			true
		);

	}

	/* background video player */
	if( !unite_mobile_detection()->isMobile() && ut_return_hero_config('ut_hero_type') == 'video' && ut_return_hero_config('ut_video_source' , 'youtube') == 'youtube' || unite_mobile_detection()->isMobile() && ut_return_hero_config('ut_hero_type') == 'video' && ut_return_hero_config('ut_video_source' , 'youtube') == 'youtube' && ut_return_hero_config('ut_video_mobile' , 'off') == 'on' || !unite_mobile_detection()->isMobile() && ut_return_hero_config('ut_hero_type') == 'tabs' && ut_return_hero_config('ut_video_containment', 'hero') == 'body' ) :

		wp_enqueue_script(
			'ut-bgvid',
			THEME_WEB_ROOT . '/js/jquery.mb.YTPlayer' . $min . '.js',
			array('jquery'),
			'3.1.5', 
			true
		); 

	endif;


	/* Selfhosted Video Player */
	if( ut_return_hero_config('ut_video_source' , 'youtube') == 'selfhosted' ) {

		wp_enqueue_script(
			'ut-video',
			THEME_WEB_ROOT . '/js/ut-videoplayer' . $min . '.js', 
			array('jquery'),
			'1.0',
			true
		);

	}        

	/* smooth scroll */
	if( ot_get_option( 'ut_google_smooth_scroll', 'off' ) == 'on' ) {

		wp_enqueue_script( 'ut-smooth-scroll' );

	}

	/* superfish navigation */
	wp_enqueue_script(
		'ut-superfish',
		THEME_WEB_ROOT . '/js/superfish' . $min . '.js', 
		array('jquery'), 
		'1.7.4',
		true 
	);
    
    /* simplebar */
    wp_enqueue_script(
        'ut-simplebar', 
        THEME_WEB_ROOT . '/js/simplebar/simplebar.js', 
        array(), 
        '1.0',
        true 
    );
    
	/* Main Libraries */
	wp_enqueue_script( 
		'ut-scriptlibrary',
		THEME_WEB_ROOT . '/js/ut-scriptlibrary' . $min . '.js', 
		array('jquery'), 
		UT_THEME_VERSION
	);

	/* Lightbox Script */
	wp_enqueue_script(
		'ut-lightgallery-js',
		THEME_WEB_ROOT . '/assets/vendor/lightGallery/js/lightgallery-all' . $min . '.js' , 
		array('jquery'),
		'1.2.6',
		true            
	);             

	/* Comment Reply*/
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { 

		wp_enqueue_script( 'comment-reply' ); 

	} 

	/* Custom JavaScripts */
	wp_enqueue_script(
		'unitedthemes-init', 
		THEME_WEB_ROOT . '/js/ut-init' . $min . '.js',
		array( 'jquery', 'ut-scriptlibrary', 'ut-greensock-tweenmax' ),
		UT_THEME_VERSION, 
		true
	);

	/* retina logos with fallback */
	$ut_activate_page_hero = get_post_meta( get_the_ID() , 'ut_activate_page_hero' , true );  

	$sitelogo_retina = !is_front_page() && !is_home() && ( !apply_filters( 'ut_show_hero', false ) ) ? ( ut_return_logo_config( 'ut_site_logo_alt_retina' ) ? ut_return_logo_config( 'ut_site_logo_alt_retina' ) : ut_return_logo_config( 'ut_site_logo_retina' ) ) : ut_return_logo_config( 'ut_site_logo_retina' );                        
	$alternate_logo_retina = ut_return_logo_config( 'ut_site_logo_alt_retina' ) ? ut_return_logo_config( 'ut_site_logo_alt_retina' ) : ut_return_logo_config( 'ut_site_logo_retina' );

	$retina_logos = array(
		'sitelogo_retina'       => $sitelogo_retina, 
		'alternate_logo_retina' => $alternate_logo_retina,
		'overlay_sitelogo_retina' => ot_get_option("ut_overlay_logo_retina"), 
	);

	wp_localize_script('unitedthemes-init' , 'retina_logos' , $retina_logos );
    
    // frame settings
    $ut_site_frame_settings = apply_filters( 'ut_site_frame_settings', array() );
    
	$site_settings = array(
		'type'                    => ot_get_option( 'ut_site_layout', 'multisite' ),
        'siteframe_size'          => $ut_site_frame_settings['border_size'],
        'siteframe_top'           => isset( $ut_site_frame_settings['border_status']['margin-top'] ) && $ut_site_frame_settings['border_status']['margin-top'] == 'on' ? $ut_site_frame_settings['border_size'] : 0,
        'siteframe_right'         => isset( $ut_site_frame_settings['border_status']['margin-right'] ) && $ut_site_frame_settings['border_status']['margin-right'] == 'on' ? $ut_site_frame_settings['border_size'] : 0,
        'siteframe_bottom'        => isset( $ut_site_frame_settings['border_status']['margin-bottom'] ) && $ut_site_frame_settings['border_status']['margin-bottom'] == 'on' ? $ut_site_frame_settings['border_size'] : 0,
        'siteframe_left'          => isset( $ut_site_frame_settings['border_status']['margin-left'] ) && $ut_site_frame_settings['border_status']['margin-left'] == 'on' ? $ut_site_frame_settings['border_size'] : 0,
		'navigation'              => ut_return_header_config( 'ut_header_layout', 'default' ),
        'header_scroll_position'  => ut_return_header_config( 'ut_navigation_scroll_position', 'default' ),
		'lg_type'                 => ot_get_option( 'ut_lightgallery_type', 'lightgallery' ),
		'lg_transition'           => ot_get_option( 'ut_morphbox_transition', 1200 ),
        'lg_download'             => ot_get_option( 'ut_lightgallery_download', 'false' ) ? false : true,
		'mobile_nav_open'         => false,
		'mobile_nav_is_animating' => false,
        'mobile_hero_passed'      => false,
        'scrollDisabled'          => false, 
        'button_particle_effects' => recognized_button_particle_effects(),
        'menu_locations'          => array(
            'navigation'                       => 'primary', 
            'navigation-secondary'             => 'secondary',
            'ut-header-primary-extra-module'   => 'header_primary',
            'ut-header-secondary-extra-module' => 'header_secondary',
            'ut-header-tertiary-extra-module'  => 'header_tertiary',
        ),
        'brooklyn_header_scroll_offset' => 0,
	);

	wp_localize_script('unitedthemes-init' , 'site_settings' , $site_settings );
    
	/* set volume for rain effect */        
	if( ut_return_hero_config('ut_hero_rain_sound' , 'off') == 'on' ) {

		wp_localize_script( 'wp-mediaelement', '_wpmejsSettings', array(
			'pluginPath' => includes_url( 'js/mediaelement/', 'relative' ),
			'startVolume' => 0.1
		) );

	}

	/* remove fontawesome */
	if( function_exists('vc_set_as_theme') ) {
		wp_deregister_style( 'font-awesome' ); /* theme has own library call */
	}

    if( ot_get_option( 'ut_lightgallery_type', 'lightgallery' ) == 'morphbox' ) {

        wp_enqueue_script('ut-morph-box-js');

    }


}    

add_action( 'wp_enqueue_scripts', 'unite_scripts' ); 
