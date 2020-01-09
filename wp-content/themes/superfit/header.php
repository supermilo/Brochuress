<?php
/**
 * The header for our theme.
 *
 *
 * @package superfit
 */

?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?> >
			
		<?php 
		/**
         * Functions hooked in to superfit_header action.
         *
         * @hooked superfit_template_header 
         */
		do_action('superfit_header'); ?>

		<div id="content-area">