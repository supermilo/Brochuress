<?php 

// initialize header class
$header = new UT_Header_Class();

// create placeholder if necessary
$header->create_header_placeholder(); ?>

<header id="header-section" data-style="<?php echo esc_attr( $header->style ); ?>" data-primary-skin="<?php echo $header->header_primary_skin_data(); ?>" data-secondary-skin="<?php echo $header->header_secondary_skin_data(); ?>" class="<?php echo $header->header_class(); ?>" data-line-height="<?php echo esc_attr( $header->header_data_lineheight() ); ?>" data-total-height="<?php echo esc_attr( $header->header_data_totalheight() ); ?>">
     
	 <?php $header->create_top_header(); ?>
		
     <div class="grid-container">
               
        <div class="ha-header-perspective clearfix">

            <div class="ha-header-front clearfix">
				
				<?php $header->primary_navigation(); ?>

				<div class="site-logo-wrap grid-20 tablet-grid-80 <?php echo $header->site_logo_mobile_grid(); ?>">

					<?php echo $header->create_site_logo(); ?>

				</div>

				<?php $header->secondary_navigation(); ?>

                <?php get_template_part( 'partials/navigation/nav', 'mobile' ); ?>							

            </div>

        </div>
    
    </div> 
    
</header>