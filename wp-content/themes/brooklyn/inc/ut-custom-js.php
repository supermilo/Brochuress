<?php

/*
 * Custom Javascript from Option Panel
 * by www.unitedthemes.com
 *
 * This file is deprecated and will be merged with unite-custom/ut-theme-custom-js.php
 * Most of the JS inside this file is deprecated as well 
 */


if ( !function_exists( 'ut_compress_java' ) ) {

	function ut_compress_java($buffer) {
		
		/* remove comments */
		$buffer = preg_replace("/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/", "", $buffer);
		/* remove tabs, spaces, newlines, etc. */
		$buffer = str_replace(array("\r\n","\r","\t","\n",'  ','    ','     '), '', $buffer);
		/* remove other spaces before/after ) */
		$buffer = preg_replace(array('(( )+\))','(\)( )+)'), ')', $buffer);
	
		return $buffer;
		
	}

}

add_filter( 'ut-custom-js' , 'ut_compress_java' );





if ( !function_exists( 'ut_needed_js' ) ) {
    
    function ut_needed_js() { 
        
		$accentcolor  = get_option('ut_accentcolor' , '#CC5E53');
		$ut_hero_type = ut_return_hero_config('ut_hero_type');
        
        // fallback
        $ut_hero_type = $ut_hero_type == 'dynamic' ? 'image' : $ut_hero_type;
        
        
        $js = '(function($){
        	
				"use strict";
		
				$(document).ready(function(){ ';
			    
				/*
				|--------------------------------------------------------------------------
				| Pre Loader
				|--------------------------------------------------------------------------
				*/
                
                if( ot_get_option('ut_use_image_loader') == 'on' ) :
					
					if( ut_dynamic_conditional('ut_use_image_loader_on') ) : 
					
						/* settings for pre loader */
						$loadercolor = ot_get_option( 'ut_image_loader_color' );
						$barcolor = ot_get_option( 'ut_image_loader_bar_color' , $accentcolor );
						$loader_bg_color = ot_get_option('ut_image_loader_background' , '#FFF');
						$bar_height = ot_get_option('ut_image_loader_barheight', 3 );
						$ut_show_loader_bar = ot_get_option('ut_show_loader_bar' , 'on');
																
						if( unite_mobile_detection()->isMobile() ) :
							
							$js .= 'window.addEventListener("DOMContentLoaded", function() {
															
								$("body").queryLoader2({
									showbar: "'.$ut_show_loader_bar.'",					
									barColor: "'.$barcolor.'",
									textColor: "'.$loadercolor.'",
									backgroundColor: "'.$loader_bg_color.'",
									barHeight: '.$bar_height.',
									percentage: true,						
									completeAnimation: "fade",
									minimumTime: 500,
                                    onComplete : function() {
									    
								        $(".ut-loader-overlay:not(.ut-loader-overlay-with-morph)").fadeOut( 800 , "easeInOutExpo" , function() {
										
										    // if morph check morph files
										    preloader_settings.loader_active = false;
										        	
											$(this).remove();
                                            $.force_appear();
											
										});
										
										if( $(".ut-close-query-loader").length ) {
											
											$(".ut-close-query-loader").trigger("click");
											$.force_appear();
										
										}
										
									}
									
								});
							});';
							
						else :
						
							$js .= '$("body").queryLoader2({						
								showbar: "'.$ut_show_loader_bar.'",			
								barColor: "'.$barcolor.'",
								textColor: "'.$loadercolor.'",
								backgroundColor: "'.$loader_bg_color.'",
								barHeight: '.$bar_height.',
								percentage: true,						
								completeAnimation: "fade",
								minimumTime: 500,
                                onComplete : function() {
								    								    
									$(".ut-loader-overlay:not(.ut-loader-overlay-with-morph)").fadeOut( 800 , "easeInOutExpo" , function() {
										
										// if morph check morph files
										preloader_settings.loader_active = false;
										
										$(this).remove();
                                        $.force_appear();
                                        
									});
									
									if( $(".ut-close-query-loader").length ) {
										
										$(".ut-close-query-loader").trigger("click");
										$.force_appear();

									}
                                    
								}
								
							});';
							
						endif;

                	endif;

                endif;
        
				/*
				|--------------------------------------------------------------------------
				| Slider Settings Hook
				|--------------------------------------------------------------------------
				*/ 
				if( apply_filters( 'ut_show_hero', false ) && ( $ut_hero_type == 'slider' || is_singular("portfolio") && get_post_format() == 'gallery' ) ) : 
           			
                    $animation		= ut_return_hero_config('ut_background_slider_animation' , 'fade');
					$slideshowSpeed = ut_return_hero_config('ut_background_slider_slideshow_speed' , 7000);
					$animationSpeed = ut_return_hero_config('ut_background_slider_animation_speed' , 600);					
                    
                    if( is_singular("portfolio") ) {
                        
                        $animation		= 'fade';
						$slideshowSpeed = '7000';
						$animationSpeed = '600';
                    
                    }
                     
                 ob_start(); ?>

                 <script>

				 $(window).load(function(){
					 
					 var $hero_captions = $("#ut-hero-captions"),
					 	 animatingTo = 0;
					 
					 $hero_captions.find(".hero-holder").each(function() {						
						
						var pos = $(this).data("animation"),
							add = "-50%";
						
						if( pos==="left" || pos==="right" ) { add = "-25%" };						
						
						$(this).css( pos , add );	
												
					 });
					 
                     function run_flowtype() {
                        
                        if( $(".hero-description", "#ut-hero").length ) {
                        
                             $(".hero-description", "#ut-hero").each(function(){
                                
                                if( $(this).css("font-size") ) {
                                    
                                    var hero_dt_max_font = $(this).css("font-size").replace("px","");
                                    
                                    $(this).flowtype({
                                        maxFont: hero_dt_max_font,
                                        fontRatio : 24,
                                        minFont: 10
                                    });                                    
                                
                                }                             
                             
                             });

                        }
                        
                        
                        if( $(".hero-title", "#ut-hero").length ) {
                            
                            $(".hero-title", "#ut-hero").each(function(){
                            
                                if( $(this).css("font-size") ) {

                                    var hero_title_max_font = $(this).css("font-size").replace("px","");
                                    
                                    $(this).flowtype({
                                        maxFont: hero_title_max_font,
                                        fontRatio : $(this).text().trim().replace(/[\s]+/g, " ").split(" ").length,
                                        minFont: 40
                                    });

                                }
                                
                            });

                        }
                        
                        if( $(".hero-description-bottom", "#ut-hero").length ) {
                            
                            $(".hero-description-bottom", "#ut-hero").each(function(){
                            
                                if( $(this).css("font-size") ) {

                                    var hero_db_max_font = $(this).css("font-size").replace("px","");
                                    
                                    $(this).flowtype({
                                        maxFont: hero_db_max_font,
                                        fontRatio : 24,
                                        minFont: 12
                                    });

                                }
                                
                            });
                            

                        }
                     
                    }



                    $(document.body).on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', '#ut-hero-captions', function() {

                        $hero_captions.flexslider({
                            animation: "fade",
                            animationSpeed: <?php echo $animationSpeed; ?>,
                            slideshowSpeed: <?php echo $slideshowSpeed; ?>,
                            controlNav: false,
                            directionNav: false,
                            animationLoop: true,
                            slideshow: true,
                            init : function(){

                                run_flowtype();

                            },
                            before: function(slider){

                                /* hide hero holder */
                                $(".flex-active-slide").find(".hero-holder").fadeOut("fast", function() {

                                    var pos = $(this).data("animation"),
                                        anim = { opacity: 0 , display : "table" },
                                        add = "-50%";

                                    if( pos==="left" || pos==="right" ) { add = "-25%" };

                                    anim[pos] = add;

                                    $(this).css(anim);

                                });

                                /* animate background slider */
                                $("#ut-hero-slider").flexslider(slider.animatingTo);

                            },
                            after: function(slider) {

                                /* change position of caption slider */
                                slider.animate( { top : ( $(window).height() - $hero_captions.find(".flex-active-slide").height() ) / 2 } , 100 , function() {

                                    /* show hero holder */
                                    var pos = $(".flex-active-slide").find(".hero-holder").data("animation"),
                                        anim = { opacity: 1 };

                                    anim[pos] = 0;

                                    $(".flex-active-slide").find(".hero-holder").animate( anim );

                                });

                            },
                            start: function(slider) {

                                /* create external navigation */
                                $(".ut-flex-control").click(function(event){

                                    if ($(this).hasClass("next")) {

                                        slider.flexAnimate(slider.getTarget("next"), true);

                                    } else {

                                        slider.flexAnimate(slider.getTarget("prev"), true);

                                    }

                                    event.preventDefault();

                                });

                                /* change position of caption slider */
                                slider.animate( { top : ( $(window).height() - $hero_captions.find(".flex-active-slide").height() ) / 2 } , 100 , function() {

                                    /* show hero holder */
                                    var pos = $(".flex-active-slide").find(".hero-holder").data("animation"),
                                        anim = { opacity: 1 };

                                    anim[pos] = 0;

                                    $(".flex-active-slide").find(".hero-holder").animate( anim );


                                });

                            }

                        });

                    });

                    var ut_trigger = 0;
                    
					$(window).utresize(function(){
                        
                        /* do not fire on window load resize event */    
                        if( ut_trigger > 0 ) {
                        
                            /* adjust first slide browser bug */
                            $hero_captions.find(".hero-holder").each(function() {
                                
                                $(this).find(".hero-title").width("");
                                
                                if( $(this).width() > $(this).parent().width() ) {
                                    
                                    $(this).find(".hero-title").width( $(this).parent().width()-20 );
                                
                                }
                            
                            });
                            
                            /* change slide */
                            $hero_captions.flexslider("next");
                            $hero_captions.flexslider("play");
                        
                        }
                        
                        ut_trigger++;
                            
					});

                    $("#ut-hero-slider").flexslider({
						animation: "fade",
                        animationSpeed: <?php echo $animationSpeed; ?>,
                        slideshowSpeed: <?php echo $slideshowSpeed; ?>,
                        directionNav: false,
						controlNav: false,
    					animationLoop: true,
                        slideshow: true
					});
                                        
				});

				</script>

                <?php

                $slider_js = str_replace( array('<script>', '</script>'), '', ob_get_clean() );

                // attach to JS
                $js .= $slider_js;

                endif;
				 
				/*
				|--------------------------------------------------------------------------
				| Section Animation
				|--------------------------------------------------------------------------
				*/
								
				if( !unite_mobile_detection()->isMobile() && ot_get_option('ut_animate_sections' , 'on') == 'on' && ot_get_option( 'ut_site_layout', 'multisite' ) == 'onepage' ) :
						
						$csection_timer = ot_get_option('ut_animate_sections_timer' , '1600');
						
						$js .= '$("section").each(function() {
															
							var outerHeight = $(this).outerHeight(),
								offset		= "90%",
								effect		= $(this).data("effect");
							
							if( outerHeight > $(window).height() / 2 ) {
								offset = "70%";
							}
							
                            $(this).waypoint("destroy");
							$(this).waypoint( function( direction ) {
								
								var $this = $(this);
												
								if( direction === "down" && !$(this).hasClass( "animated-" + effect ) ) {
									
									$this.find(".section-content").animate( { opacity: 1 } , ' . $csection_timer . ' );
									$this.find(".section-header-holder").animate( { opacity: 1 } , ' . $csection_timer . ' );
								    
                                    $this.addClass( "animated-" + effect );
                                    		
								}
								
							} , { offset: offset } );			
								
						});';             
            	
				endif;
					                
            $js .= '});
			
        })(jQuery);';
		        
        //echo $js;
		echo apply_filters( 'ut-custom-js' , $js );
                
    }
    
    add_action( 'ut_java_footer_hook', 'ut_needed_js', 100 );

}