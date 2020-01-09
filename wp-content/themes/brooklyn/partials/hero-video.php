<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * The Template for displaying Video Hero
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
 * template config: video player 
 */
$ut_video_mute_button = ut_return_hero_config( 'ut_video_mute_button', 'hide' );
$ut_video_mute_state  = ut_return_hero_config( 'ut_video_mute_state', 'off' );
$ut_video_source      = ut_return_hero_config( 'ut_video_source', 'youtube' );

if( !empty( $ut_video_source ) && $ut_video_source == 'custom' ) {
    
    $hero_classes[] = 'ut-single-video';
    
} 

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
    
} ?>

<!-- hero section -->
<section id="ut-hero" class="hero ha-waypoint parallax-section parallax-background <?php echo implode( " " , $hero_classes ); ?>" data-animate-up="ha-header-hide" data-animate-down="ha-header-hide">
    
    <div id="ut-hero-early-waypoint" class="ut-early-waypoint" data-animate-up="ha-header-hide" data-animate-down="ha-header-small"></div>
    
    <?php // Hero Top Separator
    
    if( ut_return_hero_config( 'ut_hero_separator_top', 'off' ) == 'on' && ut_return_hero_config('ut_hero_overlay') == 'off' ) : ?>
    
        <?php echo ut_create_section_separator( 'hero', 'top', ut_return_hero_config( 'ut_hero_separator_svg_top', 'design_wave' ) ); ?>
    
    <?php endif; ?> 
    
	<div class="parallax-scroll-container hero-parallax-scroll-container parallax-scroll-container-disabled" data-parallax-bottom data-parallax-factor="8"></div>	
	
    <?php // Hero Background Video
    
    echo ut_create_bg_videoplayer('section'); ?>
    
    <?php // Start Hero Overlay Container 
    
    if( ut_return_hero_config('ut_hero_overlay') == 'on' ) : ?>
        
        <div class="parallax-overlay <?php echo ut_return_hero_config( 'ut_hero_overlay_pattern', 'on' ) == 'on' ? 'parallax-overlay-pattern' : ''; ?> <?php echo ut_return_hero_config('ut_hero_overay_pattern_style' , 'style_one'); ?> <?php echo ( !empty( $ut_video_source ) && $ut_video_source == 'selfhosted' && !unite_mobile_detection()->isMobile() && ut_return_hero_config('ut_video_containment' , 'hero') == 'hero' ) ? 'ut-hero-video-position' : ''; ?>">
        
        <?php // top separator needs to be in overlay if active
    
        if( ut_return_hero_config( 'ut_hero_separator_top', 'off' ) == 'on' ) : ?>

            <?php echo ut_create_section_separator( 'hero', 'top', ut_return_hero_config( 'ut_hero_separator_svg_top', 'design_wave' ) ); ?>

        <?php endif; ?>     
            
    <?php elseif( ut_return_hero_config('ut_hero_overlay') == 'off' && !empty( $ut_video_source ) && $ut_video_source == 'selfhosted' && !unite_mobile_detection()->isMobile() ) :?>

        <div class="ut-hero-video-position">

    <?php endif; ?>

            <?php // Hero Content only for supported Video Format not for embed videos
            
            if( $ut_video_source != 'custom' ) : ?>
            
                <?php // Hero Overlay Animation Effect

                if( ut_return_hero_config('ut_hero_overlay_effect') == 'on') : ?>

                        <canvas data-strokecolor="<?php echo ut_hex_to_rgb($ut_effect_color); ?>" id="ut-animation-canvas"></canvas>

                <?php endif; ?>

                <div class="grid-container">
                    
                    <!-- start hero-holder -->
                    <div class="hero-holder grid-100 mobile-grid-100 tablet-grid-100 <?php echo ut_return_hero_config('ut_hero_style' , 'ut-hero-style-1'); ?> hero-holder-align-items-<?php echo ut_return_hero_config('ut_hero_v_align', 'middle'); ?>">
                        
                        <!-- start hero-inner -->
                        <div class="hero-inner ut-hero-custom-<?php echo ut_return_hero_config('ut_hero_align' , 'center'); ?> <?php echo $ut_hero_v_align; ?>" style="text-align:<?php echo ut_return_hero_config('ut_hero_align' , 'center'); ?>;">
                            
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

                                <?php if( !empty( $ut_expertise_slogan ) ) : ?>

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
                                            <?php echo do_shortcode( nl2br( ut_translate_meta( $ut_catchphrase ) ) ); ?>
                                        </span>
                                    </div>

                                <?php endif; ?>

                                <?php ut_hero_buttons(); ?>
                            
                            <?php if( $ut_hero_animation_element_group_split ) : ?> </div> <?php endif; ?>
                            <!-- caption animation split group end -->

                            <?php if( $ut_hero_animation_element_group ) : ?> </div> <?php endif; ?>
                            <!-- caption animation group end -->
                            
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

            <?php endif; ?>            
            
        <?php // Video Controls

        if( $ut_video_mute_button == 'show' && $ut_video_source != 'custom' ) : ?>

        <?php $mute = ( $ut_video_mute_state == "on" ) ? 'ut-mute' : 'ut-unmute'; ?>

            <a id="ut-video-hero-control" data-for="ut-video-hero" href="#" class="ut-video-control <?php echo $ut_video_source; ?> <?php echo $mute; ?>"></a>

        <?php endif; ?>

    <?php // End Hero Overlay Container 

    if( ut_return_hero_config('ut_hero_overlay') == 'on') : ?>
        
        <?php // bottom separator needs to be in overlay if active
            
        if( ut_return_hero_config( 'ut_hero_separator_bottom', 'off' ) == 'on' ) : ?>
    
            <?php echo ut_create_section_separator( 'hero', 'bottom', ut_return_hero_config( 'ut_hero_separator_svg_bottom', 'design_wave' ) ); ?>

        <?php endif; ?>    
            
        </div>

    <?php elseif( ut_return_hero_config('ut_hero_overlay') == 'off' && !empty($ut_video_source) && $ut_video_source == 'selfhosted') :?>

        </div>

    <?php endif; ?>

    <div data-section="top" class="ut-scroll-up-waypoint"></div>

    <?php // bottom separator
    
    if( ut_return_hero_config( 'ut_hero_separator_bottom', 'off' ) == 'on' && ut_return_hero_config('ut_hero_overlay') == 'off' ) : ?>
    
        <?php echo ut_create_section_separator( 'hero', 'bottom', ut_return_hero_config( 'ut_hero_separator_svg_bottom', 'design_wave' ) ); ?>
    
    <?php endif; ?>
    
    <?php if( ut_return_hero_config( 'ut_hero_fancy_border' ) == 'on') : ?>

        <div class="ut-fancy-border"></div>

    <?php endif; ?>

</section>
<!-- end hero section -->