<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'brochuress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'J&?~zvD},F8LV|}-j$3L?)*,n)&1 |.DKtIWhASxt4YJlr+l<4i;~adVHu(J*$>-');
define('SECURE_AUTH_KEY',  '9{E`2|r9@.$xZHuoksc+AMLc1k4lJ[_-g;ah1Zo5+n-mRSuKBr-fhDY~({z02`LT');
define('LOGGED_IN_KEY',    '+sAgpLIuBW+wJ_Ytoxh[~(Bmd -,[;:i[+4oRJWg|yMlNaMRHoucGrV-6f:I@dQM');
define('NONCE_KEY',        'F1$Nkb8oYs-&a-i8v6.XKbXiigUh&9?!+7tjZZL!xnKnMZr7.yZ15b,6R{Z]r;A:');
define('AUTH_SALT',        'u_x-s#Y:p~xq1@lY;s>2tXNH]a`tMbl2d+Hxa_El*Je~L.P$nj]mM?SopjJ-Uu[=');
define('SECURE_AUTH_SALT', 'btF_<3gc}j+0_lyPx0[GDNt~pn^9Gh/XPY.M&9T>n.^EI8Z_|s.^1Hvc2J~-J=1|');
define('LOGGED_IN_SALT',   'X]x#=pI*4|J1k;qm6c&6x;0;J$Z9GW`HOI21Rs<sI*3}#Pd!V|Gff55y%$VmcC*F');
define('NONCE_SALT',       ')NMb+ey|!PR@2RvAE#{!<+~g`(c_fTUs3f<5 vyR?*F<_Ju.MzS<,+c5z;!owi[R');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
