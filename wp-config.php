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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'k7704447_jobbrd' );

/** MySQL database username */
define( 'DB_USER', 'k7704447_rootjob' );

/** MySQL database password */
define( 'DB_PASSWORD', '0pu$2020' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'Kf?>/HI?xFAZrSpr|/9^+:H!M_0}>(|:@M*nw>Ro&M( P^s3x!xE]i,TE:Co?%/e' );
define( 'SECURE_AUTH_KEY',  'W=Yp#X?ZxjQbKCMlE[)tlGDw<bGgTIAJSigInVjtS4cd)z!G#rghl:&SLP-OA=Zr' );
define( 'LOGGED_IN_KEY',    'B8F6]-8|,T#lT!`Vv,!c=<^lOAie-Uv[+1Y< 31D2#cyCK#j0dUtK%YZmE6k[$z6' );
define( 'NONCE_KEY',        '*h*%W)8^sJ Tb3-m]T e,r7%{}H POq0BOfaGKs.rKCa-%9K$L^F+oi15sVXR}#;' );
define( 'AUTH_SALT',        'EzD`zD|]l(=GTXak5p280A.uSo!w?P2IhMr-,jY%,S;d3KZ&M!uf55Y@I.k[8Now' );
define( 'SECURE_AUTH_SALT', ']^yLLb8?$zo,L{v$Zd}v4iN+cKEGh)>tx=}OK2lfhuY%).lSD@3f,-9HsfBnbDcm' );
define( 'LOGGED_IN_SALT',   'sqwR2WZ]7lH]KXQ}IwP+BwzW@|pBd/^YDsO; hm-GI/p@:vfcy=IKu..wItDFI<e' );
define( 'NONCE_SALT',       'N^EoXZA)zq7peZ-0%84|)IIavE/gE2K)On>yTu=V?,!%i5iJ!H=6]|l7e4Ee:D8=' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
