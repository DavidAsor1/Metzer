<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'metzer');

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
define('AUTH_KEY',         'gU%RY:%Z|J|JcK)YIM9$BztQkUIC-Krh#+Hw/tcly7 &;~&eyva]avzE^74Nfozp');
define('SECURE_AUTH_KEY',  'E{e#OWK>W2D[4tK^03s/Q*E~fuQ(,EnNV/xg)KqK&f)?,6u#>Q7qzc`>)l=qXo}$');
define('LOGGED_IN_KEY',    '3G|ggq;Iu#ROEF_u35Z7xr$8)[Kt28ta+:IC:~%l T:+&=RSc8mIA@sFj:?f)/r+');
define('NONCE_KEY',        '(18XB79wVNrvwE4 uW]pne[sS~6&.ayz)a!dv.=Z?/16<hy~]/ouHMQUO;IF(C][');
define('AUTH_SALT',        'qrY))J;&t<uz`g2)^i`Wsm:ex^*YpD9{2y(z@P=e793j3(P(<XACw$58V6^.hR+K');
define('SECURE_AUTH_SALT', ']%,8<STax<<D#$/4[)/32THbv*/g.cP;SSn%49x!n?s2(jGPo,K$]sJQjC^Gj,ey');
define('LOGGED_IN_SALT',   '_zE@rO P(!c`sh)(j={A`Hy&u3CP1/Q+TlC}8AYHhLyj$)T?;E0g!h?-BRaFkC`L');
define('NONCE_SALT',       'o}tyY~DQ,!R6Hp@8+t!&]01-O5[)</MyJW8P!mu;P,kv[gv?iGlj&?hHnD{eatll');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);
define( 'WP_MEMORY_LIMIT', '512M' );


@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

 

define('WP_ALLOW_MULTISITE', true);
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'localhost');
define('PATH_CURRENT_SITE', '/metzer-website/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
