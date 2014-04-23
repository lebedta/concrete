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
define('DB_NAME', 'sergey_concrete');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Mernap)72');

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
define('AUTH_KEY',         '2,-V^+ee|3u UMp?,yfvc%]DaG8?c:[e,@|A#UL.L<#C{YjL-ep7P+7-m(AGCfT}');
define('SECURE_AUTH_KEY',  'r9rv<Cv}F>.Q,H|7cI2T~=y~m@K(qU9qFn;-MQiHQB1d6n6aURwz~4-|i<JF=BDU');
define('LOGGED_IN_KEY',    'U|yydWHJ%mFbP]s%n^|Z-9+#$%@, KwcIY8C[=G,D4$++CY^XVb@?|7M81h0zlSC');
define('NONCE_KEY',        'E/S~&LDF[+S</^cq>c`#q.aF+_)Cvq8ODcH~SfX5iH.piuWe+>*MRM=nl>Db+pSO');
define('AUTH_SALT',        '(_J*|5A{.CxhCe+nsB`|wsS8Xe2LSvpX@XSIe%;ixIX*/A2l,63~g;8O+Z+F-X8Z');
define('SECURE_AUTH_SALT', 'I+b6+cJiCGoBVDH@;N6)N`Fbk3%UrDBxRoE%%/NFI++iSkEf7MX]qamD~$oblCX%');
define('LOGGED_IN_SALT',   'gUD-`bWmyP||<<Rs}8x5&x_uAz~X~-!>#jF57Oz$$4sH_rFo%AQ/U8fP3J+(%3o|');
define('NONCE_SALT',       '8`bZy4-^+%U^N3#(ln+;6*MJtzX%uzn]M]>UX-:[3>4(?q,INQ4.C7}taa)*-q+0');

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
