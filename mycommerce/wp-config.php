<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mycommerce' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '}5E@B-z9+-G+LR2`n-d4UU+ViQTdcuZ%16[fG#[Al=j;:i(H Hto0L1iczh#4qG,' );
define( 'SECURE_AUTH_KEY',  'DK(>Kg6&UvV/U)RTp,fT{`q:Y#=6g/h[ qxwdB|>M]Ogy~K,uW<iL/uk#) B.N7[' );
define( 'LOGGED_IN_KEY',    '3SBEJ9Qp#X*l]WHhra1um~5$/12g96$o{D3H+i*T#d+p1S}6PPK_t0p3N+cX9MP!' );
define( 'NONCE_KEY',        'E/_qUnG{N<MZ[3g6mXoGC{>}+ <.+&8WeP3s]qwFP5R4,dJ=b];A&c6m{^WO9?RE' );
define( 'AUTH_SALT',        '=2yLu}u5M^,9-*-[=k>p_sd u$=e6J-2P9]:j_Xb:GNYrZ1i1l3ZUxTzM?wu^L*]' );
define( 'SECURE_AUTH_SALT', '1.V<T=`j@rvJq,U2-FoaPjRiyiwd&8lZ)65#fXrl3n6@j^?!lLNtsJ!6>BfU]eK]' );
define( 'LOGGED_IN_SALT',   'h8Yq@)Yz]ZkW=R,N}>UCe(qr}5]. )m?|lX8x;+_{??J%.RLwKKNxN$Zt~.)q81P' );
define( 'NONCE_SALT',       'Hs%?VKS#huLk|vfcu (]QB0W5R;KXQ|I0i2!g7^JxY2|op=Q83@4:2vKotmRqL/H' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
