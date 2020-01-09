<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * The Template for displaying Single Background Image
 *
 * @author      United Themes
 * @package     Brooklyn
 * @version     3.0
 */

$hero_classes = array();

/* 
 * template config: content 
 */

$ut_custom_logo      = ut_collect_option( 'ut_custom_hero_logo' );
$ut_custom_slogan    = ut_return_hero_config( 'ut_hero_custom_html' );
$ut_expertise_slogan = ut_return_hero_config( 'ut_hero_caption_slogan' );
$ut_company_slogan   = ut_return_hero_config( 'ut_hero_caption_title' );
$ut_catchphrase      = ut_return_hero_config( 'ut_hero_catchphrase' );


/* 
 * template config: canvas color 
 */

$ut_effect_color = ut_return_hero_config( 'ut_hero_overlay_effect_color' );
$ut_effect_color = !empty( $ut_effect_color ) ? $ut_effect_color : get_option( 'ut_accentcolor', '#F1C40F' );


/* 
 * template config: content width and align
 */

$hero_classes[]  = ut_collect_option( 'ut_hero_width', 'centered' ) == 'fullwidth' ? 'ut-hero-custom' : '';
$ut_hero_v_align = ut_return_hero_config( 'ut_hero_v_align', 'middle' ) == 'bottom' ? 'ut-hero-bottom' : '';

/* 
 * template config: hero separator
 */

if( ut_return_hero_config( 'ut_hero_separator_top', 'off' ) == 'on' || ut_return_hero_config( 'ut_hero_separator_bottom', 'off' ) == 'on' ) {
    $hero_classes[] = 'ut-hero-with-separator';
}

/* 
  * template config: rain effect
 */

$ut_hero_rain_effect = false;

if( ut_return_hero_config('ut_hero_rain_effect' , 'off') == 'on' ) {
    
    $ut_hero_image       = ut_collect_option( 'ut_hero_image' );
    $ut_hero_image       = !empty( $ut_hero_image[ 'background-image' ] ) && is_array( $ut_hero_image ) ? $ut_hero_image[ 'background-image' ] : $ut_hero_image;
    $ut_hero_rain_effect = ut_resize( $ut_hero_image, 1920, 1280, true, true, false ); 
    
}

/* 
 * template config: hero intro animation
 */

$hero_classes[]  = ut_collect_option( 'ut_hero_image_animation_effect', 'heroFadeIn' );

/* 
 * template config: hero caption intro animation
 */

$ut_hero_animation_element_group        = '';
$ut_hero_animation_element_single       = ''; 
$ut_hero_animation_element_group_split  = ''; // only for brooklyn effects

if( ut_collect_option( 'ut_hero_caption_animation_type', 'group' ) == 'group' ) {
    
    $ut_hero_animation_element_group  = 'ut-hero-animation-element';
    
} elseif( ut_collect_option( 'ut_hero_caption_animation_type', 'group' ) == 'group_split' ) {
    
    $ut_hero_animation_element_group_split = 'ut-hero-animation-element';

} else {
    
    $ut_hero_animation_element_single = 'ut-hero-animation-element';
    
}

/* 
 * template config: split media content 
 */

$ut_hero_split_content_type = ut_return_hero_config( 'ut_hero_split_content_type', 'image' );
$ut_hero_split_image        = ut_return_hero_config( 'ut_hero_split_image' );
$ut_hero_split_image_effect = ut_return_hero_config( 'ut_hero_split_image_effect' );

if ( $ut_hero_split_content_type == 'video' ) {
    
    $ut_hero_split_video           = ut_return_hero_config( 'ut_hero_split_video' );
    $ut_hero_split_video_box       = ut_return_hero_config( 'ut_hero_split_video_box', 'on' );
    $ut_hero_split_video_box_style = ut_return_hero_config( 'ut_hero_split_video_box_style', 'light' );
    
}

if ( $ut_hero_split_content_type == 'form' ) {
    
    $ut_hero_split_form = ut_return_hero_config( 'ut_hero_split_form' );
    
} ?>

