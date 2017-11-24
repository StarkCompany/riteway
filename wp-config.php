<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '923327_wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'D`TiW35j@+[`f.*O_ 4z#UJt[Wg#Pi}Ucr6D;a6Lt|cJ:dUsDU!Ui Ri;-zXrVSa');
define('SECURE_AUTH_KEY',  'a1Na+$g}#R+owL^c3Bv$U]^k%(i<lsH3nKKv!3ECYxlV56|Mjr?`v*6]6~:vSg(E');
define('LOGGED_IN_KEY',    'Gg};&XgMQKH4AdQ7;vdWF=+!-I&D21w#/W?oN?kc M9oz&}Pv9<!wVpQ2AUnIdRU');
define('NONCE_KEY',        'B;QAj%g`Eat8|L:39L+ w)%>zh!z{aX*&wpA0g[Bvz;1KfLY5lmb--?XoIpqgMJ{');
define('AUTH_SALT',        'e,vQ4RrgO6}aR9va`<JsLh]19S&`;v(FL2Gp}B fCZsUc)oE|-Cd[y&4X7+&NXm1');
define('SECURE_AUTH_SALT', 'j@!mmY_e>@)ox-pbQd^@|LZCPMvQO|@YtKiEJ5~#TR7h -e6i5|+KwW8SW)zC)89');
define('LOGGED_IN_SALT',   '2wJI>_ fEdTRXX@EZ$+9AA+ /R-Jjn#,CS-PErYuy)]Y4-_eX+RK>gP%9g42j5c-');
define('NONCE_SALT',       'eT}N~g~fvBzg7|?6wZww]S@yU]2qc7A~0<)rexF:|@S2kTj|r_2Z|yPKg{S~xmO5');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 *
 *
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);
  define('WP_DEBUG_DISPLAY', false); // Turn forced display OFF
  define('WP_DEBUG_LOG',     true);  // Turn logging to wp-content/debug.log ON


/* Multisite */
define( 'WP_ALLOW_MULTISITE', true );

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'riteway.localhost:4567');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/*Default Multisite Theme*/
define( 'WP_DEFAULT_THEME', 'brokerage' );
require_once(ABSPATH . 'wp-settings.php');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
