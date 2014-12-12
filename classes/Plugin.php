<?php
namespace jdpowered\HipsterLogin;

use jdpowered\HipsterLogin\Redux\Config as ReduxConfig;
use jdpowered\HipsterLogin\Helpers\Helper;
use jdpowered\HipsterLogin\Helpers\Updater;

class Plugin {

	/**
	 * @type jdpowered\HipsterLogin\Redux\Config
	 * @since 1.0.0
	 */
	protected $config;

	/**
	* Instance of the updater class
	*
	* @type jdpowered\HipsterLogin\Helpers\Updater
	* @since 1.0.0
	*/
	protected $updater;

	/**
	* Instance of the compiler class
	*
	* @type jdpowered\HipsterLogin\Compiler
	* @since 1.0.0
	*/
	protected $compiler;

	/**
	 * Create an instance of the plugin and do the setup
	 *
	 * @action plugins_loaded
	 * @since 1.0.0
	 *
	 * @return jdpowered\HipsterLogin\Plugin
	 */
	public function __construct()
    {
		/*
			Initialize CSS Compiler
		 */
		$this->compiler = new Compiler;

		/*
			Check ReduxFramework version (we need 3.3.8.3, at least).
			If it's too old, we'll load up a notice kindly asking the user to
			update his version of the framework.
			Also we'll skip plugin execution.
		 */
		if(version_compare(\ReduxFramework::$_version, '3.3.8.3', '<'))
		{
			add_action('admin_notices', array($this, 'registerFrameworkAdminNotice'));
			add_action('admin_enqueue_scripts', array($this, 'registerAdminNoticeStyle'));
			return;
		}

		/*
			Load Redux framework and apply configuration
		 */
		$this->config = new ReduxConfig;

		/*
			Initialize Updater
		*/
		$this->updater = new Updater('http://wp-updates.com/api/2/plugin', JD_HIPSTERLOGIN_BASENAME, Helper::getConfigValue('purchase_code', ''));

		/*
			Set custom login and error messages
		 */
		add_action('login_message', array($this, 'modifyBasicMessage'));
		add_action('login_messages', array($this, 'modifyAdvancedMessage'));
		add_action('login_errors', function($message) {
			return '<p class="message  message--error">' . $message . '</p>';
		});

		/*
			Modify the "Shake Effect" error codes
		 */
		add_action('shake_error_codes', array($this, 'modifyShakeErrorCodes'));

		/*
			Register and load textdomain
		*/
		load_plugin_textdomain('hipsterlogin', null, dirname(JD_HIPSTERLOGIN_BASENAME) . '/languages/');

        /*
            Deregister the default login page styles.
			Register custom styles and scripts.
         */
        add_action('login_init', array($this, 'deregisterDefaultLoginScripts'));
        add_action('login_head', array($this, 'printLoginStyles'));
		add_action('login_enqueue_scripts', array($this, 'registerLoginScripts'));

		/*
			Register filter to modify the URL the WordPress logo links to
		 */
		add_action('login_headerurl', array($this, 'modifyHeaderUrl'));

		/*
			Some things that ought to be done at admin pages only.
		 */
		if(is_admin())
		{
			/*
				Register plugin action link
			 */
			add_action('plugin_action_links_' . JD_HIPSTERLOGIN_BASENAME, array($this, 'addPluginActionLink'));

			/*
				Register options page stylesheet
			 */
			add_action('admin_enqueue_scripts', array($this, 'registerAdminStyles'));
		}

	}



	/**************************************************************************\
	*                         MISSING FRAMEWORK NOTICE                         *
	\**************************************************************************/

	public function registerFrameworkAdminNotice()
	{
		include JD_HIPSTERLOGIN_PATH . 'views/notices/framework.php';
	}

	public function registerAdminNoticeStyle()
	{
		wp_enqueue_style('hipsterlogin-notices', JD_HIPSTERLOGIN_URL . '/assets/css/notices.css', array(), JD_HIPSTERLOGIN_VERSION, 'all');
	}





	/**************************************************************************\
	*                             PLUGIN INTERNALS                             *
	\**************************************************************************/

	/**
	* Register options
	*
	* Will be run through register_activation_hook()
	*/
	public static function activatePlugin()
	{
		/* Add option */
		add_option('hipsterlogin_compiled_css', '');
		add_option('hipsterlogin_options', array());
		add_option('hipsterlogin_options-transients', array());
	}

	/**
	* Deregister options
	*
	* Will be run through register_deactivation_hook
	*/
	public static function deactivatePlugin()
	{
		/* Delete option */
		// delete_option('hipsterlogin_compiled_css');
		// delete_option('hipsterlogin_options');
		// delete_option('hipsterlogin_options-transients');
	}

	/**
	 * Add a "Settings" plugin action link
	 *
	 * @action plugin_action_links_hipsterlogin
	 * @since 1.0.0
	 *
	 * @param  array $actionLinks
	 * @return array
	 */
	public function addPluginActionLink($actionLinks)
	{
		$html = '<a href="options-general.php?page=hipsterlogin" title="' . __('Customize Hipster Login', 'hipsterlogin') . '">' . __('Settings', 'hipsterlogin') . '</a>';
		array_unshift($actionLinks, $html);
		return $actionLinks;
	}





	/**************************************************************************\
	*                             CSS COMPILATION                              *
	\**************************************************************************/

	/**
	 * Get the compiled CSS from the database
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function getCompiledCSS()
	{
		return get_option('hipsterlogin_compiled_css', '');
	}





	/**
	* Generate CSS rule for custom CSS
	*
	* @since 1.0.0
	*
	* @param  array $options
	* @return string
	*/
	protected function compileCustomCSS($options)
	{
		/*
			Abort, if no custom rules have been set
		*/
		if( ! isset($options['custom_css']) or empty($options['custom_css']))
			return '';

		/*
			Return CSS
		*/
		return $options['custom_css'];
	}





