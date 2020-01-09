<?php


class UT_Maintenance_Mode {
    
    /**
	 * Current Page
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      string    $current_page
	 */
	
    private $page;    
    

    public function __construct() {
        
        global $pagenow;
        
        $this->page = $pagenow;
        
        /* run actions */
        $this->run_actions();        
    
    }
    
    public function run_actions() {
        
        if ( $this->page !== 'wp-login.php' && ! current_user_can( 'manage_options' ) && ! is_admin() ) {
            
            add_action( 'wp_loaded', array( &$this , 'output' ) );
            add_filter( 'ut_maintenance_mode_active' , '__return_true');
                        
        }       
    
    }
    
    public function output() { 
        
		$hero_classes 	= array();
		
		/* 
		 * template config: content width and align
		 */

		$hero_classes[]  = ot_get_option( 'ut_maintenance_hero_width', 'centered' ) == 'fullwidth' ? 'ut-hero-custom' : '';
		$ut_hero_v_align = ot_get_option( 'ut_maintenance_hero_v_align', 'middle' ) == 'bottom' ? 'ut-hero-bottom' : '';
		
		/* 
		 * template config: Mode Text
		 */
			
		$ut_maintenace_mode_text = ot_get_option( 'ut_maintenace_mode_text', esc_html__( 'Maintenance Mode', 'unitedthemes' ) );			
			
        ?>

        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
        
            <head>
                
                <meta charset="<?php bloginfo( 'charset' ); ?>">
                <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
                    
                <?php ut_meta_theme_hook(); ?>
                <meta name="description" content="<?php bloginfo('description'); ?>">        
                
                <!-- RSS & Pingbacks -->
                <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
                <link rel="profile" href="http://gmpg.org/xfn/11">
                
                <!-- Favicon -->
                <?php ut_favicon(); ?>    
                
                <?php wp_head(); ?>
                
            </head>
        
            <body id="ut-sitebody" <?php body_class(); ?> data-scrolleffect="<?php ut_scroll_effect(); ?>" data-scrollspeed="<?php echo ot_get_option( 'ut_scrollto_speed', '1000' ); ?>">
    
                <section id="ut-hero" class="hero ha-waypoint parallax-section parallax-background <?php echo implode( " " , $hero_classes ); ?>" data-animate-up="ut-header-hide" data-animate-down="ut-header-hide">
    
                    <div class="parallax-scroll-container"></div>
                    
						<?php ut_before_hero_content_hook(); ?> 
					
						<div class="grid-container">
					
							<!-- hero holder -->
							<div class="hero-holder grid-100 mobile-grid-100 tablet-grid-100 <?php echo ut_return_hero_config('ut_hero_style' , 'ut-hero-style-1'); ?> hero-holder-align-items-<?php echo ot_get_option('ut_maintenance_hero_v_align', 'middle'); ?>">

								<div class="hero-inner ut-hero-custom-<?php echo ot_get_option( 'ut_maintenance_hero_align' , 'center' ); ?> <?php echo $ut_hero_v_align; ?>" style="text-align:<?php echo ot_get_option('ut_maintenance_hero_align' , 'center'); ?>;">

									<div class="hth">
										<h1 class="hero-title"><?php echo $ut_maintenace_mode_text; ?></h1>
									</div>

									<div class="hdb">

										<span class="hero-description-bottom">

											<a style="font-weight: 400; margin-top: 30px;" class="hero-btn default" href="<?php echo wp_login_url(); ?>" title=""><?php _e( 'Sign in to Dashboard', 'unitedthemes' ); ?></a>

										</span>

									</div>

								</div>

							</div>
							<!-- close hero-holder -->
						
						</div>	
							
						<?php ut_after_hero_content_hook(); ?>
						
                </section>
                <!-- end hero section -->
                        
            </body>        

        </html>        
        
        <?php
            
        die();
    
    }

}

if( ot_get_option( 'ut_maintenace_mode', 'off' ) == 'on' ) {
    
    new UT_Maintenance_Mode;

}