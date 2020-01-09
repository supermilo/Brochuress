<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * The Template for displaying Tab Hero
 *
 * @author      United Themes
 * @package     Brooklyn
 * @version     3.0
 */

$hero_classes = array();

/* 
 * template config: hero intro animation
 */

$hero_classes[]  = ut_collect_option( 'ut_hero_image_animation_effect', 'heroFadeIn' );

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
 * template config: tabs
 */

$ut_tabs          = ut_return_hero_config( 'ut_tabs' );
$ut_tabs_headline = ut_return_hero_config( 'ut_tabs_headline' );


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
 * template config: tablet color and shadow
 */

$ut_tabs_tablet_color  = ut_return_hero_config( 'ut_tabs_tablet_color', 'black' );
$ut_tabs_tablet_shadow = ut_return_hero_config( 'ut_tabs_tablet_shadow', 'off' ) == 'on' ? 'shadow' : ''; ?>

<!-- Hero Section -->
<section id="ut-hero" class="hero ha-waypoint parallax-section parallax-background <?php echo implode( " " , $hero_classes ); ?>" data-animate-up="ha-header-hide" data-animate-down="ha-header-hide">
    
    <div id="ut-hero-early-waypoint" class="ut-early-waypoint" data-animate-up="ha-header-hide" data-animate-down="ha-header-small"></div>
    
    <div class="parallax-scroll-container hero-parallax-scroll-container parallax-scroll-container-hide <?php echo ut_return_hero_config('ut_hero_image_parallax') == 'off' ? 'parallax-scroll-container-disabled' : ''; ?>" data-parallax-bottom data-parallax-factor="8">
        
        <div class="parallax-image-container"></div>
        
    </div>
    
    <?php // Hero Overlay Animation Effect
    
    if( ut_return_hero_config('ut_hero_overlay_effect') == 'on') : ?>

        <canvas data-strokecolor="<?php echo ut_hex_to_rgb( $ut_effect_color ); ?>" id="ut-animation-canvas"></canvas>

    <?php endif; ?>

    <?php // overlay effect for hero 
    if( ut_return_hero_config('ut_hero_overlay') == 'on') : ?>

        <div class="parallax-overlay <?php echo ut_return_hero_config( 'ut_hero_overlay_pattern', 'on' ) == 'on' ? 'parallax-overlay-pattern' : ''; ?> <?php echo ut_return_hero_config('ut_hero_overlay_pattern_style' , 'style_one'); ?>">

    <?php endif; ?>

        <div class="grid-container">

            <!-- hero holder -->
            <div class="hero-holder ut-half-height grid-100 mobile-grid-100 tablet-grid-100 <?php echo ut_return_hero_config('ut_hero_style' , 'ut-hero-style-1'); ?>">
                
                <div class="hero-inner" style="text-align:<?php echo ut_return_hero_config('ut_hero_align' , 'center'); ?>;">
                    
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

                </div>
            </div>
            <!-- close hero-holder -->

            <div class="ut-tablet-holder ut-half-height hide-on-mobile">

                <div class="ut-tablet-inner">

                    <div class="grid-40 suffix-5 mobile-grid-100 tablet-grid-40 tablet-suffix-5">

                        <?php if( !empty( $ut_tabs_headline  ) ) : ?>

                        <h2 class="ut-tablet-title">
                            <?php echo ut_translate_meta( $ut_tabs_headline  ); ?>
                        </h2>

                        <?php endif;?>

                        <?php if( !empty($ut_tabs) && is_array($ut_tabs) ) : ?>

                        <ul class="ut-tablet-nav">

                            <?php $counter = 1; foreach($ut_tabs as $tab) : ?>

                            <?php if( !empty( $tab['title'] ) ) : ?>

                            <li class="<?php echo ( $counter == 1 ) ? 'selected' : ''; ?>">
                                <a href="#">
                                    <?php echo ut_translate_meta( $tab['title'] ); ?>
                                </a>
                            </li>

                            <?php endif; ?>

                            <?php $counter++; endforeach; ?>

                        </ul>

                        <?php endif; ?>

                    </div>

                    <div class="grid-55 mobile-grid-100 tablet-grid-55">

                        <?php if( !empty($ut_tabs) && is_array($ut_tabs) ) : ?>

                        <ul class="ut-tablet <?php echo esc_attr( $ut_tabs_tablet_color ); ?> <?php echo esc_attr( $ut_tabs_tablet_shadow ); ?>">

                            <?php $counter = 1; foreach( $ut_tabs as $tab ) : ?>

                            <li class="<?php echo ($counter == 1) ? 'show' : ''; ?>">

                                <?php 
                                
                                $tab_image = ut_resize( ut_translate_meta( $tab['image'] ) , '800' , '800', true , true , true ); 
                                
                                if( !$tab_image && function_exists( 'vc_asset_url' ) ) {
                                
                                    $tab_image = vc_asset_url( 'vc/no_image.png' );    
                                
                                }
                                
                                ?>

                                <img src="<?php echo $tab_image; ?>" alt="<?php echo $tab['title']; ?>">

                                <div class="ut-tablet-overlay">

                                    <div class="ut-tablet-overlay-content-wrap">

                                        <div class="ut-tablet-overlay-content">

                                            <?php if( !empty( $tab['title'] ) ) : ?>

                                            <h2 class="ut-tablet-single-title">
                                                <?php echo ut_translate_meta( $tab['title'] ); ?>
                                            </h2>

                                            <?php endif; ?>

                                            <?php if( !empty( $tab['description'] ) ) : ?>

                                            <p class="ut-tablet-desc">
                                                <?php echo ut_translate_meta( $tab['description'] ); ?>
                                            </p>

                                            <?php endif; ?>

                                            <?php if( !empty( $tab['link_one_text'] ) ) : ?>

                                            <a class="ut-btn ut-left-tablet-button theme-btn small round" href="<?php echo ut_translate_meta( $tab['link_one_url'] ); ?>">
                                                <?php echo ut_translate_meta( $tab['link_one_text'] ); ?>
                                            </a>

                                            <?php endif; ?>

                                            <?php if( !empty( $tab['link_two_text'] ) ) : ?>

                                            <a class="ut-btn ut-right-tablet-button theme-btn small round" href="<?php echo ut_translate_meta( $tab['link_two_url'] ); ?>">
                                                <?php echo ut_translate_meta( $tab['link_two_text'] ); ?>
                                            </a>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                </div>

                            </li>

                            <?php $counter++; endforeach; ?>

                        </ul>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

    <?php // End Hero Overlay Container
        
    if( ut_return_hero_config('ut_hero_overlay') == 'on') : ?>

    </div>

    <?php endif; ?>

    <?php if( ut_collect_option('ut_scroll_down_arrow' , 'off') == 'on' ) : ?>

        <div class="hero-down-arrow-wrap">

            <span class="hero-down-arrow">

                <a href="#ut-to-first-section"><i class="Bklyn-Core-Down-3"></i></a>

            </span>

        </div>

    <?php endif; ?>

    <div data-section="top" class="ut-scroll-up-waypoint"></div>

</section>
<!-- end hero section -->