<!-- Hero Section -->
<section id="ut-hero" class="hero ha-waypoint parallax-section parallax-background <?php echo implode( " " , $hero_classes ); ?>" data-animate-up="ha-header-hide" data-animate-down="ha-header-hide">
    
    <div id="ut-hero-early-waypoint" class="ut-early-waypoint" data-animate-up="ha-header-hide" data-animate-down="ha-header-small"></div>
    
    <?php // Hero Top Separator
    
    if( ut_return_hero_config( 'ut_hero_separator_top', 'off' ) == 'on' && ut_return_hero_config('ut_hero_overlay') == 'off' ) : ?>
    
        <?php echo ut_create_section_separator( 'hero', 'top', ut_return_hero_config( 'ut_hero_separator_svg_top', 'design_wave' ) ); ?>
    
    <?php endif; ?>    
    
    <?php // Hero Parallax Scroll Container
    
    if( ut_return_hero_config('ut_hero_rain_effect' , 'off') == 'off' ) : ?>

        <div class="parallax-scroll-container hero-parallax-scroll-container parallax-scroll-container-hide <?php echo ut_return_hero_config('ut_hero_image_parallax') == 'off' ? 'parallax-scroll-container-disabled' : ''; ?>" data-parallax-bottom data-parallax-factor="8">
        
            <div class="parallax-image-container"></div>
    
        </div>

    <?php endif; ?>
    
    <?php // Start Hero Overlay Container
    
    if( ut_return_hero_config('ut_hero_overlay') == 'on') : ?>

        <div class="parallax-overlay <?php echo ut_return_hero_config( 'ut_hero_overlay_pattern', 'on' ) == 'on' ? 'parallax-overlay-pattern' : ''; ?> <?php echo ut_return_hero_config('ut_hero_overlay_pattern_style' , 'style_one'); ?>">
        
        <?php // top separator needs to be in overlay if active
    
        if( ut_return_hero_config( 'ut_hero_separator_top', 'off' ) == 'on' ) : ?>

            <?php echo ut_create_section_separator( 'hero', 'top', ut_return_hero_config( 'ut_hero_separator_svg_top', 'design_wave' ) ); ?>

        <?php endif; ?>    
            
    <?php endif; ?>
            
        <?php // Hero Rain Effect Image
            
        if( $ut_hero_rain_effect ) : ?>

            <img id="ut-rain-background" src="<?php echo $ut_hero_rain_effect; ?>" alt="rain"/>

        <?php endif; ?>
            
        <?php // Hero Overlay Animation Effect
        if( ut_return_hero_config('ut_hero_overlay_effect') == 'on') : ?>

            <canvas data-strokecolor="<?php echo ut_hex_to_rgb( $ut_effect_color ); ?>" id="ut-animation-canvas"></canvas>

        <?php endif; ?>

        <div class="grid-container">
            
            <!-- start hero-holder -->
            <div class="hero-holder ut-split-hero grid-100 mobile-grid-100 tablet-grid-100 <?php echo $ut_hero_split_content_type == 'form' ? 'ut-hero-highlighted-with-form' : '' ; ?> <?php echo ut_return_hero_config('ut_hero_style' , 'ut-hero-style-1'); ?>">
                
                <!-- start hero-inner -->
                <div class="hero-inner" style="text-align:<?php echo ut_return_hero_config('ut_hero_align' , 'center'); ?>;">
                    
                    <div class="ut-hero-highlighted-header">
                        
                        <!-- caption animation group -->
                        <?php if( $ut_hero_animation_element_group ) : ?> <div class="<?php echo $ut_hero_animation_element_group; ?>"> <?php endif; ?>
                        
                        <!-- caption animation split group -->
                        <?php if( $ut_hero_animation_element_group_split ) : ?> <div class="ut-hero-animation-element ut-hero-animation-element-upper"> <?php endif; ?>
                        
                            <?php if( !empty( $ut_custom_slogan ) ) : ?>
                        
                                <div class="<?php echo $ut_hero_animation_element_single; ?>">
                        
                                    <?php echo do_shortcode( ut_translate_meta( $ut_custom_slogan ) ); ?>
                                    
                                </div>    

                            <?php endif; ?>

                            <?php if( !empty( $ut_custom_logo  ) ) : ?>

                                <div class="ut-hero-custom-logo-holder">
                                    <img class="<?php echo $ut_hero_animation_element_single; ?>" src="<?php echo esc_url( $ut_custom_logo  ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
                                </div>

                            <?php endif; ?>

                            <?php if( !empty($ut_expertise_slogan) ) : ?>

                                <div class="hdh">
                                    <span class="hero-description <?php echo $ut_hero_animation_element_single; ?>">
                                        <?php echo do_shortcode( nl2br( $ut_expertise_slogan ) ); ?>
                                    </span>
                                </div>

                            <?php endif; ?>

                            <?php if( !empty( $ut_company_slogan ) ) : ?>

                                <div class="hth">
                                    <h1 class="hero-title <?php echo $ut_hero_animation_element_single; ?> element-with-custom-line-height <?php echo ut_collect_option( 'ut_caption_slogan_glow', 'off' ) == 'on' ? 'ut-glow' : ''; ?>">
                                        <?php echo do_shortcode( nl2br( $ut_company_slogan ) ); ?>
                                    </h1>
                                </div>

                            <?php endif; ?>
                        
                        <?php if( $ut_hero_animation_element_group_split ) : ?> </div> <?php endif; ?>        
                        <!-- caption animation split group end -->

                        <!-- caption animation split group -->
                        <?php if( $ut_hero_animation_element_group_split ) : ?> <div class="ut-hero-animation-element ut-hero-animation-element-lower"> <?php endif; ?>
                                                
                            <?php if( !empty( $ut_catchphrase ) ) : ?>

                                <div class="hdb">
                                    <span class="hero-description-bottom <?php echo $ut_hero_animation_element_single; ?>">
                                        <?php echo do_shortcode( nl2br( $ut_catchphrase ) ); ?>
                                    </span>
                                </div>

                            <?php endif; ?>

                            <?php ut_hero_buttons(); ?>
                        
                        <?php if( $ut_hero_animation_element_group_split ) : ?> </div> <?php endif; ?>
                        <!-- caption animation split group end -->
                        
                        <?php if( $ut_hero_animation_element_group ) : ?> </div> <?php endif; ?>
                        <!-- caption animation group end -->
                    
                    </div>
                    
                    <div class="ut-hero-highlighted-item">

                        <?php if( $ut_hero_split_content_type == 'image' && !empty( $ut_hero_split_image ) ) : 
                        
                            $dataeffect = $animated = '';

                            if( !empty( $ut_hero_split_image_effect ) && $ut_hero_split_image_effect !='none' ) {

                                $dataeffect = 'data-effect="' . $ut_hero_split_image_effect . '"';
                                $animated   = 'ut-animate-element animated';                                    

                            } ?>

                            <div class="ut-split-image">
                                <img class="<?php echo $animated; ?>" <?php echo $dataeffect; ?> alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" src="<?php echo esc_url( $ut_hero_split_image ); ?>" />
                            </div>

                        <?php endif; ?>

                        <?php if( $ut_hero_split_content_type == 'video' && !empty( $ut_hero_split_video ) ) : 
                            
                            $style = ( $ut_hero_split_video_box == 'on' ) ? 'ut-hero-video-' . $ut_hero_split_video_box_style : ''; ?>

                            <div class="ut-hero-video <?php echo $ut_hero_split_video_box == 'on' ? 'ut-hero-video-boxed' : ''; ?> <?php echo $style; ?>">
                                <div class="ut-video">
                                    <?php echo do_shortcode( $ut_hero_split_video ); ?>
                                </div>
                            </div>

                        <?php endif; ?>

                        <?php if( $ut_hero_split_content_type == 'form' && !empty( $ut_hero_split_form ) ) : ?>

                            <div class="ut-hero-form light">
                                <?php echo do_shortcode($ut_hero_split_form); ?>
                            </div>

                        <?php endif; ?>

                    </div>
                    
                </div>
                <!-- close hero-inner -->
                
                <?php if( ut_collect_option('ut_scroll_down_arrow' , 'off') == 'on' ) : ?>

                    <div class="hero-down-arrow-wrap">

                        <span class="hero-down-arrow">

                            <a href="#ut-to-first-section"><i class="Bklyn-Core-Down-3"></i></a>

                        </span>

                    </div>

                <?php endif; ?>

            </div>
            <!-- close hero-holder -->

        </div>

        <?php // rain sound effect for hero
            
        if( ut_return_hero_config('ut_hero_rain_effect' , 'off') == 'on' && ut_return_hero_config('ut_hero_rain_sound' , 'off') == 'on' ) : ?>

            <a id="ut-hero-rain-audio" href="#" data-mp3="<?php echo THEME_WEB_ROOT; ?>/sounds/heavyrain.mp3" class="ut-audio-control ut-mute"></a>

        <?php endif; ?>


    <?php // End Hero Overlay Container
            
    if( ut_return_hero_config('ut_hero_overlay') == 'on') : ?>
        
        <?php // bottom separator needs to be in overlay if active
            
        if( ut_return_hero_config( 'ut_hero_separator_bottom', 'off' ) == 'on' ) : ?>
    
            <?php echo ut_create_section_separator( 'hero', 'bottom', ut_return_hero_config( 'ut_hero_separator_svg_bottom', 'design_wave' ) ); ?>

        <?php endif; ?>    
            
        </div>

    <?php endif; ?>

    <div data-section="top" class="ut-scroll-up-waypoint"></div>
    
    <?php if( ut_return_hero_config( 'ut_hero_separator_bottom', 'off' ) == 'on' && ut_return_hero_config('ut_hero_overlay') == 'off' ) : ?>
    
        <?php echo ut_create_section_separator( 'hero', 'bottom', ut_return_hero_config( 'ut_hero_separator_svg_bottom', 'design_wave' ) ); ?>
    
    <?php endif; ?>
    
    <?php if( ut_return_hero_config( 'ut_hero_fancy_border' ) == 'on') : ?>

        <div class="ut-fancy-border"></div>

    <?php endif; ?>
    
</section>
<!-- end hero section -->