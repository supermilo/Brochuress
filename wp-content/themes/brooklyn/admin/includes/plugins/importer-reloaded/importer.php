<?php

if ( ! class_exists( 'WP_Importer' ) ) {
	
	defined( 'WP_LOAD_IMPORTERS' ) || define( 'WP_LOAD_IMPORTERS', true );
	require ABSPATH . '/wp-admin/includes/class-wp-importer.php';
	
}

require dirname( __FILE__ ) . '/class-logger.php';
require dirname( __FILE__ ) . '/class-logger-html.php';
require dirname( __FILE__ ) . '/class-logger-serversentevents.php';
require dirname( __FILE__ ) . '/class-wxr-importer.php';
require dirname( __FILE__ ) . '/class-wxr-import-info.php';
require dirname( __FILE__ ) . '/class-wxr-import-ui.php';