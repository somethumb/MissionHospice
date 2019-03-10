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
 
//define('WP_HOME','http://198.12.159.205');
//define('WP_SITEURL','http://198.12.159.205');
define( 'FORCE_SSL_LOGIN', true );

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'missionh_db' );

/** MySQL database username */
define( 'DB_USER', 'missionh_user' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Db0uN!3c3' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define('AUTH_KEY',         '8khFNuX!_-zJS/F!XDPvvotNy[Pe0TQUun5`-VEIG3rD*;sqZ7zf+Fc`MXzK>vDv');
define('SECURE_AUTH_KEY',  'HT71]!6a2`J!cQz,G>BmO9v[26>-vHP[afv0bUj#p^6e<-bd[]LZn/f#{Lf?iO-5');
define('LOGGED_IN_KEY',    ':dJFxKGT-TEgntzlD/tx6:)n ?Fm=-,Y|M:9g$8X<~~=JG<M{tIx2}E+voU:D#bm');
define('NONCE_KEY',        'qU8EFAO WJJufD[^QG$bO.6PpA2m.|%=|[-rXz5#y75NK(H)&68K|*Y!u}T7@3PE');
define('AUTH_SALT',        'ox$|S:2<q[j,tI6M}{o8e#J-+m|hb<9/u<-w|.A5Pw(Y(*,n:<dSa?R$mit@+|&5');
define('SECURE_AUTH_SALT', '*SV=NWOZ23H+qn+MvX?|viRJ}w~,efZi{||a3i;&-0MQ^D.%mRApl?ac6 e4 O{H');
define('LOGGED_IN_SALT',   'oBj2GfW EE]eXQ:+eE![TQ8.kn*MC@[AZN7hF(cvF>5V``j}AZ:m@E>KmYSECY~2');
define('NONCE_SALT',       '$dq|;$|9B0z6j~8W{E/|hF`^^+-/N4AsFdQM}/#T&$!KM|*)-AlwIxuPQ%tM|cyK');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'mh_';

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
define('WP_DEBUG_DISPLAY', false);
define('WP_DEBUG_LOG', false);

//define('WPHTTPS_RESET', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
