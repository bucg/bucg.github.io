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
define('DB_NAME', 'wp432');

/** MySQL database username */
define('DB_USER', 'wp432');

/** MySQL database password */
define('DB_PASSWORD', 'Dx]862SP)D');

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
define('AUTH_KEY',         'x08qatpxjx06nsgmbhxwvh3gjmf8t8h0afl8og9cqeoqoeuk0gmww9pcwsgale07');
define('SECURE_AUTH_KEY',  't3jeqmhbqtkkokyx6dliotkz6jer3bzrfnlstdbkunit101wlp8iexmfhzryocer');
define('LOGGED_IN_KEY',    'xcndprweytfgnvde4b7ncumctv24eu9rb7cle6tjswzmen2ufx81az03wzzj8068');
define('NONCE_KEY',        'a32tziqkger4x3ktgnuieo6crmyqwangusverftbxgwjhw3yic0izwkdxovmhiy3');
define('AUTH_SALT',        'hiewtw1ympcxmlayufjfvqarvbfbq9rrnvy2qt83yzb1uaqmlsmhujdflnmwlhxm');
define('SECURE_AUTH_SALT', 'qrlmtfkyhsqpaenv84wepzhc6dmjg3pdp9lln45pkzw19aql7r74qcvvfesc7mec');
define('LOGGED_IN_SALT',   'xa6awkno0udefhjc7eqslcvdkuxihd2pa2ihmp9syttfc1q8h4apq6yoxhzh792k');
define('NONCE_SALT',       '97j0v2vdb349imafanyi9xqjksxcyzb1bgismybpqjp3whmn9lpggehvhhzqilec');

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
