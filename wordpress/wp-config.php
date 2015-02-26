<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wptest');

/** MySQL database username */
define('DB_USER', 'wptest');

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
define('AUTH_KEY',         'Z%W!W%1V^gQ>Nd.r&LF@%@yYI=P7IA}fZhtUT&.!^nrP;%m{VMC3aUL]-@To3/70');
define('SECURE_AUTH_KEY',  '/sBqXr655glHz$Ir?Y*^$;P$ZQU][v[)#|Cw9GRoQ4<guj&Oa+hWIt/Z$RLp{^G{');
define('LOGGED_IN_KEY',    'TO(qRaOl 0QX7LZ/A$9RpXHW- )w(idIy1B>sfc*eeTlc2U |jJPM;s?Q<h J_.J');
define('NONCE_KEY',        'b~=fns$*big+F@FSV.rJq$b#Bt@u^ 38GnP?WGf|PBoEdO]apc/mR)b0rO$WY4Kn');
define('AUTH_SALT',        'I,7/hB$o;Yh,c^rlfD2>{{rc-,LYwf^Rl`<Na=>CB[AB% lH^V-~TnrqbKp^J|^3');
define('SECURE_AUTH_SALT', 'vUqwm|dVF_QTlOjTp~[EBAraB4.NSz&Zo#*_ewK;YgX#:3_A+.ruuAD*8;Rx^=|F');
define('LOGGED_IN_SALT',   'DXr^h!6E[oAKn)so8=[tW,s`>4^DwDau{}O/-aK>Yn.i-wHe9b%#)mS3:oV[NJ7*');
define('NONCE_SALT',       '(4o.P_?~A}>kIGg<,oR]_kTrj$azmh$a<J+U{fyJuX4P-dZ|(H#`ntJ9`fBr^nU]');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
