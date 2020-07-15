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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'borohemen' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3307' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'NWQ.}{v<[@!O/z )y3]ZZmVz]Aed^EI!X[xLW!(Imk(S>W7K2zhYb:2@xnl?`J:6' );
define( 'SECURE_AUTH_KEY',  'kXkx3PVh!]lb^G5QcZaY<82Q.eCN fHbQ4Dr8&C4o%]qsA3&+f{-y[~!%_UzV|yH' );
define( 'LOGGED_IN_KEY',    'w:cs1K9?=nUD7kM|M:7[j)m+7<IRAtCr~`$lFu]vcOv_TN;c0WAZ{/v0]L(_xaN,' );
define( 'NONCE_KEY',        'txe`(@s5KQ-wo$!H+KI!Z#+I#djc$f;:9grKOn+9Ib&WN`@M%[3}H[d.O|mrtx1A' );
define( 'AUTH_SALT',        '+)~YlD%=ACu&$al/k.3_y~(/TN0!e Ga Acj)i&.hLI0@Ww5[5=b@^z^i?C%=zZ3' );
define( 'SECURE_AUTH_SALT', 'x>yKbK*<%sdN3vTFkAR;Pe3t?rBigI1;DUecHiGx42$.INvU>a23pqiNIGIujKRN' );
define( 'LOGGED_IN_SALT',   'Fnhj*5$ Jv25pw;1>I,H@VaFmWL[w~I3<Tw)lB*xu;lcZ1B#>T&DjAif:fb38GSK' );
define( 'NONCE_SALT',       'LYJa VB{H,(t_,cR|E},@F1-:qAZe,h}.Hj6%Q:<Wlt*XH;1JOd|Fbc<m,!9P@:%' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