	/**************************************************************************\
	*                              OPTIONS PAGE                                *
	\**************************************************************************/

	/**
	 * Register the admin stylesheet
	 *
	 * @action admin_enqueue_scripts-settings_page_hipsterlogin
	 * @since 1.0.0
	 */
	public function registerAdminStyles($hook)
	{
		if($hook = 'settings_page_hipsterlogin')
			wp_enqueue_style('hipsterlogin-admin', JD_HIPSTERLOGIN_URL . '/assets/css/admin.css', array(), JD_HIPSTERLOGIN_VERSION, 'all');
	}

    /**************************************************************************\
    *                       STYLES, SCRIPTS & OVERRIDES                        *
    \**************************************************************************/

	/**
	 * Deregister the default styles for the login page
	 *
	 * @action login_init
	 * @since 1.0.0
	 */
    public function deregisterDefaultLoginScripts()
    {
        wp_dequeue_style('login');
		wp_deregister_style('login');
    }

	/**
	 * Print styles for the login page
	 *
	 * NOTE: Generally, it's not a good idea to just echo the <link>-tags from
	 * this hook. It's better to use the `*_enqueue_scripts` hook and register
	 * them properly. However in this case, using the the `login_enqueue_scripts`
	 * hook, WordPress will load the style right before the closing </body>-tag.
	 * And that's bad! We don't want that!
	 *
	 * @action login_head
	 * @since 1.0.0
	 */
    public function printLoginStyles()
    {
        /*
	        Print normalize.css tag
         */
		echo '<link rel="stylesheet" href="' . JD_HIPSTERLOGIN_URL . '/assets/css/normalize.css?ver=3.0.1" media="all" />' . chr(10);

		/*
			Print base style tag
		 */
		echo '<link rel="stylesheet" href="' . JD_HIPSTERLOGIN_URL . '/assets/css/hipsterlogin.css?ver=' . JD_HIPSTERLOGIN_VERSION . '" media="all" />' . chr(10);

		/*
			Print compiled CSS for option values
		 */
		echo '<style>' . $this->getCompiledCSS() . '</style>';

        /*
            Register Google fonts
         */
        //wp_register_style('google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400|PT+Sans', array(), JD_HIPSTERLOGIN_VERSION, 'all');


    }

	/**
	 * Register scripts for the login page
	 *
	 * @action login_enqueue_scripts
	 * @since 1.0.0
	 */
	public function registerLoginScripts()
	{
		wp_register_script('hipsterlogin', JD_HIPSTERLOGIN_URL . '/assets/js/hipsterlogin.js', array('jquery'), JD_HIPSTERLOGIN_VERSION, true);
		wp_enqueue_script('hipsterlogin');
	}

	/**
	 * Modify the header url
	 *
	 * If a custom URL has been set, return it.
	 * Otherwise return the original one.
	 *
	 * @action login_headerurl
	 * @since 1.0.0
	 *
	 * @param  string $url
	 * @return string
	 */
	public function modifyHeaderUrl($url)
	{
		if($customUrl = Helper::getConfigValue('logo_link', null, false))
		{
			return $customUrl;
		}
		return $url;
	}

	/**
	 * Modify the message above the form
	 *
	 * The message will be modified based on the current action
	 * and the users setup.
	 *
	 * @action login_message
	 * @since 1.0.0
	 *
	 * @param  string $message
	 * @return string
	 */
	public function modifyBasicMessage($message)
	{
		global $action;

		/*
			Set message based on current action and the users setup
		 */
		switch($action)
		{
			case 'login':
				$message = $this->getMessage('login', $message);
				break;

			case 'lostpassword':
			case 'retrievepassword':
				$message = $this->getMessage('lostpassword', $message);
				break;

			case 'register':
				$message = $this->getMessage('register', $message);
				break;
		}

		/*
			Wrap message with tags if it's not empty
		 */
		$message = trim(trim($message));
		if( !empty($message))
		{
			return '<p class="title">' . $message . '</p>';
		}

		return '';
	}

	/**
	 * Modify advanced messages
	 *
	 * This includes the "You are now logged out" message and other
	 * similar ones.
	 *
	 * @action login_messages
	 * @since 1.0.0
	 *
	 * @param  string $message
	 * @return string
	 */
	public function modifyAdvancedMessage($message)
	{
		return trim($message);
	}

	/**
	 * [modifyShakeErrorCodes description]
	 *
	 * @action shake_error_codes
	 * @since 1.0.0
	 *
	 * @param  array $codes
	 * @return array
	 */
	public function modifyShakeErrorCodes($codes)
	{
		/*
			Unset all codes that the user wants to have disabled
		 */
		foreach($codes as $key => $code)
		{
			if(Helper::getConfigValue('shake_switch', $code, '0') != '1')
			{
				unset($codes[$key]);
			}
		}
		return array_values($codes);
	}

	/**
	 * Return a message based on the action and the users setup
	 *
	 * @param string $action
	 * @param string $message
	 */
	protected function getMessage($action, $message)
	{
		/*
			Custom Message
		 */
		if(Helper::getConfigValue($action . '_message_switch', null, 'default') == 'custom')
		{
			return Helper::getConfigValue($action . '_message', null, '');
		}

		/*
			No Message
		 */
		if(Helper::getConfigValue($action . '_message_switch', null, 'default') == 'none')
		{
			return '';
		}

		/*
			Default Message
		 */
		else
		{
			return wp_strip_all_tags($message);
		}
	}

	protected function isLogoVariant($subject)
	{
		return in_array($subject, array('light', 'medium', 'dark'));
	}

}
