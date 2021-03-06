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
define('DB_NAME', 'numanna_db');

/** MySQL database username */
define('DB_USER', 'numanna_db');

/** MySQL database password */
define('DB_PASSWORD', 'q$Q^MVkqca?G');

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
define('AUTH_KEY',         '38PKz=~|S=<qSYR)k4F=LW2GdbSbs<OerGMa!#YBqQ_2LG^OTL|rBu0jXFCX$>xe');
define('SECURE_AUTH_KEY',  '8ExcA$a@,-qzgIRSD^:{M-G+!w1@p| Te~]e`YhPZ:6Uh&<a7]-dQlH`vS@bvHGz');
define('LOGGED_IN_KEY',    '!P)sbM)T%hR:{ICbVY d+)|j%(fZKX|sqcGZ0`NUo(f8~s^)sxzK:jAR:,cK/@])');
define('NONCE_KEY',        '[2S65GEJ(OgM0i$t)pv6@yDX4ku$eD%Cgk[&F[]Gph2xhe} j^<; __eiHH_??g}');
define('AUTH_SALT',        '#t{;J6T.AfflsoA1(;ANo/}r<gl%TX|:u)e$O!wq`Rs7!f}Y~$u99tinpy<i[>~|');
define('SECURE_AUTH_SALT', '},#Ds_z)q$yZ6%vBv8Dc+q8g&y{:xaw1[VhYQIyq:ZB,<8*CYP@NsPM[N_+F7f/ ');
define('LOGGED_IN_SALT',   'pA Rs_}iVL9o_Dh7<H!o,D)?zGfPoY4Sbv$oeUMqe{8|rS<G!k>:{l-Ux!n$&S^Z');
define('NONCE_SALT',       '_i:(54h%~HH+OQ_ubH}Tkn p0yP VC/o&ne*vr)Q1*wt{]QFWtij];&Pcjufq!]:');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
