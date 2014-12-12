<?php
namespace jdpowered\HipsterLogin\Helpers;

class Helper {

    /**
     * Get a configuration value from ReduxFramework
     *
     * @since 1.0.0
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public static function getConfigValue($key, $subkey = null, $default = null)
    {
        global $hipsterlogin_options;

        if(!is_null($subkey))
        {
            return (isset($hipsterlogin_options[$key][$subkey]) && !empty($hipsterlogin_options[$key][$subkey])) ? $hipsterlogin_options[$key][$subkey] : $default;
        }
        else
        {
            return (isset($hipsterlogin_options[$key]) && !empty($hipsterlogin_options[$key])) ? $hipsterlogin_options[$key] : $default;
        }
    }

}
