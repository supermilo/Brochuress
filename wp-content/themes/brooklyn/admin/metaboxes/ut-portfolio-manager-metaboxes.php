<?php

if ( !function_exists( 'ut_bklyn_portfolio_manager_settings' ) ):

    function ut_bklyn_portfolio_manager_settings() {
        
        $settings = apply_filters( 'ut_bklyn_portfolio_manager_settings', array(
            
            'id'        => 'ut-metapanel',
            'title'     => 'United Themes - Showcase Settings',
            'pages'     => array( 'portfolio-manager' ),
            'context'   => 'normal',
            'type'      => 'tabs',
            'priority'  => 'low',
            
            // panel sections
            'sections'  => array(
                array(
                    'id'    => 'ut-showcase-settings',
                    'title' => 'Showcase Settings'
                ),
                array(
                    'id'    => 'ut-showcase-custom-settings',
                    'title' => 'Custom Showcase Settings'
                ),
                array(
                    'id'    => 'ut-showcase-color-settings',
                    'title' => 'Showcase Color Settings'
                ),
                array(
                    'id'    => 'ut-showcase-font-settings',
                    'title' => 'Showcase Font Settings'
                ),
                array(
                    'id'    => 'ut-showcase-image-settings',
                    'title' => 'Showcase Image Settings'
                ),
            ),
            
            // option fields
            'fields' => array(
                
                array(
                    'id'        => 'ut_showcase_settings',
                    'metapanel' => 'ut-showcase-settings',
                    'label'     => 'Showcase Settings',
                    'type'      => 'panel_headline',
                ),
            
                array(
                    'id'        => 'ut_portfolio_type',
                    'metapanel' => 'ut-showcase-settings',
                    'label'     => 'Showcase Type',
                    'desc'      => 'Select your desired portfolio type.',
                    'type'      => 'select',
                    'choices' => array(
                        
                        array(
                            'label' => 'Carousel Portfolio',
                            'value' => 'ut_carousel'
                        ),
                        array(
                            'label' => 'Filterable Grid Portfolio',
                            'value' => 'ut_gallery'
                        ),
                        
                    ),                    
                ),
                
                 
                
                
                
                
                
                array(
                    'id'        => 'ut_portfolio_categories',
                    'metapanel' => 'ut-showcase-settings',
                    'label'     => 'Showcase Categories',
                    'desc'      => 'Select categories you like to connect to this showcase. Use the vertical double arrows to re-arrange their order. This order will also reflect on the portfolio filter.',
                    'type'      => 'sortable_taxonomy_checkbox_group',
                    'taxonomy'  => 'portfolio-category'
                ),
                
                array(
                    'id'        => 'posts_per_page',
                    'multikey'  => 'ut_portfolio_settings',
                    'metapanel' => 'ut-showcase-settings',
                    'label'     => 'Portfolio Items per Page',
                    'desc'      => 'Portfolio Items per page (default -1 for unlimted posts). This also defines the amount of items loaded when using the load more feature.',
                    'type'      => 'text',
                ),
            
                array(
                    'id'        => 'optional_class',
                    'multikey'  => 'ut_portfolio_settings',
                    'metapanel' => 'ut-showcase-settings',
                    'label'     => 'Optional Class',
                    'desc'      => 'Style this particular showcase element differently - add a class name and refer to it in custom CSS in "Theme Options" > "Advanced" > "Custom CSS".',
                    'type'      => 'text',
                ),
            
            
            
            
                // Filterable Portfolio Settings
                array(
                    'id'        => 'ut_gallery_options_headline',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Showcase Settings',
                    'type'      => 'panel_headline',
                    'required'  => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ),
                
                array(
                    'id'        => 'filter',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Activate Portfolio Filter?',
                    'desc'      => 'Allows sorting of this showcase based on categories.',
                    'type'      => 'select',
                    'choices' => array(    
                        array(
                            'value' => 'off',
                            'label' => 'no, thanks!'
                        ),
                        array(
                            'value' => 'on',
                            'label' => 'yes, please!'
                        )
                    
                    ),
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ), 
                
                array(
                    'id'        => 'filter_position',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Filter Position',
                    'desc'      => 'Desired Filter Position. Use "Showcase Color Settings" to adjust the filter colors.',
                    'type'      => 'select',
                    'choices' => array(    
                        array(
                            'value' => 'top',
                            'label' => 'Top'
                        ),
                        array(
                            'value' => 'side',
                            'label' => 'Side'
                        )
                    
                    ),
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                        'ut_gallery_options[filter]' => 'on'
                    ),
                ),
                
                // Portfolio Like System
                array(
                    'id'        => 'ut_gallery_filter_like_system_headline',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Like Feature',
                    'type'      => 'section_headline',
                    'required'  => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ),
                
                array(
                    'id'        => 'filter_like',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Activate Portfolio Like Feature?',
                    'desc'      => 'A simple and efficient portfolio like system.',
                    'type'      => 'select',
                    'choices' => array(    
                        array(
                            'value' => 'off',
                            'label' => 'no, thanks!'
                        ),
                        array(
                            'value' => 'on',
                            'label' => 'yes, please!'
                        )
                    
                    ),
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ),
                
                
                
                
                
                // Filterable Portfolio Extra Filter Settings
                array(
                    'id'        => 'ut_gallery_filter_extra_sorting_headline',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => '"Extra" Portfolio Sorting',
                    'type'      => 'section_headline',
                    'required'  => array(
                        'ut_portfolio_type' => 'ut_gallery',
                        'ut_gallery_options[filter]' => 'on'
                    ),
                ),
                
                array(
                    'id'        => 'filter_extra_sorting',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Activate Portfolio "Extra" Sorting?',
                    'desc'      => 'Adds an additional filter which allows visitors to sort the portfolio by: newest, most popular (if like system is active) and updated portfolio posts.',
                    'type'      => 'select',
                    'std'       => 'off',
                    'choices' => array(    
                        array(
                            'value' => 'off',
                            'label' => 'no, thanks!'
                        ),
                        array(
                            'value' => 'on',
                            'label' => 'yes, please!'
                        )                    
                    ),
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                        'ut_gallery_options[filter]' => 'on'    
                    ),
                ), 
                
                array(
                    'id'        => 'filter_extra_sorting_title_text',
                    'multikey'  => 'ut_portfolio_settings',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => '"Extra" Sorting Filter Title',
                    'desc'      => '(default: "Sort by")',
                    'type'      => 'text',
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                        'ut_gallery_options[filter]' => 'on',
                        'ut_gallery_options[filter_extra_sorting]' => 'on'
                    ),
                ),
                
                
                
                 
                
                
                
                
                // Filter Animation
                array(
                    'id'        => 'ut_gallery_filter_animation_options_headline',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Filter Animation Settings',
                    'type'      => 'section_headline',
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                        'ut_gallery_options[filter]' => 'on'
                    ),
                ),
                
                array(
                    'id'        => 'stagger',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Filter Transition Stagger',
                    'desc'      => 'Staggers item transitions, so items transition incrementally after one another. ',
                    'type'      => 'numeric_slider',
                    'std'       => '0',
                    'min_max_step' => '0,200,1',
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                        'ut_gallery_options[filter]' => 'on'
                    ),
                ),
                
                array(
                    'id'        => 'sorting_effect',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Portfolio Filtering Effect',
                    'desc'      => 'The effect applied to hide and reveal items when filtering.',
                    'type'      => 'select',
                    'choices' => array(    
                        array(
                            'value' => 'default',
                            'label' => 'Default Effect (Zoom and Fade)'
                        ),
                        array(
                            'value' => 'fade',
                            'label' => 'Fade Effect'
                        )
                    
                    ),
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ), 
                
                
                
                
                
                
                
                
                // Portfolio Appearance
                array(
                    'id'        => 'ut_gallery_appearance_options_headline',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Portfolio Appearance Settings',
                    'type'      => 'section_headline'
                ),
                
                array(
                    'id'        => 'columns',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Overall Column Layout (Desktop)',
                    'desc'      => 'Select your desired showcase column layout for desktop devices.',
                    'type'      => 'select',
                    'choices' => array(
                        
                        array(
                            'label' => '2 Column Layout',
                            'value' => '2'
                        ),
                        array(
                            'label' => '3 Column Layout',
                            'value' => '3'
                        ),
                        array(
                            'label' => '4 Column Layout',
                            'value' => '4'
                        ),
            
                    ),
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ),    
                
                array(
                    'id'        => 'columns_tablet',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Overall Column Layout (Tablet)',
                    'desc'      => 'Select your desired showcase column layout for tablet devices.',
                    'type'      => 'select',
                    'choices' => array(
                        
                        array(
                            'label' => '1 Column Layout',
                            'value' => '1'
                        ),
                        array(
                            'label' => '2 Column Layout',
                            'value' => '2'
                        ),
                        array(
                            'label' => '3 Column Layout',
                            'value' => '3'
                        ),
                        array(
                            'label' => '4 Column Layout',
                            'value' => '4'
                        ),
            
                    ),
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ), 
            
                array(
                    'id'        => 'columns_mobile',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Overall Column Layout (Mobile)',
                    'desc'      => 'Select your desired showcase column layout for mobiles devices.',
                    'type'      => 'select',
                    'choices' => array(
                        
                        array(
                            'label' => '1 Column Layout',
                            'value' => '1'
                        ),
                        array(
                            'label' => '2 Column Layout',
                            'value' => '2'
                        ),
                        array(
                            'label' => '3 Column Layout',
                            'value' => '3'
                        ),
                        array(
                            'label' => '4 Column Layout',
                            'value' => '4'
                        ),
            
                    ),
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ), 
            
                array(
                    'id'        => 'gutter',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Activate Portfolio Items Gap?',
                    'desc'      => 'Specify an optional pixel gap between portfolio items.',
                    'type'      => 'select',
                    'choices' => array(    
                        array(
                            'value' => 'off',
                            'label' => 'no, thanks!'
                        ),
                        array(
                            'value' => 'on',
                            'label' => 'yes, please!'
                        )
                    
                    ),
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ), 
                
                array(
                    'id'        => 'gutter_size',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Gap Size',
                    'desc'      => 'Gap size between Portfolio Items.',
                    'type'      => 'select',
                    'choices' => array(
                        array(
                            'label' => '20px',
                            'value' => '1'
                        ),
                        array(
                            'label' => '40px',
                            'value' => '2'
                        ),
                        array(
                            'label' => '60px',
                            'value' => '3'
                        ),
                    ),
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                        'ut_gallery_options[gutter]' => 'on',
                    ),
                ), 
                
                array(
                    'id'        => 'gutter_shadow',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Activate Gap Shadow?',
                    'desc'      => 'Adds a small shadow between the portfolio images.',
                    'type'      => 'select',
                    'choices' => array(    
                        array(
                            'value' => 'off',
                            'label' => 'no, thanks!'
                        ),
                        array(
                            'value' => 'on',
                            'label' => 'yes, please!'
                        )
                    
                    ),
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                        'ut_gallery_options[gutter]' => 'on',
                    ),
                ), 
                
                
                
                
                
                
                array(
                    'id'        => 'style',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Portfolio Visual Style',
                    'desc'      => '',
                    'type'      => 'select',
                    'choices' => array(
                        
                        array(
                            'label' => 'Style 1',
                            'value' => 'style_one'
                        ),
                        array(
                            'label' => 'Style 2',
                            'value' => 'style_two'
                        ),
                        array(
                            'label' => 'Style 3',
                            'value' => 'style_three'
                        ),
            
                    ),
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ), 
                
                
                
                array(
                    'id'        => 'caption_position',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Portfolio Caption Position',
                    'desc'      => 'middle-center',
                    'type'      => 'select',
                    'choices' => array(
                        
                        array(
                            'label' => 'Top Left',
                            'value' => 'top-left'
                        ),
                        array(
                            'label' => 'Top Center',
                            'value' => 'top-center'
                        ),
                        array(
                            'label' => 'Top Right',
                            'value' => 'top-right'
                        ),
                        array(
                            'label' => 'Center Left',
                            'value' => 'middle-left'
                        ),
                        array(
                            'label' => 'Center Center',
                            'value' => 'middle-center'
                        ),
                        array(
                            'label' => 'Center Right',
                            'value' => 'middle-right'
                        ),
                        array(
                            'label' => 'Bottom Left',
                            'value' => 'bottom-left'
                        ),
                        array(
                            'label' => 'Bottom Center',
                            'value' => 'bottom-center'
                        ),
                        array(
                            'label' => 'Bottom Right',
                            'value' => 'bottom-right'
                        ),
            
                    ),
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ), 
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                // Loading Animation
                array(
                    'id'        => 'ut_gallery_animation_options_headline',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Loading Animation Settings',
                    'type'      => 'section_headline'
                ),
                
                array(
                    'id'        => 'effect',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Portfolio Loading Animation Effect',
                    'desc'      => 'Select your desired Animation Effect. The animation effect will fire once your portfolio is loaded and is visible in your viewport.',
                    'std'       => 'fadeIn',
                    'type'      => 'animation_in'
                ),
                
                array(
                    'id'        => 'delay',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-custom-settings',
                    'label'     => 'Animation Delay Timer',
                    'desc'      => '(optional) Time in milliseconds until the next portfolio image appears. e.g. 200 (default: 200)',
                    'type'      => 'text',
                ),
                
                
                
                
                
                
                // Color Settings
                array(
                    'id'        => 'ut_showcase_color_settings',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Showcase Color Settings',
                    'type'      => 'panel_headline',
                ),
                
                
                array(
                    'id'        => 'ut_gportfolio_item_default_colors_headline',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Portfolio Item Hover Colors',
                    'type'      => 'section_headline',                    
                ),
                
                array(
                    'id'        => 'text_color',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Hover Title Color',
                    'desc'      => 'Enter your desired portfolio title color for mouse hover events.',
                    'type'      => 'colorpicker',
                ),
                
                array(
                    'id'        => 'category_color',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Hover Category, Custom Text and Plus Icon Color',
                    'desc'      => 'Enter your desired portfolio category, custom and plus icon color for mouse hover events.',
                    'type'      => 'colorpicker',
                ),                
                
                array(
                    'id'        => 'hover_color',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Hover Background Color',
                    'desc'      => 'Enter your desired portfolio background color for mouse hover events.',
                    'type'      => 'colorpicker',
                ),
                
                array(
                    'id'        => 'hover_opacity',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Hover Background Color Opacity',
                    'desc'      => 'Use the slider to set your desired background color opacity for mouse hover events.',
                    'type'      => 'numeric_slider',
                    'std'       => '0.8',
                    'min_max_step' => '0,1,0.05',
                ),
                
                
                
                
                
                
                
                // Filterable Portfolio Color Settings            
                array(
                    'id'        => 'ut_gallery_filter_default_colors_headline',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Filter Default Colors',
                    'type'      => 'section_headline',
                    'required'  => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ),
            
                array(
                    'id'        => 'filter_text_color',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Filter Text Color',
                    'desc'      => 'Enter your custom text color for the portfolio filter.',
                    'type'      => 'colorpicker',
                ),
            
                array(
                    'id'        => 'filter_background_color',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Filter Background Color',
                    'desc'      => 'Enter your custom background color for the portfolio filter.',
                    'type'      => 'colorpicker',
                ),
            
                array(
                    'id'        => 'filter_border_color',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Filter Border Color',
                    'desc'      => 'Enter your custom border color for the portfolio filter.',
                    'type'      => 'colorpicker',
                ),
            
                array(
                    'id'        => 'ut_gallery_filter_hover_colors_headline',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Filter Hover Colors',
                    'type'      => 'section_headline',
                    'required'  => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ),
            
                array(
                    'id'        => 'filter_text_hover_color',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Filter Text Hover Color',
                    'desc'      => 'Text Hover Color is used to select the filter when you mouse over them.',
                    'type'      => 'colorpicker',
                ),
            
                array(
                    'id'        => 'filter_background_hover_color',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Filter Background Hover Color',
                    'desc'      => 'Background Hover Color is used to select the filter when you mouse over them.',
                    'type'      => 'colorpicker',
                ),
            
                array(
                    'id'        => 'filter_border_hover_color',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Filter Border Hover Color',
                    'desc'      => 'Border Hover Color is used to select the filter when you mouse over them.',
                    'type'      => 'colorpicker',
                ),
            
                array(
                    'id'        => 'ut_gallery_filter_selected_colors_headline',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Filter Active Colors',
                    'type'      => 'section_headline',
                    'required'  => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ),
                
                array(
                    'id'        => 'filter_text_selected_color',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Filter Text Active Color',
                    'desc'      => 'The filter text becomes active when you click on it. ',
                    'type'      => 'colorpicker',
                ),
            
                array(
                    'id'        => 'filter_background_selected_color',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Filter Background Active Color',
                    'desc'      => 'The filter background becomes active when you click on it.',
                    'type'      => 'colorpicker',
                ),
            
                array(
                    'id'        => 'filter_border_selected_color',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Filter Border Active Color',
                    'desc'      => 'The filter border becomes active when you click on it.',
                    'type'      => 'colorpicker',
                ),
                
            
                // Slide Up Portfolio Colors
                array(
                    'id'        => 'ut_gallery_slide_up_colors_headline',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Slide Up Portfolio Colors',
                    'type'      => 'section_headline'                    
                ),
                
                array(
                    'id'        => 'slideup_loader_color',
                    'multikey'  => 'ut_portfolio_settings',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Portfolio Loader Arrow Color',
                    'desc'      => 'Custom color for the arrow of the loading indicator.',
                    'type'      => 'colorpicker',
                ),
            
                array(
                    'id'        => 'slideup_loader_background_color',
                    'multikey'  => 'ut_portfolio_settings',
                    'metapanel' => 'ut-showcase-color-settings',
                    'label'     => 'Portfolio Loader Background Color',
                    'desc'      => 'Custom color for the background of the loading indicator.',
                    'type'      => 'colorpicker',
                ),
                
            
                
            
            
            
                // Font Settings
                array(
                    'id'        => 'ut_showcase_font_settings',
                    'metapanel' => 'ut-showcase-font-settings',
                    'label'     => 'Showcase Font Settings',
                    'type'      => 'panel_headline',
                ),
                
                // Filterable Portfolio Font Settings            
                array(
                    'id'        => 'ut_gallery_filter_font_settings_headline',
                    'metapanel' => 'ut-showcase-font-settings',
                    'label'     => 'Filter Font Settings',
                    'type'      => 'section_headline',
                    'required'  => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ),
            
            
            
                // Image Settings
                array(
                    'id'        => 'ut_showcase_image_settings',
                    'metapanel' => 'ut-showcase-image-settings',
                    'label'     => 'Showcase Image Settings',
                    'type'      => 'panel_headline',
                ),
                
                array(
                    'id'        => 'crop_size_x',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-image-settings',
                    'label'     => 'Desktop Image Width',
                    'desc'      => '(default:600). Only insert numerics, no trailing px.',
                    'type'      => 'text',
                ),
                
                array(
                    'id'        => 'crop_size_y',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-image-settings',
                    'label'     => 'Desktop Image Height',
                    'desc'      => '(default:400). Only insert numerics, no trailing px.',
                    'type'      => 'text',
                ),
                
                array(
                    'id'        => 'hardcrop',
                    'multikey'  => 'ut_gallery_options',
                    'metapanel' => 'ut-showcase-image-settings',
                    'label'     => 'Activate Image Soft Cropping? ',
                    'desc'      => 'What does Soft Crop mean? A soft crop will never cut off any of the image, it will scale the image down until it fits within the dimensions specified, maintaining its original aspect ratio. What does Hard Crop mean? The image will be scaled and then cropped to the exact dimensions you have specified. Depending on the aspect ratio of the image in relation to the crop size, it might happen that the image will be cut off. .',
                    'type'      => 'select',
                    'choices' => array(    
                        array(
                            'value' => 'off',
                            'label' => 'no, thanks!'
                        ),
                        array(
                            'value' => 'on',
                            'label' => 'yes, please!'
                        )
                    
                    ),
                    'required' => array(
                        'ut_portfolio_type' => 'ut_gallery',
                    ),
                ),
                
                
                
            
        
            )
        
        ) );
        
        // ot_register_enhanced_meta_box( $settings );
        
    }

    // add_action( 'admin_init', 'ut_bklyn_portfolio_manager_settings' );

endif;