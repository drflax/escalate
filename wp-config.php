<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_ESCALATE_db' );

/** Database username */
define( 'DB_USER', 'wp_ESCALATE_user' );

/** Database password */
define( 'DB_PASSWORD', 'wp_ESCALATE_pw' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'G|Y&/1-w]C>av_V~ZQ;atdhtcsevib]! U]=[ #sF@z*t:xB<H<n>q1R[,b2NcLk' );
define( 'SECURE_AUTH_KEY',   ' ,|r,eXy_p|Xy[~ZfRvu>Y`q`i7B^ua&!na%I#DQ^;Z|!B?#GS<Jc/a[zGM|,_eS' );
define( 'LOGGED_IN_KEY',     'Td&/w1fK-+X(q*DpM^%xZ v-{MN}MV5@=dh#&?6rrV-f2*i!b}h;/):IsM~@M*Ds' );
define( 'NONCE_KEY',         'lnhV=(ksxI4CVdHp}S0X/QUc}<pZ)dhO4bAd+JN*^1Pvm3/>d)N-0`_H$PRl{H(9' );
define( 'AUTH_SALT',         'q)Qu]PSv~<lAC?SN}J*z_HZ-+wl^H=h`M_Ok8gW4p^`nk[, :,@CNuDp_GO_m@&v' );
define( 'SECURE_AUTH_SALT',  ';,5N@Q;,:+0b_*J[UA$P~)Y3qX}o>P]~6OsW%l|lhSfh7bZA0o(?8(`4h8;=</9Z' );
define( 'LOGGED_IN_SALT',    '::nm7}T1AI_]GaG--=incLMXtMUvpB{VRD1&h^F=f[X5 5Z3<IN7W==z[Ov4(T1y' );
define( 'NONCE_SALT',        'QG!|0A~ShzH7;ReU@N2&^r^cG<W2+J(/3E<=m4ZnIvR-<jyhjX^6{D0}hI~@l+LS' );
define( 'WP_CACHE_KEY_SALT', ']nSRLLgf*TMJaB}DY?q7|qTT<M3Zh;*hET#nf(lU4(6I=%m.~|Urzu><Iq& qB,x' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
