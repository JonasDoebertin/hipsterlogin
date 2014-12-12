<?php if(!defined('ABSPATH')) die('Direct access is not allowed.');

/*
    We do have a version of PHP that fits our needs. So let's go ahead and
    register the autoloader for our plugin classes.
 */
require JD_HIPSTERLOGIN_PATH . 'vendor/autoload.php';

/*
    Load the ReduxFramework core.
    But first, double check if another plugin included it previously.
 */
if( ! class_exists('ReduxFramework'))
{
    require JD_HIPSTERLOGIN_PATH . 'vendor/redux-framework/framework.php';
}


/*
    Register activation and deactivation hooks
 */
register_activation_hook(JD_HIPSTERLOGIN_MAINFILE, array('jdpowered\HipsterLogin\Plugin', 'activatePlugin'));
register_deactivation_hook(JD_HIPSTERLOGIN_MAINFILE, array('jdpowered\HipsterLogin\Plugin', 'deactivatePlugin'));


/*
    Finally, get things rolling by instanciating the core plugin class within
    the "plugins_loaded" hook.
 */
add_action('plugins_loaded', function()
{
    global $JD_HipsterLogin;
    $JD_HipsterLogin = new jdpowered\HipsterLogin\Plugin;
});
