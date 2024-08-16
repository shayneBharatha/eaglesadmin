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
define( 'DB_NAME', 'eagles_admin_24' );

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
define( 'AUTH_KEY',         '*{ J[WQFJv_M6ZW=ox]*|/bV;H8LG%i2s&zEOgd+^#=R-R|Rf2LbTlO7A_%_tlGc' );
define( 'SECURE_AUTH_KEY',  '~U7x_e!IMl+ega|f)44,3=fsv1MD?N,3)G{TM=#mNh.C}9|IK}D(dUT!8$Mg-?LJ' );
define( 'LOGGED_IN_KEY',    '+ :C~]Z3];e3B1yp% 5XM@@*&T!+~dyN^xaI|eiprXYPP>m| ZnigH.+3D:]4+|4' );
define( 'NONCE_KEY',        '+oQMn7xwWiHgk:6IJOAvhq:H#czsfLFP3ht*^0c2.C]vDo-7T({Z/qmR)WPJIcZ8' );
define( 'AUTH_SALT',        'L#~U mJT*&V#rTRgb)c2gPyjkM}`tMS,l`GaJk2%)/2Ka9}Y4*tTOp%O*WAx#Y|>' );
define( 'SECURE_AUTH_SALT', 'YwrKqAhOuKc{j9tH#t*5~/_[Wq8HpV-*0]7QymyjzOE@<&2:o>4L{7P8iJ eAnh$' );
define( 'LOGGED_IN_SALT',   'SPiyo+JSGHRW6|&E}g9M7E*6gJa*i1*1m jPa|>y2>s{QNdh+uQ|yy38qfPttw;X' );
define( 'NONCE_SALT',       'OM&+cJ[rR*8id_>&&4p=)2o}l(*B.KqWvAhN#HuCpDAx:t~%i&GyDz;NP?P`<T8J' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
