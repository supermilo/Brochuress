<?php if (!defined('UT_VERSION')) {
    exit; // exit if accessed directly
}

/**
 * Custom JavaScript Class
 * 
 * 
 * @package Brooklyn Theme
 * @author United Themes
 * since 4.4
 */

if( !class_exists( 'UT_Custom_JS' ) ) {	
    
    class UT_Custom_JS {
        
        public $js;
        
        function __construct() {
            
            add_action( 'wp_head', array( $this, 'header_js' ) ); 
            add_action( 'ut_java_footer_hook', array( $this, 'custom_js' ), 99 );
            
        }        
                
        public function minify_js( $js ) {
            
            $js = str_replace('<script>','', $js);
            $js = str_replace('</script>','', $js);
                        
            if( WP_DEBUG ){
                return $js;                    
            }
            
            // remove comments
            $js = preg_replace("/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/", "", $js);
            
            // remove tabs, spaces, newlines, etc.
            $js = str_replace(array("\r\n","\r","\t","\n",'  ','    ','     '), ' ', $js);
            
            // remove other spaces before/after
            $js = preg_replace(array('(( )+\))','(\)( )+)'), ')', $js);
            
            return $js;
            
        }
        
        public function header_js() {
            
            ob_start(); ?>
                
            <script>
                
            (function($){

                "use strict";
                        
                $("html").removeClass("ut-no-js").addClass("ut-js js");    
                
				<?php if( ot_get_option( 'ut_google_smooth_scroll', 'off' ) == 'on' ) : ?>
							
					if( $.browser.webkit && $.browser.chrome ) {

						SmoothScroll({ 
							frameRate: 150,
							animationTime: 1000,
							stepSize: 175,
							accelerationDelta: 100, 
							accelerationMax: 6,
							pulseScale : 6,
							pulseNormalize : 1,
							fixedBackground : false			
						});

					}						

				<?php endif; ?>				
				
                <?php
                
                /**
                  * Animated Hero Image
                  */           
            
                if( ut_return_hero_config('ut_hero_type', 'image') == 'animatedimage' ) :
                
                    $header_image = ut_return_hero_config('ut_hero_animated_image');
            
                    // animation speed in second
                    $image_speed  = ut_return_hero_config('ut_hero_animated_image_speed', 40);
                    $image_speed  = preg_replace("/[^0-9]/", '', $image_speed);        
            
                    // animation direction
                    $image_direction  = ut_return_hero_config('ut_hero_animated_image_direction', 'left');
                    $direction = $image_direction == 'right' ? '' : '-';
                
                    // alternate 
                    $alternate = ut_return_hero_config( 'ut_hero_animated_image_direction_alternate', 'on' );
            
                    if( !empty( $header_image ) ) :
                    
                        $header_image = ut_get_image_id( $header_image );    
                        $header_image = wp_get_attachment_image_src( $header_image , 'full' );
            
                        if( !empty( $header_image ) && is_array( $header_image ) ) :
            
                    ?>

                    $(document).ready(function(){
                        
                        <?php if( ut_return_hero_config( 'ut_hero_animated_image_size' ) == 'cover' || !ut_return_hero_config( 'ut_hero_animated_image_size' ) && ut_return_hero_config('ut_hero_animated_image_cover', 'off') == 'off' ) : ?>
                        
                            var supportedFlag = $.keyframe.isSupported(),
                                position = $(window).width() < <?php echo $header_image[1]; ?> ? <?php echo $header_image[1]; ?> - $(window).width() : $(window).width();
                        
                            if( $(window).width() < <?php echo $header_image[1]; ?> ) {
                                
                               $('#ut-hero .parallax-scroll-container').addClass('ut-animated-image-background');
                        
                            }
                                      
                        <?php else : ?>
                            
                            var supportedFlag = $.keyframe.isSupported(),
                                position = $(window).width();
                                  
                        <?php endif; ?>                    
                        
                        <?php if( $alternate == 'off' ) : ?>              
                                      
                            $.keyframe.define([{
                                name: 'animatedBackground',
                                media: 'screen and (min-width: 1025px)',
                                '0%':  { 'background-position' : '0 0'},
                                '100%':{ 'background-position' : <?php echo $direction; ?>position+'px 0' },
                            }]);

                            $(window).load(function(){

                                $('#ut-hero .parallax-scroll-container').delay(800).queue(function(){
                                            
                                    $(this).addClass('ut-hero-ready').playKeyframe({
                                        name: 'animatedBackground',
                                        timingFunction: 'linear',
                                        duration: '<?php echo $image_speed; ?>s',
                                        iterationCount: 'infinite'
                                    });

                                });                            

                            });
                    
                        <?php else : ?>    
                        
                           $.keyframe.define([{
                                name: 'animatedBackground',
                                media: 'screen and (min-width: 1025px)',
                                '0%': { 'background-position' : '0 0'},
                                '50%':{ 'background-position' : <?php echo $direction; ?>position+'px 0' },
                                '100%': { 'background-position' : '0 0'}
                            }]);

                            $(window).load(function(){

                                $('#ut-hero .parallax-scroll-container').delay(800).queue(function(){

                                    $(this).addClass('ut-hero-ready').playKeyframe({
                                        name: 'animatedBackground',
                                        timingFunction: 'linear',
                                        duration: '<?php echo $image_speed; ?>s',
                                        iterationCount: 'infinite'
                                    });

                                });                            

                            });
                
                        <?php endif; ?>

                    });                
                
                    <?php endif; ?> 
                
                    <?php endif; ?> 
                
                <?php endif; ?>                
                
				
				<?php 
				
				/**
                  * Hero Area Loading
                  */ 
				
				?>
				
                $.fn.reverse = function() {
                    return this.pushStack(this.get().reverse(), arguments);
                }; 
                
				$(document).ready(function(){
					
                    var $sitebody             = $("#ut-sitebody");
					var wait_for_images       = true;                    
                    
                    // preloader interval check
                    var check_preloader_status = setInterval(function() { 
                        
                        if( typeof preloader_settings != "undefined" && !preloader_settings.loader_active && !wait_for_images ) {
                            
                            $sitebody.addClass("ut-hero-image-preloaded");
                            
                            // delete setInterval
                            clearInterval(check_preloader_status);    
                            
                        } else if( typeof preloader_settings === "undefined" && !wait_for_images ) {
                                  
                            $sitebody.addClass("ut-hero-image-preloaded");
                            
                            // delete setInterval
                            clearInterval( check_preloader_status );
                                  
                        }
                        
                    }, 100 );
                    
                    // fires after hero images have been loaded
                    function start_hero_animation_process( element ) {

                        // by adding this class, the animation process starts
                        $sitebody.addClass("ut-hero-image-animated");
                        
                        <?php // Hero Title Underline Animation
                        if( ut_collect_option( 'ut_hero_caption_animation_type', 'group' ) == 'group_split' ) {
                            
                            // Upper Area
                            $selector = '#ut-hero .ut-hero-animation-element-upper'; 
                            
                        }
                            
                        if( ut_collect_option( 'ut_hero_caption_animation_type', 'group' ) == 'group' ) {
                            
                            // Entire Group
                            $selector = '#ut-hero .hero-inner .ut-hero-animation-element'; 
                            
                        }
            
                        if( ut_collect_option( 'ut_hero_caption_animation_type', 'group' ) == 'single' ) {
                            
                            // Single Element
                            $selector = '#ut-hero .hero-title'; 
                            
                        } ?>
                        
                        $(document.body).on('webkitAnimationStart mozAnimationStart MSAnimationStart oanimationstart animationstart', '<?php echo $selector; ?>', function() {
                            
                            $('#ut-hero .hero-title').delay( <?php echo ut_collect_option( 'ut_hero_caption_animation_effect_timer', '1000' ) / 2; ?> ).queue(function() {
                                        
                                $(this).addClass('hero-title-animated');  

                            });                            
                            
                        });
                        
                        <?php 
            
                        // Execute Hero Fade In and wait 600ms for a better animation experience
                        if( ut_collect_option( 'ut_hero_caption_animation_effect', 'heroFadeIn' ) == 'heroFadeIn' ) : ?>

                            $(element).delay().delay( 600 ).queue(function() {

                        <?php endif; ?>

                            <?php if( ut_collect_option( 'ut_hero_caption_animation_type', 'group' ) == 'group' || ut_collect_option( 'ut_hero_caption_animation_type', 'group' ) == 'group_split' ) : ?>

                                $('#ut-hero .ut-hero-animation-element').not('.hero-down-arrow').addClass('ut-hero-animation-element-start');

                                $('#ut-hero .hero-down-arrow').delay( 200 ).queue(function() {

                                    $(this).addClass('ut-hero-animation-element-start'); 

                                });

                            <?php else : ?>

                                <?php if( strpos( ut_collect_option( 'ut_hero_caption_animation_effect', 'fadeIn' ), 'Down') !== false  || ut_collect_option( 'ut_hero_caption_animation_effect', 'heroFadeIn' ) == 'zoomInUp'  ) : ?>

                                    $('#ut-hero .ut-hero-animation-element').reverse().each( function(index) {

                                <?php else : ?>

                                    $('#ut-hero .ut-hero-animation-element').each( function(index){

                                <?php endif; ?>

                                        var $this = $(this);

                                        if( $this.hasClass("hero-down-arrow") ) {

                                            $this.delay( 200 * ( $('.hero-inner', "#ut-hero").children().length + 1 )  ).queue(function() {

                                                $this.addClass('ut-hero-animation-element-start'); 

                                            });

                                        } else {

                                            $this.delay( <?php echo ut_collect_option( 'ut_hero_caption_animation_effect_timer', '1000' ) * 0.5; ?> * index ).queue(function() {

                                                $this.addClass('ut-hero-animation-element-start').dequeue(); 

                                            });

                                        }

                                    }); 

                            <?php endif; ?>

                        <?php if( ut_collect_option( 'ut_hero_caption_animation_effect', 'heroFadeIn' ) == 'heroFadeIn' ) : ?>

                            }); 

                        <?php endif; ?> 
                        
                    }
                    
                    /* # Image
					================================================== */
                    var $hero_image_container = $(".parallax-scroll-container", "#ut-hero");
                    
					if( $hero_image_container.length ) {

						$hero_image_container.children('.parallax-image-container').waitForImages(function() {

                            wait_for_images = false;

						});                        
                        
						$(document.body).on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', '#ut-hero .parallax-scroll-container', function() {
                            
                            start_hero_animation_process( this );                

						});                        
					
					}

                    /* # Slider
                    ================================================== */
                    var $hero_slider_container = $(".slides", "#ut-hero-slider");

                    if( $hero_slider_container.length ) {

                        $hero_slider_container.find('.parallax-image-container').waitForImages(function() {

                            wait_for_images = false;

                        });

                        $(document.body).on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', '#ut-hero-slider', function() {

                            start_hero_animation_process( this );

                        });

                    }
					
                    /* # Image Fader
					================================================== */
					var $hero_imagefader_container = $(".ut-image-fader li", "#ut-hero");
					
					if( $hero_imagefader_container.length ) {
					
						$hero_imagefader_container.waitForImages(function() {
						
							$sitebody.addClass("ut-hero-image-preloaded");

						});

						$(document.body).on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', '#ut-hero .ut-image-fader', function() {

							start_hero_animation_process( this ); 

						});						
					
					}
					
                    /* # Rain Effect
					================================================== */
					var $hero_rain_background_container = $("#ut-rain-background", "#ut-hero");
					
					if( $hero_rain_background_container.length ) {
					
						$hero_rain_background_container.waitForImages(function() {
						  
							$sitebody.addClass("ut-hero-image-preloaded");

						});

						$(document.body).on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', '#ut-hero canvas', function() {

							start_hero_animation_process( this ); 

						});
					
					}
					
				
				});
				
            })(jQuery);

            </script>    
                
            <?php 
            
            echo '<script type="text/javascript">' . $this->minify_js( ob_get_clean() ) . '</script>';            
            
        }
                
        public function custom_js() {
            
            $ut_hero_type = ut_return_hero_config('ut_hero_type');
            $ut_hero_type = $ut_hero_type == 'dynamic' ? 'image' : $ut_hero_type; // fallback since dynamic header has been removed with 4.4
            
            ob_start(); ?>
                
                <script>
                
				window.matchMedia||(window.matchMedia=function(){

					var c=window.styleMedia || window.media;if(!c) {

						var a=document.createElement("style"),
							d=document.getElementsByTagName("script")[0],
							e=null;

						a.type="text/css";a.id="matchmediajs-test";d.parentNode.insertBefore(a,d);e="getComputedStyle"in window&&window.getComputedStyle(a,null)||a.currentStyle;c={matchMedium:function(b){b="@media "+b+"{ #matchmediajs-test { width: 1px; } }";a.styleSheet?a.styleSheet.cssText=b:a.textContent=b;return"1px"===e.width}}}return function(a){return{matches:c.matchMedium(a|| "all"),media:a||"all"}}

				}());	
					
				/*!
				 * jQuery.utresize
				 * @author UnitedThemes
				 * @version 1.0
				 *
				 */
					
				(function ($, sr) {
					
					"use strict";
					
					var debounce = function (func, threshold, execAsap) {
						var timeout = '';
						return function debounced() {
							var obj = this, args = arguments;
							function delayed() {
								if (!execAsap) {
									func.apply(obj, args);
								}
								timeout = null;
							}

							if (timeout) {
								clearTimeout(timeout);
							} else if (execAsap) {
								func.apply(obj, args);
							}
							timeout = setTimeout(delayed, threshold || 100);
						};
					};
					
					jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
					
				})(jQuery,'utresize');	
					
                (function($){
        	
				    "use strict";
                    
                    $("html").addClass('js');
    				
					if (!String.prototype.includes) {
						
						String.prototype.includes = function(search, start) {
						
							if (typeof start !== 'number') {
								start = 0;
							}

						  	if (start + search.length > this.length) {
								
								return false;
								
						  	} else {
								
								return this.indexOf(search, start) !== -1;
								
							}
							
						};
						
					}
										
					function findLongestWord(str) {
						
						var strSplit = str.split(' ');
					  	var longestWord = 0;
						
					  	for(var i = 0; i < strSplit.length; i++){
							
							if(strSplit[i].length > longestWord) {
								longestWord = strSplit[i].length;								
							}
							
					  	}
						
						return longestWord;
						
					}
					
                    $.fn.flowtype = function(options) {

                        var settings = $.extend({
                            maximum    		 : 9999,
                            minimum    		 : 1,
                            maxFont    		 : 9999,
							lineHeight 		 : false,
                            minFont    		 : 1,
                            fontRatio  		 : 40,
							dynamicFontRatio : false,
                            type             : 'hero',
                            loaded           : ''
                        }, options),

                        changes = function(el) {

                            var $el = $(el);
                                $el.removeAttr('style');

                            if( $el.hasClass('ut-skip-flowtype') ) {
                                return;
                            }

							var ratio_multi = 1;

							// dynamic responsive factor
                            var factor = 1;

                            if( settings.type === 'hero' ) {

                                if( window.matchMedia('(max-width: 767px)').matches ) {

                                    factor = 0.55;

                                } else if( window.matchMedia('(max-width: 1200px)').matches ) {

                                    factor = 0.65;

                                } else if( window.matchMedia('(max-width: 1440px)').matches ) {

                                    factor = 0.75;

                                } else if( window.matchMedia('(max-width: 1680px)').matches ) {

                                    factor = 0.80;

                                } else if( window.matchMedia('(max-width: 1920px)').matches ) {

                                    factor = 0.9;

                                }

                            }

                            var _font_ratio = settings.fontRatio;
                            var font_size_fill = 0;

                            if( settings.type === 'title' || settings.type === 'custom' ) {

                                if( $el.data('maxfont') >= 75 ) {

                                    if( window.matchMedia('(max-width: 1200px)').matches ) {

                                        _font_ratio = 15;

                                        if( settings.type === 'custom' ) {

                                            // will add 10% of the font size calculated to keep visual dominance of large titles
                                            font_size_fill = parseInt( $el.data('maxfont') ) / 10;

                                        }

                                    } else if( window.matchMedia('(max-width: 1440px)').matches ) {

                                        _font_ratio = 12;

                                    } else if( window.matchMedia('(max-width: 1679px)').matches ) {

                                        _font_ratio = 10;

                                    }

                                } else {

                                    if( window.matchMedia('(max-width: 1200px)').matches ) {

                                        _font_ratio = 12;

                                    } else if( window.matchMedia('(max-width: 1679px)').matches ) {

                                        _font_ratio = 8;

                                    }

                                }

                            }

                            var min_font = settings.minFont;
                            var max_font = settings.maxFont;

                            if( settings.type === 'custom' ) {

                                if( $el.is('h1') ) {

                                    min_font = parseInt('<?php echo ut_get_global_font_size('h1'); ?>');

                                } else if( $el.is('h2') ) {

                                    min_font = parseInt('<?php echo ut_get_global_font_size('h2'); ?>');

                                } else if( $el.is('h3') ) {

                                    min_font = parseInt('<?php echo ut_get_global_font_size('h3'); ?>');

                                } else if( $el.is('h4') ) {

                                    min_font = parseInt('<?php echo ut_get_global_font_size('h4'); ?>');

                                } else if( $el.is('h5') ) {

                                    min_font = parseInt('<?php echo ut_get_global_font_size('h5'); ?>');

                                } else if( $el.is('h6') ) {

                                    min_font = parseInt('<?php echo ut_get_global_font_size('h5'); ?>');

                                } else {

                                    min_font = parseInt('<?php echo ut_get_global_font_size('p'); ?>');

                                }

                            }

                            var text			= $el.find('.ut-word-rotator').length ? $el.find('.ut-word-rotator').text() : $el.text(),
								lineheight  	= $el.css('line-height'),
                                elw     		= $el.parent().width(),
                                width    		= elw > settings.maximum ? settings.maximum : elw < settings.minimum ? settings.minimum : elw,
								font_ratio		= settings.dynamicFontRatio ? ( findLongestWord( text.replace(/<(?:.|\n)*?>/gm, '').replace(/(\r\n\t|\n|\r\t)/gm," ").trim() ) * ratio_multi ) : _font_ratio,
                                fontBase 		= width / font_ratio,
                                fontSize 		= fontBase > max_font ? max_font : fontBase < min_font ? min_font : fontBase;

                            if( settings.dynamicFontRatio ) {

                                fontSize = fontSize * factor;

                            }

                            fontSize = parseInt( fontSize ) + font_size_fill;

							$el.css('font-size', fontSize + 'px');
							
							if( settings.lineHeight && settings.lineHeight.includes("px") ) {
								
								lineheight = settings.lineHeight.replace("px", "");
								
								var ratio = lineheight / settings.maxFont;
								
								if( $el.hasClass("element-with-custom-line-height") || $el.parent().hasClass("element-with-custom-line-height") ) {
								
									el.style.setProperty( 'line-height', ( fontSize * ratio ) + 'px', 'important' );
							   
								} else {
									
									if( lineheight < fontSize ) {
									
										el.style.setProperty( 'line-height', fontSize + 'px', 'important' );
										
									}
									
								}
								
							}

                            if( settings.loaded && typeof(settings.loaded) === "function" ) {

                                settings.loaded();

                            }

                        };

                        return this.each(function() {

                            var that = this;

                            $(window).utresize(function(){
                                
                                changes(that);
                                
                            });

                            if ( $(that).closest( '.vc_row[data-vc-full-width]' ).length && $( window ).width() >= 1440 ) {

                                /* wait for f***king vc */
                                new ResizeSensor( $(that).closest( '.vc_row[data-vc-full-width]' ), function () {

                                    changes(that);

                                } );

                            } else if ( $(that).closest( '.vc_section[data-vc-full-width]' ).length && $( window ).width() >= 1440 ) {

                                /* wait for f***king vc */
                                new ResizeSensor( $(that).closest( '.vc_section[data-vc-full-width]' ), function () {

                                    changes(that);

                                } );

                            } else {

                                changes(that);

                            }

                            
                        });

                    };
                    
                    
                    if( $('.site-logo h1', '#header-section').length ) {
                        
                        $('.site-logo h1', '#header-section').each( function(){
                           
                            var text_logo_original_font_size = $(this).css("font-size");
                        
                            if( text_logo_original_font_size ) {

                                var text_logo_max_font = text_logo_original_font_size.replace('px','');

                                $(this).flowtype({
                                    maxFont: text_logo_max_font,
                                    fontRatio : $(this).text().length / 2,
                                    minFont: 18
                                });                    

                            }
                            
                        });

                    }                    
                    
                    <?php if( ut_return_hero_config('ut_hero_type', 'image') != 'slider' ) : ?>
                    
                    if( $('.hero-description', '#ut-hero').length ) {
        
                        var hero_dt_original_font_size = $('.hero-description', '#ut-hero').css("font-size"),
							hero_dt_original_line_height = $('.hero-description', '#ut-hero').css("line-height");
                        
                        if( hero_dt_original_font_size ) {

                            var hero_dt_max_font = hero_dt_original_font_size.replace('px','');

                            $('.hero-description', '#ut-hero:not(.slider)').flowtype({
                                maxFont: hero_dt_max_font,
                                fontRatio : 24,
                                minFont: 10
								// lineHeight : hero_dt_original_line_height
                            });                    

                        }

                    }

                    if( $('.hero-title', '#ut-hero').length ) {
						
                        var hero_title_original_font_size = $('.hero-title', '#ut-hero').css("font-size"),
							hero_title_original_line_height = $('.hero-title', '#ut-hero').css("line-height");
                        
                        if( hero_title_original_font_size ) {

                            var hero_title_max_font = hero_title_original_font_size.replace('px','');
							
                            $('.hero-title', '#ut-hero:not(.slider)').flowtype({
                                maxFont: hero_title_max_font,
								dynamicFontRatio : true,
                                minFont: 35,
								lineHeight : hero_title_original_line_height
                            });

                        }

                    }
                        
                    if( $('.hero-description-bottom', '#ut-hero').length ) {

                        var hero_db_original_font_size = $('.hero-description-bottom', '#ut-hero').css("font-size"),
							hero_db_original_line_height = $('.hero-description-bottom', '#ut-hero').css("line-height");

                        if( hero_db_original_font_size ) {

                            var hero_db_max_font = hero_db_original_font_size.replace('px','');

                            $('.hero-description-bottom', '#ut-hero:not(.slider)').flowtype({
                                maxFont: hero_db_max_font,
                                fontRatio : 24,
                                minFont: 12
								// lineHeight : hero_db_original_line_height
                            });                    

                        }

                    }
                    
                    <?php endif; ?>
                    
                    $(".page-title, .parallax-title, .section-title").each( function(){

                        var $this = $(this);

                        var title_original_font_size   = $this.css("font-size"),
							title_original_line_height = $this.css("line-height");
                        
                        if( title_original_font_size ) {

                            $this.data("maxfont", title_original_font_size.replace('px','') );
                            $this.data("lineheight", title_original_line_height );

							var font_ratio = $this.data("maxfont") <= 75 ? 8 : 4;

                            $this.flowtype({
                                maxFont: $(this).data("maxfont"),
                                lineHeight : $(this).data("lineheight"),
                                fontRatio : font_ratio,
                                minFont: 30,
								type: 'title',
                                loaded: function() {

                                    $this.addClass('ut-title-loaded');

                                }
                            });                

                        }

                    });

                    $(".ut-custom-heading-module").each( function(){

                        var title_original_font_size   = $(this).css("font-size"),
                            title_original_line_height = $(this).css("line-height");

                        if( title_original_font_size ) {

                            $(this).data("maxfont", title_original_font_size.replace('px','') );
                            $(this).data("lineheight", title_original_line_height );

                            var font_ratio = $(this).data("maxfont") <= 75 ? 8 : 4;

                            $(this).flowtype({
                                maxFont: $(this).data("maxfont"),
                                lineHeight : $(this).data("lineheight"),
                                fontRatio : font_ratio,
                                type: 'custom',
                                loaded: function() {

                                }
                            });

                        }

                    });

                    $(".ut-information-box-title, .ut-service-column-title").each( function(){

                        var title_original_font_size   = $(this).css("font-size"),
                            title_original_line_height = $(this).css("line-height");

                        if( title_original_font_size ) {

                            $(this).data("maxfont", title_original_font_size.replace('px','') );
                            $(this).data("lineheight", title_original_line_height );

                            $(this).flowtype({
                                maxFont: $(this).data("maxfont"),
                                lineHeight : $(this).data("lineheight"),
                                fontRatio : 4,
                                type: 'custom',
                                loaded: function() {

                                }
                            });

                        }

                    });

                    $(".ut-word-rotator").each( function(){

                        if( $(this).closest('.hero-title').length ) {
                            return;
                        }

                        var title_original_font_size   = $(this).css("font-size"),
                            title_original_line_height = $(this).css("line-height");

                        if( title_original_font_size ) {

                            $(this).data("maxfont", title_original_font_size.replace('px','') );
                            $(this).data("lineheight", title_original_line_height );

                            var font_ratio = $(this).data("maxfont") <= 75 ? 8 : 4;

                            $(this).flowtype({
                                maxFont: $(this).data("maxfont"),
                                lineHeight : $(this).data("lineheight"),
                                fontRatio : font_ratio,
                                type: 'custom',
                                loaded: function() {

                                }
                            });

                        }

                    });

                    $(".single-post .entry-title, .single-post-entry-sub-title").each( function(){

                        var title_original_font_size   = $(this).css("font-size"),
							title_original_line_height = $(this).css("line-height");
                        
                        if( title_original_font_size ) {

                            $(this).data("maxfont", title_original_font_size.replace('px','') );
							$(this).data("lineheight", title_original_line_height );

                            var font_ratio = $(this).data("maxfont") <= 75 ? 8 : 4;
							
                            $(this).flowtype({
                                maxFont: $(this).data("maxfont"),
                                fontRatio : font_ratio,
                                minFont: 30,
                                type: 'title',
								lineHeight : $(this).data("lineheight"),
                            });                

                        }

                    });

                    if( $(".ut-parallax-quote-title").length ) {
                    
                        $(".ut-parallax-quote-title").each( function(){

                            var title_original_font_size   = $(this).css("font-size"),
                                title_original_line_height = $(this).css("line-height");

                            if( title_original_font_size ) {

                                $(this).data("maxfont", title_original_font_size.replace('px','') );
                                $(this).data("lineheight", title_original_line_height );

                                var font_ratio = $(this).data("maxfont") <= 75 ? 8 : 4;

                                $(this).flowtype({
                                    maxFont: $(this).data("maxfont"),
                                    fontRatio : font_ratio,
                                    minFont: 30,
                                    lineHeight : $(this).data("lineheight"),
                                    type: 'title'
                                });                

                            }

                        });
                    
                    }
                    
                    $("#ut-overlay-nav ul > li").each( function(){

                        var overlay_font_size = $(this).css("font-size");

                        if( overlay_font_size ) {

                            $(this).data("maxfont", overlay_font_size.replace('px','') );

                            $(this).flowtype({
                                maxFont: $(this).data("maxfont"),
                                fontRatio : 8,
                                minFont: 25
                            });                

                        }

                    });                    
                   	
					
					function add_visual_composer_helper_classes() {
					
						$('.vc_col-has-fill').each(function() {

							$(this).parent(".vc_row").addClass("ut-row-has-filled-cols");

						}); 					

						$('.vc_section > .vc_row, .vc_section > .vc_vc_row').each(function() {

							var $this = $(this);

							if( $this.parent().children('.vc_row, .vc_vc_row').first().is(this) ) {

								if( $this.hasClass("vc_row-has-fill") ) {

									$this.parent().addClass("ut-first-row-has-fill");

								}

								$this.addClass('ut-first-row');

							} 

							if( $this.parent().children('.vc_row, .vc_vc_row').last().is(this) ) {

								if( $this.hasClass("vc_row-has-fill") ) {

									$this.parent().addClass("ut-last-row-has-fill");

								}

								$this.addClass('ut-last-row');

							}       

						});                    

						$('.vc_section').each(function() {

							var $this = $(this);

							if( $this.is(':first-of-type') && $this.is(':visible') ) {

								$this.addClass('ut-first-section');    

							}

							if( $this.is(':first-of-type') && $this.is(':visible') && $this.next('.vc_row-full-width').next('.vc_section').is(':last-of-type') && !$this.next('.vc_row-full-width').next('.vc_section').is(':visible') ) {

								$this.addClass('ut-last-section');

								if( !$this.hasClass('vc_section-has-fill') ) {

									$("#ut-sitebody").addClass('ut-last-section-has-no-fill');

								}

							}

							if( $this.is(':last-of-type') && $this.is(':visible') ) {

								$this.addClass('ut-last-section');

								if( !$this.hasClass('vc_section-has-fill') ) {

									$("#ut-sitebody").addClass('ut-last-section-has-no-fill');

								} 

							}

							if( $this.is(':last-of-type') && $this.is(':visible') && $this.prev('.vc_row-full-width').prev('.vc_section').is(':first-of-type') && !$this.prev('.vc_row-full-width').prev('.vc_section').is(':visible') ) {

								$this.addClass('ut-first-section');

							}

							if( $this.hasClass('vc_section-has-no-fill') && !$this.hasClass('ut-last-row-has-fill') && $this.next('.vc_row-full-width').next('.vc_section').hasClass('vc_section-has-no-fill') && !$this.next('.vc_row-full-width').next('.vc_section').hasClass('ut-first-row-has-fill') ) {

								$this.addClass("vc_section-remove-padding-bottom");

							}

						});

                        $('.ut-information-box-image-wrap').each(function() {

                            var $this = $(this);

                            $this.closest('.wpb_wrapper').addClass('ut-contains-information-box');

                            if( $this.parent().siblings().not('.ut-information-box').length ) {

                                $this.closest('.wpb_wrapper').addClass('ut-contains-information-box-mixed');

                            }

                            if( !$this.parent().siblings().length ) {

                                $this.parent().addClass('ut-information-box-no-siblings');

                            }

                        });
					
					}
					
					// run on site load
					add_visual_composer_helper_classes();
					
					// update on resize
					$(window).utresize(function(){
						add_visual_composer_helper_classes();
					});
                    
					$(document).ajaxComplete(function() {
						add_visual_composer_helper_classes();
					});
					
                    
					$('.ut-plan-module-popular').each(function() {
						
						var $this = $(this);
						
						$this.closest(".wpb_column").addClass("ut-column-with-popular-pricing-table");
								
					});
										
                    <?php 
                    
                     /**
                      * Scroll Fade Effect for Hero Area
                      */                    
                    
                    if( ut_return_hero_config('ut_hero_image_parallax') == 'on' ) : ?>

                        <?php if( !unite_mobile_detection()->isMobile() ) : ?>

                            var hero_inner = $(".hero-inner", '#ut-hero'); 
                            var scroll_down = $(".hero-down-arrow", '#ut-hero');

                            $(window).on("scroll", function() {

                                var st = $(this).scrollTop();

                                hero_inner.css({
                                    "opacity" : 1 - st/($(window).height()/4*3)
                                });

                                scroll_down.css({
                                    "opacity" : 1 - st/($(window).height()/4*3)
                                });

                            });

                        <?php endif; ?>

                    <?php endif; ?>

                    <?php

                    /**
                     * Scroll Zoom Effect for Hero Area
                     */

                    if( ut_collect_option( 'ut_hero_image_scroll_zoom', 'off' ) == 'on' ) : ?>

                        <?php if( !unite_mobile_detection()->isMobile() ) : ?>

                        var hero_image = $(".parallax-image-container", '#ut-hero' );

                        $(window).on("scroll", function() {

                            var st = $(this).scrollTop();

                            hero_image.css({
                                "transform" : 'scale(' + ( 1 + ( st/( $(window).height() / 4*3 ) ) / 5 ) + ')'
                            });


                        });

                        <?php endif; ?>

                    <?php endif; ?>
                    
                    <?php
            
                    /**
                      * Rain Effect for Hero
                      */ 
            
                    if( apply_filters( 'ut_show_hero', false ) && ut_return_hero_config( 'ut_hero_rain_effect' , 'off' ) == 'on' && ( $ut_hero_type == 'image' || $ut_hero_type == 'tabs' || $ut_hero_type == 'splithero' )) : ?>
                    
                        $.fn.utFullSize = function( callback ) {

                            var fullsize = $(this);		

                            function utResizeObject() {

                                var imgwidth = fullsize.width(),
                                    imgheight = fullsize.height(),
                                    winwidth = $(window).width(),
                                    winheight = $(window).height(),
                                    widthratio = winwidth / imgwidth,
                                    heightratio = winheight / imgheight,
                                    widthdiff = heightratio * imgwidth,
                                    heightdiff = widthratio * imgheight;

                                if( heightdiff > winheight ) {

                                    fullsize.css({
                                        width: winwidth+"px",
                                        height: heightdiff+"px"
                                    });

                                } else {

                                    fullsize.css({
                                        width: widthdiff+"px",
                                        height: winheight+"px"
                                    });		

                                }

                            } 

                            utResizeObject();

                            $(window).utresize(function(){
                                utResizeObject();
                            });

                            if (callback && typeof(callback) === "function") {   
                                callback();  
                            }

                        };


                        function ut_init_RainyDay( callback ) {

                            var $image = document.getElementById("ut-rain-background"),
                                $hero  = document.getElementById("ut-hero");						

                                var engine = new RainyDay({
                                    image: $image,
                                    parentElement : $hero,
                                    blur: 20,
                                    opacity: 1,
                                    fps: 30
                                });

                                engine.gravity = engine.GRAVITY_NON_LINEAR;
                                engine.trail = engine.TRAIL_SMUDGE;
                                engine.rain([ [6, 6, 0.1], [2, 2, 0.1] ], 50 );

                            $image.crossOrigin = "anonymous";

                            if (callback && typeof(callback) === "function") {   
                                callback();  
                            }

                        }


                        $(window).load(function(){

                            $("#ut-rain-background").utFullSize( function() {

                                // play rainday sound and remove section image and adjust canvas
                                ut_init_RainyDay( function() {

                                    $("#ut-hero").css("background-image" , "none");
                                    $("#ut-hero canvas").utFullSize();

                                });

                            });

                        });
                    
                        <?php 
                        
                        /**
                          * Option Rain Sound
                          */
            
                        if( ut_return_hero_config('ut_hero_rain_sound' , 'off') == 'on' ) :	?>
                    
                            PIXI.sound.Sound.from({
                                url: $('#ut-hero-rain-audio').data('mp3'),
                                loop: true,
                                preload: true,
                                volume: 0.05,
                                loaded: function(err, sound) {
                                    sound.play();                                    
                                }
                            });
                    
                            $(document).ready(function(){
                                
                                $(document).on("click", "#ut-hero-rain-audio" , function(event) {
                                    
                                    if( $(this).hasClass("ut-unmute") ) {

                                        $(this).removeClass("ut-unmute").addClass("ut-mute");	

                                    } else {


                                        $(this).removeClass("ut-mute").addClass("ut-unmute");

                                    }
                                    
                                    PIXI.sound.togglePauseAll();
                                    event.preventDefault();
                                    
                                });
                               
                                
                            });    
                    
                        <?php endif; ?>                    
                    
                    <?php endif; ?>
                    
                    <?php 
                    
                     /**
                      * Youtube Video Player 
                      */
            
                    if( !unite_mobile_detection()->isMobile() && $ut_hero_type == 'video' && ut_return_hero_config('ut_video_source' , 'youtube') == 'youtube' || unite_mobile_detection()->isMobile() && $ut_hero_type == 'video' && ut_return_hero_config('ut_video_source' , 'youtube') == 'youtube' && ut_return_hero_config('ut_video_mobile' , 'off') == 'on' || !unite_mobile_detection()->isMobile() && $ut_hero_type == 'tabs' && ut_return_hero_config('ut_video_containment', 'hero') == 'body' ) : ?>
                    
                        if( $("#ut-background-video-hero").length ) {						

                            var $hero_player = $("#ut-background-video-hero").YTPlayer();
							
							$hero_player.on("YTPReady",function(){
								
								$hero_player.siblings('.parallax-scroll-container').hide();
								
							});
							
							$hero_player.on("YTPEnd",function(){
								
								$hero_player.siblings('.parallax-scroll-container').show();
								
							});
							
                            $("#ut-video-hero-control.youtube").click(function(event){
                                        
                                if( $(this).hasClass("ut-unmute") ) {									

                                    $(this).removeClass("ut-unmute").addClass("ut-mute");														
                                    $hero_player.YTPUnmute();

                                } else {

                                    $(this).removeClass("ut-mute").addClass("ut-unmute");
                                    $hero_player.YTPMute();							

                                }

                                event.preventDefault();

                            });

                        }
                    
                    <?php endif; ?>
                    
                    
                    
                    <?php
                
                    /**
                      * Retina JS Logo
                      */ 

                    $sitelogo_retina = !is_front_page() && !is_home() && ( !apply_filters( 'ut_show_hero', false ) ) ? ( ut_return_logo_config( 'ut_site_logo_alt_retina' ) ? ut_return_logo_config( 'ut_site_logo_alt_retina' ) : ut_return_logo_config( 'ut_site_logo_retina' ) ) : ut_return_logo_config( 'ut_site_logo_retina' );                        
                    $alternate_logo_retina = ut_return_logo_config( 'ut_site_logo_alt_retina' ) ? ut_return_logo_config( 'ut_site_logo_alt_retina' ) : ut_return_logo_config( 'ut_site_logo_retina' ); 

                    ?>

                    var modern_media_query = window.matchMedia( "screen and (-webkit-min-device-pixel-ratio:2)");

                    <?php if( !empty( $sitelogo_retina ) ) : ?>

                        if( modern_media_query.matches ) {

                            var $logo = $(".site-logo:not(.ut-overlay-site-logo)").find("img");
                            $logo.attr("src", retina_logos.sitelogo_retina );
                            
                        }

                    <?php endif; ?>
                    
                    <?php if( !empty( $alternate_logo_retina ) ) : ?>

                        if( modern_media_query.matches ) {

                            var $logo = $(".site-logo:not(.ut-overlay-site-logo)").find("img");
                            $logo.data("altlogo" , retina_logos.alternate_logo_retina );        

                        }

                    <?php endif; ?>
                    
                    <?php if( ot_get_option("ut_overlay_logo_retina") ) : ?>

                        if( modern_media_query.matches ) {

                            var $logo = $("#ut-overlay-site-logo img");
                            $logo.attr("src", retina_logos.overlay_sitelogo_retina );

                        }

                    <?php endif; ?>
					
                    /* Global Objects
                    ================================================== */
                    var $brooklyn_body   = $("body");
                    var $brooklyn_header = $("#header-section");
                    var $brooklyn_main   = $("<?php echo ut_return_header_config( 'ut_navigation_skin_waypoint', 'content' ) == 'content' ? '#main-content' : '#ut-hero-early-waypoint' ; ?>");
                    
                    /* Header Top Animations 
                    ================================================== */
                    <?php if( ut_return_header_config('ut_navigation_scroll_position' , 'floating') == 'floating' ) : ?>

                        var $header = $("#header-section"),
                            $logo	= $(".site-logo:not(.ut-overlay-site-logo) img"),
                            logo	= $logo.data("original-logo"),
                            logoalt = $logo.data("alternate-logo");
                    
                        // skin state
                        var primary_skin   = $header.data('primary-skin');
                        var secondary_skin = $header.data('secondary-skin');

                        function ut_nav_skin_changer( direction, animClassDown, animClassUp, headerClassDown, headerClassUp ) {
                            
                            animClassUp = typeof animClassUp !== 'undefined' ? animClassUp : '';
                            animClassDown = typeof animClassDown !== 'undefined' ? animClassDown : '';

                            headerClassUp = typeof headerClassUp !== 'undefined' ? headerClassUp : '';
                            headerClassDown = typeof headerClassDown !== 'undefined' ? headerClassDown : '';                            
                            
                            if( direction === "down" ) {

                                if( !site_settings.mobile_nav_open ) {
                                
                                    $logo.attr("src" , logoalt );        
                                    $header.attr("class", "ha-header").addClass(headerClassDown).addClass(animClassDown);
                                    
                                }
                                    
                                // change attributes    
                                $header.data("primary-skin", secondary_skin );
                                $header.data("secondary-skin", secondary_skin );
                                
                                site_settings.mobile_hero_passed = true;

                            } else if( direction === "up" ){
                                
                                if( !site_settings.mobile_nav_open ) {
                                
                                    $logo.attr("src" , logo );
                                    $header.attr("class", "ha-header").addClass(headerClassUp).addClass(animClassUp);
                                
                                }
                                    
                                // change attributes    
                                $header.data("primary-skin", primary_skin );
                                $header.data("secondary-skin", secondary_skin );
                                
                                site_settings.mobile_hero_passed = false;                                

                            }

                        }

                        <?php

                        // default classes 
                        $classes = array();

                        $classes[] = 'ut-header-floating';
                        $classes[] = ut_page_option( 'ut_top_header' , 'hide' ) == 'show' ? 'bordered-top' : '';
                        $classes[] = ut_return_header_config( 'ut_navigation_width', 'centered' ) == 'centered' ? 'centered' : 'fullwidth';
                        
                        // Site Frame Classes
                        $classes[] = apply_filters( 'ut_show_siteframe', 'hide' ) == 'show' ? 'bordered-navigation' : '';
                        $classes[] = apply_filters( 'ut_show_siteframe', 'hide' ) == 'show' && ut_return_header_config( 'ut_site_navigation_flush', 'no' ) == 'yes' && ut_return_header_config( 'ut_navigation_width', 'centered' ) == 'fullwidth' ? 'ut-flush' : '';
                        $classes[] = apply_filters( 'ut_show_siteframe', 'hide' ) == 'show' && ut_return_header_config( 'ut_site_navigation_flush', 'no' ) == 'logo_only' && ut_return_header_config( 'ut_navigation_width', 'centered' ) == 'fullwidth' ? 'ut-flush-logo-only' : '';

                        /* 
                         * Animation for Custom Headers with individual classes
                         */

                        if( apply_filters( 'ut_show_hero', false ) && ut_return_header_config( 'ut_navigation_skin' , 'ut-header-light' ) == 'ut-header-custom' ) : ?>

                            <?php if( ut_return_header_config('ut_navigation_customskin_state' , 'off') == 'off' ) : ?>

                                <?php 
            
                                // Navigation Skin Class
                                $classes[] = 'ut-primary-custom-skin'; ?>

                                $brooklyn_main.waypoint( function( direction ) {
                                    
                                    ut_nav_skin_changer( direction ,  $brooklyn_main.data( "animateDown" ) , $brooklyn_main.data( "animateUp" ), "<?php echo implode(' ', $classes ); ?>", "<?php echo implode(' ', $classes ); ?>" );

                                }, { offset: site_settings.brooklyn_header_scroll_offset + 1 } );


                            <?php endif; ?>

                            <?php if( ut_return_header_config('ut_navigation_customskin_state' , 'off') == 'on_switch' ) : ?>                            

                                $brooklyn_main.waypoint( function( direction ) {

                                    ut_nav_skin_changer(direction, "ut-secondary-custom-skin", "ut-primary-custom-skin", "<?php echo implode(' ', $classes ); ?>", "<?php echo implode(' ', $classes ); ?>" );			

                                }, { offset: site_settings.brooklyn_header_scroll_offset + 1 }); 

                            <?php endif; ?>


                        <?php endif; ?>                    

                        <?php if( apply_filters( 'ut_show_hero', false ) && ut_return_header_config( 'ut_navigation_skin' , 'ut-header-light' ) != 'ut-header-custom' ) : ?>

                            <?php if( ut_return_header_config('ut_navigation_state' , 'off') == 'off' ) : ?>

                                <?php 
            
                                // Navigation Skin Class
                                $classes[] = ut_return_header_config( 'ut_navigation_skin' , 'ut-header-light' ); 
                                
                                if( ut_return_header_config( 'ut_navigation_style', 'separator' ) == 'animation-line' ) {
                                    
                                    $classes[] = 'ut-navigation-style-on'; 
                                    
                                } ?>
                    
                                $brooklyn_main.waypoint( function( direction ) {

                                    ut_nav_skin_changer( direction , $brooklyn_main.data( "animateDown" ) , $brooklyn_main.data( "animateUp" ), "<?php echo implode(' ', $classes ); ?>", "<?php echo implode(' ', $classes ); ?>" );

                                }, { offset: site_settings.brooklyn_header_scroll_offset + 1 } );


                            <?php endif; ?>

                            <?php if( ut_return_header_config( 'ut_navigation_state', 'off' ) == 'on_transparent' ) : ?>

                                <?php 
                                
                                // Navigation Skin Class
                                $navigation_skin = ut_return_header_config('ut_navigation_skin' , 'ut-header-light'); 
            
                                $classes[] = ut_return_header_config( 'ut_navigation_transparent_border' ) == 'on' ?  'ut-header-has-border' : ''; 

                                if( ut_return_header_config( 'ut_navigation_style', 'separator' ) == 'animation-line' ) {
                                    
                                    $classes[] = 'ut-navigation-style-on'; 
                                    
                                } ?>
                    
                                $brooklyn_main.waypoint( function( direction ) {

                                    ut_nav_skin_changer( direction, "<?php echo $navigation_skin; ?> ut-header-floating <?php echo implode(' ', $classes ); ?>", "ha-transparent ut-header-floating <?php echo implode(' ', $classes ); ?>" );

                                }, { offset: site_settings.brooklyn_header_scroll_offset + 1 });

                            <?php endif; ?>

                        <?php endif; ?>

                    <?php endif; ?>
					
                })(jQuery);
                
                </script>
                
            <?php 
            
            echo $this->minify_js( ob_get_clean() );
            
            
        }        
            
    }

}

$UT_Custom_JS = new UT_Custom_JS;