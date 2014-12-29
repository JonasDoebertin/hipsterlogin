<?php if(!defined('ABSPATH')) die('Direct access is not allowed.');


/*
	Plugin Name:   Hipster Login
	Plugin URI:    http://codecanyon.net/item/hipster-login-fullscreen-wordpress-login-page/9273815?ref=jdpowered
	Description:   Hipster Login let’s you change your boring WordPress login page into a beautiful, full-screen background login experience in literally 1 minute. You can customize everything: fonts, background images, etc.
	Version:       1.0.2
	Author:        Jonas Döbertin
	Author URI:    http://codecanyon.net/user/jdpowered?ref=jdpowered
 */


/*
	Define some constants, including the current plugin version, it's basename,
	the full path and the url to the plugin files.
 */
define('JD_HIPSTERLOGIN_BASENAME',  plugin_basename(__FILE__));
define('JD_HIPSTERLOGIN_MAINFILE',  __FILE__);
define('JD_HIPSTERLOGIN_PATH',     plugin_dir_path(__FILE__));
define('JD_HIPSTERLOGIN_URL',      plugins_url('', __FILE__));
define('JD_HIPSTERLOGIN_VERSION',  '1.0.2');

/*
	Enabling the developer mode adds some extended debugging options.
	DO NOT ENABLE IN PRODUCTION!
 */
define('JD_HIPSTERLOGIN_DEVMODE', false);


/*
	Check for a compatible version of PHP
 */
if(version_compare(PHP_VERSION, '5.3.0', '<'))
{
	/*
		If the PHP version is too old, we'll import our legacy code. This will
		add a notice to the plugins.php page (stating that the plugin requires
		PHP 5.3.0 or newer) and register a stylesheet for this notification.
		THE MAIN PLUGIN WILL NOT BE LOADED
	 */
	require JD_HIPSTERLOGIN_PATH . 'legacy.php';
}
else
{
	/*
		We do have a version of PHP that matches our criteria. To avoid any
		syntax errors thrown by PHP < 5.3.0 when using namespaces, we'll load
		our bootstrap file that will handle loading the plugin core.
	 */
	require JD_HIPSTERLOGIN_PATH . 'bootstrap.php';
}
