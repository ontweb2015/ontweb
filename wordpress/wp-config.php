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
define('DB_NAME', 'ontwebwpdb');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         ',lz}gMUhq|_%xP^(cj2l1-N^>W-gb7Z-j/E Vk8tTCGo8XA-+Cy/}>&$Ee*8P]C/');
define('SECURE_AUTH_KEY',  'j{|CzPw[wqy?WKL0S#8|ib6l$m-G^mH 138x5[-m@BvPLg!vB@9ZR_}PVwMy<&6-');
define('LOGGED_IN_KEY',    'I||<DU+wsU.)`r+{[{}u7-l-kK<N(&,wh5Ut$jCV!0oh?ZydIi?1]8@:]<dMvE9P');
define('NONCE_KEY',        '5EJ+uei%`5mj|1!J^1OJ--Taf-y Q+p}[LVP%5-l^^z^X+R3-j2:G!BBqtmf+Zs-');
define('AUTH_SALT',        'd+qR+P)Zr;sfMl|bK#z^%}O9I12~=PQDZ]#|qMo`_^6l*n{KP?--S:2-u30^^F|[');
define('SECURE_AUTH_SALT', 'F<ZnpF`NL$~d^X$@BdJB36QrEOVX56GXatIu-8$LnOdl*2qj7^RK%hcT7W%AE,*y');
define('LOGGED_IN_SALT',   '8R^vY xb`VFj0HkTh/|mQ-&:UoNHM+I-JH2{X6>g!n9_(<UFT[R7w7K[~syvg+uS');
define('NONCE_SALT',       'r!v_k|~+Q}rH@fIPT3I6twsM({ITUj:@Hbcn.>s7)[Z=c0rJXk]DA3eN+B 2PF-+');

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
