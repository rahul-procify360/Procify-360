<?php
define('WP_MEMORY_LIMIT', '256M');
define('WP_CACHE', true);
define ('WPCF7_LOAD_JS', false );
define('WPCF7_LOAD_CSS', false);
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
define('DB_NAME', 'px_360');
/** Database username */
define('DB_USER', 'root');
/** Database password */
define('DB_PASSWORD', '');
/** Database hostname */
define('DB_HOST', 'localhost');
/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');
/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
/* * #@+
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
define('AUTH_KEY', 'qJ6+OLM_ckRSL$8zc{k_b*3DB_iH|ldAvAL*8_WO,E=e+PWh. J|@PQkM}~ ;$ z');
define('SECURE_AUTH_KEY', '{TG.< xty8+KH:*;iKJ?0W#+wU0F^8:zT,W>RjE);5FAYLp2RRqw//Vs|Z*JlD}g');
define('LOGGED_IN_KEY', '}6wq%e/blRxmbM uWTW^p+k61$v%q&1SRayewz1qJk7^ZpCe>hv+5V0zKSLPQ!d+');
define('NONCE_KEY', '}s/fIU+! |s#>U-&AHLNOHYM/BCA,ehr?S5?w|f#2QNrs m^,p|7*|Cnx2B-s#X+');
define('AUTH_SALT', 'MF7;`qR8R|f srgG]1NCf;{_8Ls*W5<[:U)>BjK:Ni9U$Plh%B+K1J(n)iLu$gU<');
define('SECURE_AUTH_SALT', 'W/?BMjgZtfw!pQ+-^Ixc^~RX3xOkh:s0k;PI*@zd S~?bMz=P_lIm^1}3/=W,F#3');
define('LOGGED_IN_SALT', 'YLa-_n,FI3*ur[]VNeN^4]Yp}&$>>apj&uUMM)7g$>yolVnz4sqGP(Y~O#a3kzM{');
define('NONCE_SALT', '!gT6(HO&KK]?-?Rsal(NNQ^1S4Ifaqx5 ,~%`4Vu,p2 ?.[d|L/~qxP]Bl5XxRt%');
/* * #@- */
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
define('WP_DEBUG', false);
/* Add any custom values between this line and the "stop editing" line. */
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';