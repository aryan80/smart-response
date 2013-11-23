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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '5X+3zuQ&HEaro|[!-y3>eaA??E~+V0A+^0CDgop_|5Jo-.{5crS)Ytt2]%P;~M71');
define('SECURE_AUTH_KEY',  '<}#*~g^Tw?,Mj*$|F|s1|UcL(U{z8{D|1&+QNpE?2}6u.D}-ad`XTY<v@P2$]FTj');
define('LOGGED_IN_KEY',    '/,l:+#R>6LwxPLa0.qt]2rx(v:7U-Rp9gYhHAt|X_BN&p!D^CR+yAj4GtC>G=g(<');
define('NONCE_KEY',        'ClR(jjcsJ4 Kdi|TW?RIF8+%u/GvfcZTn[}}Zo7-<+!:|4e0P3U9NUSUGoe{Z39P');
define('AUTH_SALT',        '[qNF>{k05!?$XS$Q1.M?y3Q|wN=UI!>Cx%$tFcu 3t+l[A^^+jufLjpVUsE7KX*:');
define('SECURE_AUTH_SALT', '3^,?Xvx).wKaLHEcGNR6CE-]|/Z742+[lQ9QG~z^PE)k!R@Qx}fg8)O*FHKA9{Os');
define('LOGGED_IN_SALT',   'f42prg=@g}]fcnF&#W9jTSIrak~)2nffBQ`CtK+3|>=w_l3!dO9P5wbhhdusMHF]');
define('NONCE_SALT',       'Hg$I FdV!@0Om(aD#9h9QF%$,[__lknf2--Ty@fgMdNk(1o+`;x#+d Xkt3x!|VX');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
