<?php
namespace jdpowered\HipsterLogin\Redux;

class Config {

    /**
     * @type array
     * @since 1.0.0
     */
    protected $settings = array();

    /**
     * @type array
     * @since 1.0.0
     */
    protected $sections = array();

    /**
     * @type \ReduxFramework
     * @since 1.0.0
     */
    protected $redux;

    /**
     * Create new Instance
     *
     * @since 1.0.0
     *
     * @return \jdpowered\HipsterLogin\Redux\Config
     */
    public function __construct()
    {
        /*
            Abort, if Redux isn't enabled correctly
         */
        if( ! class_exists('ReduxFramework'))
            return;

        /*
            Set the default settings, sections & fields
         */
        $this->setSettings();
        $this->setSections();

        /*
            Create instance of Redux and apply settings and sections
         */
        $this->redux = new \ReduxFramework($this->sections, $this->settings);
    }

    /**
     * Set basic Redux configuration
     *
     * @since 1.0.0
     */
    protected function setSettings()
    {
        $this->settings = array(

            /*
                General configuration
             */
            'opt_name'          => 'hipsterlogin_options',
            'display_name'      => __('Hipster Login', 'hipsterlogin'),
            'display_version'   => JD_HIPSTERLOGIN_VERSION,

            /*
                Menu & Page setup
             */
            'menu_type'         => 'submenu',
            'allow_sub_menu'    => false,
            'menu_title'        => __('Hipster Login', 'hipsterlogin'),
            'page_title'        => __('Hipster Login Settings', 'hipsterlogin'),
            'admin_bar'         => false,
            'page_parent'       => 'options-general.php',
            'page_permissions'  => 'manage_options',
            'menu_icon'         => '',
            'page_icon'         => 'icon-themes',
            'page_slug'         => 'hipsterlogin',
            'page_priority'     => null,

            /*
                Panel setup
             */
            'last_tab'          => '',
            'save_defaults'     => true,
            'default_show'      => false,
            'default_mark'      => '',
            'show_import_export' => false,

            /*
                CSS output
             */
            'async_typography'  => false,
            'output'            => true,
            'output_tag'        => true,
            'disable_google_fonts_link' => false,
            'output_location'   => array('login'),

            /*
                Additional advanced options
             */
            'dev_mode'          => JD_HIPSTERLOGIN_DEVMODE,
            'customizer'        => false,
            'transient_time'    => 60 * MINUTE_IN_SECONDS,
            'database'          => '',
            'system_info'       => false,

            /*
                Intro & Footer Texts
             */
            'footer_credit'     => ' ',
            'footer_text'       => '',
            'intro_text'        => '',

            /*
                Share Icons
             */
            'share_icons'       => array(
                array(
                    'url'   => 'http://codecanyon.net/user/jdpowered?ref=jdpowered#contact',
                    'title' => 'Support',
                    'icon'  => 'el-icon-question-sign'
                ),
            ),

            /*
                Hint display configuration
             */
            'hints' => array(
                'icon'          => 'icon-question-sign',
                'icon_position' => 'right',
                'icon_color'    => 'lightgray',
                'icon_size'     => 'large',
                'tip_style'     => array(
                    'color'         => 'dark',
                    'shadow'        => false,
                    'rounded'       => false,
                    'style'         => 'bootstrap',
                ),
                'tip_position'  => array(
                    'my' => 'top left',
                    'at' => 'bottom right',
                ),
                'tip_effect'    => array(
                    'show'  => array(
                        'effect'   => 'fade',
                        'duration' => '300',
                        'event'    => 'mouseover',
                    ),
                    'hide'      => array(
                        'effect'   => 'fade',
                        'duration' => '300',
                        'event'    => 'click mouseleave',
                    ),
                ),
            )
        );
    }

    /**
     * Set settings sections and actual settings
     *
     * @since 1.0.0
     */
    protected function setSections()
    {
        /*
            Automatic Updates section
         */
        $this->sections[] = array(
            'title'     => __('Automatic Updates', 'hipsterlogin'),
            'desc'      => __('&raquo;Hipster Login&laquo; features a way to automatically update itself, just like any WordPress.org plugin. You can set it up here.', 'hipsterlogin'),
            'icon'      => 'el-icon-refresh',
            'fields'    => $this->getUpdatesSectionFields(),
        );

        /*
            Presets section
         */
        $this->sections[] = array(
            'title'     => __('Premade Designs', 'hipsterlogin'),
            'desc'      => __('To give you a little jumpstart with &raquo;Hipster Login&laquo; we\'ve prepared some premade designs for you. Choose the one you like most as a base and customize it to your needs afterwards.', 'hipsterlogin'),
            'icon'      => 'el-icon-magic',
            'fields'    => $this->getPresetsSectionFields(),
        );

        /*
            General Options section
         */
        $this->sections[] = array(
            'title'     => __('General Options', 'hipsterlogin'),
            'desc'      => __('Here you\'ll find some general options regarding all different page types.', 'hipsterlogin'),
            'icon'      => 'el-icon-website',
            'fields'    => $this->getGeneralSectionFields(),
        );

        /*
            Background Section
         */
        $this->sections[] = array(
            'title'     => __('Background Options', 'hipsterlogin'),
            'desc'      => __('This section allows you to choose one of the background images or specify a custom one.', 'hipsterlogin'),
            'icon'      => 'el-icon-picture',
            'fields'    => $this->getBackgroundSectionFields(),
        );

        /*
            Logo Section
         */
        $this->sections[] = array(
            'title'     => __('Logo Options', 'hipsterlogin'),
            'desc'      => __('Customize the default WordPress logo on top of the pages or upload your own.', 'hipsterlogin'),
            'icon'      => 'el-icon-wordpress',
            'fields'    => $this->getLogoSectionFields(),
        );

        /*
            Messages Section
         */
        $this->sections[] = array(
            'title'     => __('Message & Error Options', 'hipsterlogin'),
            'desc'      => __('Set titles that will be display right below the logo and change the look of the error messages.', 'hipsterlogin'),
            'icon'      => 'el-icon-comment',
            'fields'    => $this->getMessageSectionFields(),
        );

        /*
            Form Elements Options section
         */
        $this->sections[] = array(
            'title'     => __('Form Options', 'hipsterlogin'),
            'desc'      => __('Modify the form inputs, buttons and toggle buttons.', 'hipsterlogin'),
            'icon'      => 'el-icon-lines',
            'fields'    => $this->getFormElementsSectionFields(),
        );

        /*
            Custom CSS section
         */
        $this->sections[] = array(
            'title'     => __('Custom CSS', 'hipsterlogin'),
            'desc'      => __('Add custom CSS rules to be included on the pages.', 'hipsterlogin'),
            'icon'      => 'el-icon-css',
            'fields'    => $this->getCssSectionFields(),
        );

        /*
            Import / Export section
         */
        $this->sections[] = array(
            'title'     => __('Import / Export', 'hipsterlogin'),
            'desc'      => __('Exporting your &raquo;Hipster Login&laquo; options is a convenient way to create a backup of your settings. You can also use an export of your settings to transfer your login page style to another WordPress site using &raquo;Hipster Login&laquo;.', 'hipsterlogin'),
            'icon'      => 'el-icon-hdd',
            'fields'    => $this->getImportExportSectionFields(),
        );

        /*
            Documentation section
         */
        $this->sections[] = array(
            'title'     => __('Documentation', 'hipsterlogin'),
            'desc'      => __('Everybody needs some basic information to get started.', 'hipsterlogin'),
            'icon'      => 'el-icon-question-sign',
            'fields'    => $this->getDocumentationSectionFields(),
        );

        /*
            Credit section
         */
        $this->sections[] = array(
            'title'     => __('Credits', 'hipsterlogin'),
            'desc'      => __('&raquo;Hipster Login&laquo; makes use of some awesome work created by others. All these fine people deserve to be mentioned. So let\'s go ahead!', 'hipsterlogin'),
            'icon'      => 'el-icon-info-sign',
            'fields'    => $this->getCreditsSectionFields(),
        );

    }

    /**
     * Return "Automatic Updates" section fields
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getUpdatesSectionFields()
    {
        return array(

            /*
                Enable Updates field
             */
            array(
                'id'       => 'enable_updates',
                'type'     => 'switch',
                'title'    => __('Enable Automatic Updates', 'hipsterlogin'),
                'subtitle' => __('If you enable this setting, &raquo;Hipster Login&laquo; will receive automatic plugin updates, just like any other WordPress plugin. However, please make sure to fill in your Envato Purchase Code below.', 'hipsterlogin'),
                'compiler' => false,
                'default'  => false,
                'on'       => __('On', 'hipsterlogin'),
                'off'      => __('Off', 'hipsterlogin'),
            ),

            /*
                Purchase Code field
             */
            array(
                'id'          => 'purchase_code',
                'type'        => 'text',
                'title'       => __('Envato Purchase Code', 'hipsterlogin'),
                'subtitle'    => __('Make sure to fill in your Envato Purchase Code here.', 'hipsterlogin'),
                'desc'        => '<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-can-I-find-my-Purchase-Code-" target="_blank">' . __('Where can I find my ourchase code?', 'hipsterlogin') . '</a>',
                'compiler'    => false,
                'required'    => array('enable_updates', 'equals', true),
                'placeholder' => 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX',
            ),
        );
    }

    /**
     * Return "Premade Designs" section fields
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getPresetsSectionFields()
    {
        return array(
            array(
                'id'       => 'presets',
                'type'     => 'image_select',
                'title'    => __('Premade Design', 'hipsterlogin'),
                'subtitle' => __('Choose one of the premade designs here or create your own style.', 'hipsterlogin'),
                'compiler' => false,
                'default'  => 'starry',
                'presets'  => true,
                'options'  => array(
                    'starry'   => array(
                        'alt'      => __('Starry Night', 'hipsterlogin'),
                        'img'      => JD_HIPSTERLOGIN_URL . '/assets/images/presets/starry.jpg',
                        'presets'  => $this->getPresetOptions('starry'),
                    ),
                    'flatui'   => array(
                        'alt'      => __('Flat UI', 'hipsterlogin'),
                        'img'      => JD_HIPSTERLOGIN_URL . '/assets/images/presets/flatui.jpg',
                        'presets'  => $this->getPresetOptions('flatui'),
                    ),
                ),
            ),
        );
    }

    /**
     * Return "General Options" section fields
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getGeneralSectionFields()
    {
        return array(

            /*
                Base Typography
             */
            array(
                'id'          => 'base_typography',
                'type'        => 'typography',
                'title'       => __('Base Typography', 'hipsterlogin'),
                'subtitle'    => __('Set the base font family and style. This will style all texts, links and buttons as long as you don\'t decide to override it. You can even choose a Google Webfont, everything will be handled automatically for you.', 'hipsterlogin'),
                'compiler'    => array('body'),
                'line-height' => false,
                'text-align'  => false,
                'units'       =>'px',
                'subsets'     => false,
                'google'      => true,
                'color'       => true,
                'default'     => array(
                    'color'       => '#ffffff',
                    'font-family' => 'Lato',
                    'google'      => true,
                    'font-style'  => '300',
                    'font-size'   => '18px',
                ),
            ),

            /*
                Shake Effekt
             */
            array(
                'id'       => 'shake_switch',
                'type'     => 'checkbox',
                'title'    => __('Shake Effect', 'hipsterlogin'),
                'subtitle' => __('Enable or disable the "Shake Effect" that appears when entering wrong login credentials. A checked box means the "Shake Effect" is enabled for this event.', 'hipsterlogin'),
                'compiler' => false,
                'options'  => array(
                    'empty_username'     => __('Empty Username Field', 'hipsterlogin'),
                    'empty_password'     => __('Empty Password Field', 'hipsterlogin'),
                    'empty_email'        => __('Empty Email Field', 'hipsterlogin'),
                    'invalid_username'   => __('Invalid Username', 'hipsterlogin'),
                    'invalid_email'      => __('Invalid Email', 'hipsterlogin'),
                    'incorrect_password' => __('Incorrect Password', 'hipsterlogin'),
                    'invalidcombo'       => __('Invalid Combination', 'hipsterlogin'),
                ),
                'default' => array(
                    'empty_username'     => true,
                    'empty_password'     => true,
                    'empty_email'        => true,
                    'invalid_username'   => true,
                    'invalid_email'      => true,
                    'incorrect_password' => true,
                    'invalidcombo'       => true,
                ),
            ),

            /*
                Enable Footer Links Typography
             */
            array(
                'id'       => 'footer_typography_switch',
                'type'     => 'switch',
                'title'    => __('Footer Links Typography', 'hipsterlogin'),
                'subtitle' => __('Choose this option if you want to modify the style the footer links pick up from your base typography.', 'hipsterlogin'),
                'compiler' => true,
                'default'  => false,
                'on'       => __('Enabled', 'hipsterlogin'),
                'off'      => __('Disabled', 'hipsterlogin'),
            ),

            /*
                Footer Links Typography
             */
            array(
                'id'          => 'footer_typography',
                'type'        => 'typography',
                'title'       => __('Footer Links Typography', 'hipsterlogin'),
                'subtitle'    => __('This will style the "Register" and "Lost your password?" links at the bottom of the forms.', 'hipsterlogin'),
                'required'    => array('footer_typography_switch', 'equals', true),
                'compiler'    => array('#nav'),
                'line-height' => false,
                'text-align'  => true,
                'units'       => 'px',
                'subsets'     => false,
                'google'      => false,
                'color'       => true,
                'font-family' => false,
                'default'     => array(
                    'color'       => '#ffffff',
                    'font-style'  => '300',
                    'font-size'   => '18px',
                    'text-align'  => 'center',
                ),
            ),
        );
    }

    /**
     * Return "BAckground Options" section fields
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getBackgroundSectionFields()
    {
        return array(
            /*
                Background Type
             */
            array(
                'id'       => 'background_type',
                'type'     => 'button_set',
                'title'    => __('Background Type', 'hipsterlogin'),
                'subtitle' => __('Choose whether you want to use a solid color, one of the included images, or a custom image you want to upload.', 'hipsterlogin'),
                'compiler' => true,
                'default'  => 'included',
                'options'  => array(
                    'color'    => 'Solid Color',
                    'included' => 'Included Image',
                    'custom'   => 'Custom Image'
                ),
            ),

            /*
                Solid Background Color
             */
            array(
                'id'          => 'background_color',
                'type'        => 'color',
                'title'       => __('Background Color', 'hipsterlogin'),
                'subtitle'    => __('Choose a background color. Note: If you\'re using one of the predefined or a custom background image, you should choose a related color here.', 'hipsterlogin'),
                'compiler'    => true,
                'transparent' => false,
                'validate'    => 'color',
                'default'     => '#2ecc71',
            ),

            /*
                Included Background Images
             */
            array(
                'id'       => 'included_background_image',
                'type'     => 'image_select',
                'title'    => __('Included Image: Backgrounds', 'hipsterlogin'),
                'subtitle' => __('Select one of these awesome premade full screen background images from various websites. Full credits can be found by visiting the &raquo;Credits&laquo; tab.', 'hipsterlogin'),
                'compiler' => true,
                'options'  => array(
                    JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-01.jpg' => array(
                        'alt'   => 'Background 01',
                        'img'   => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-01-preview.jpg',
                    ),
                    JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-02.jpg' => array(
                        'alt'   => 'Background 02',
                        'img'   => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-02-preview.jpg',
                    ),
                    JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-03.jpg' => array(
                        'alt'   => 'Background 03',
                        'img'   => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-03-preview.jpg',
                    ),
                    JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-04.jpg' => array(
                        'alt'   => 'Background 04',
                        'img'   => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-04-preview.jpg',
                    ),
                    JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-05.jpg' => array(
                        'alt'   => 'Background 05',
                        'img'   => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-05-preview.jpg',
                    ),
                    JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-06.jpg' => array(
                        'alt'   => 'Background 06',
                        'img'   => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-06-preview.jpg',
                    ),
                    JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-07.jpg' => array(
                        'alt'   => 'Background 07',
                        'img'   => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-07-preview.jpg',
                    ),
                    JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-08.jpg' => array(
                        'alt'   => 'Background 08',
                        'img'   => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-08-preview.jpg',
                    ),
                    JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-09.jpg' => array(
                        'alt'   => 'Background 09',
                        'img'   => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-09-preview.jpg',
                    ),
                    JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-10.jpg' => array(
                        'alt'   => 'Background 10',
                        'img'   => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-10-preview.jpg',
                    ),
                    JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-11.jpg' => array(
                        'alt'   => 'Background 11',
                        'img'   => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-11-preview.jpg',
                    ),
                    JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-12.jpg' => array(
                        'alt'   => 'Background 12',
                        'img'   => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-12-preview.jpg',
                    ),
                    JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-13.jpg' => array(
                        'alt'   => 'Background 13',
                        'img'   => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-13-preview.jpg',
                    ),
                ),
                'default' => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-10.jpg',
            ),

            /*
                Custom Background field
             */
            array(
                'id'          => 'custom_background_image',
                'type'        => 'media',
                'title'       => __('Custom Image: Upload', 'hipsterlogin'),
                'subtitle'    => __('Choose or upload your own custom background image. Please note: You want to choose an image with a relativly large size, as it may be streched to full background size. For best looking results, choose an image of about 2560 x 1440 pixels.', 'hipsterlogin'),
                'compiler'    => true,
                'url'         => false,
                'preview'     => true,
                'placeholder' => __('No custom background selected', 'hipsterlogin'),
                'readonly'    => true,
            ),

            /*
                Background Image Style
             */
            array(
                'id'               => 'background_style',
                'type'             => 'background',
                'title'            => __('Background Image Style', 'hipsterlogin'),
                'subtitle'         => __('Modify the positioning of the background image.', 'hipsterlogin'),
                'compiler'         => true,
                'background-color' => false,
                'background-image' => false,
                'preview_media'    => false,
                'preview'          => false,
                'transparent'      => false,
                'default'          => array(
                    'background-repeat'     => 'no-repeat',
                    'background-attachment' => 'scroll',
                    'background-position'   => 'center center',
                    'background-size'       => 'cover',
                ),
            ),
        );
    }

    /**
     * Return "Logo Options" section fields
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getLogoSectionFields()
    {
        return array(
            array(
                'id'       => 'logo_display',
                'type'     => 'button_set',
                'title'    => __('Logo Display', 'hipsterlogin'),
                'subtitle' => __('Choose whether you want to use the default WordPress logo, a custom logo you want to upload or no logo at all.', 'hipsterlogin'),
                'compiler' => true,
                'default'  => 'default',
                'options'  => array(
                    'none'     => 'Hide Logo',
                    'default'  => 'Default WordPress Logo',
                    'custom'   => 'Custom Logo'
                ),
            ),
            array(
                'id'       => 'default_logo_variant',
                'type'     => 'button_set',
                'title'    => __('Default WordPress Logo: Logo Color', 'hipsterlogin'),
                'subtitle' => __('If you\'ve choosen to display the default WordPress logo, you may specify whether it should be displayed in black, medium gray or white.', 'hipsterlogin'),
                'compiler' => true,
                'default'  => 'light',
                'options'  => array(
                    'light'    => 'Light',
                    'medium'   => 'Medium',
                    'dark'     => 'Dark'
                ),
            ),
            /*
                Custom logo image field
             */
            array(
                'id'          => 'custom_logo_image',
                'type'        => 'media',
                'title'       => __('Custom Logo: Logo Image', 'hipsterlogin'),
                'subtitle'    => __('If you\'ve choosen to display a custom logo, you want to choose or upload your logo image here.', 'hipsterlogin'),
                'compiler'    => true,
                'url'         => false,
                'preview'     => true,
                'placeholder' => __('No custom logo selected', 'hipsterlogin'),
                'readonly'    => true,
            ),
            /*
                Logo height field
             */
            array(
                'id'       => 'logo_height',
                'type'     => 'dimensions',
                'title'    => __('Logo Image Height', 'hipsterlogin'),
                'subtitle' => __('Change the height of your custom logo image if you need to. The width will adapt automatically.', 'hipsterlogin'),
                'compiler' => array('.login h1 a'),
                'width'    => false,
                'height'   => true,
                'units'    => array('px', 'em'),
                'default'  => array(
                    'height'   => '80',
                    'units'    => 'px',
                ),
            ),
            array(
                'id'       => 'logo_alignment',
                'type'     => 'button_set',
                'title'    => __('Logo Image Alignment', 'hipsterlogin'),
                'subtitle' => __('Some logos look better when aligned to the left or to the right.', 'hipsterlogin'),
                'compiler' => true,
                'default'  => 'center',
                'options'  => array(
                    'left'     => __('Left', 'hipsterlogin'),
                    'center'   => __('Center', 'hipsterlogin'),
                    'right'    => __('Right', 'hipsterlogin'),
                ),
            ),
            array(
                'id'       => 'logo_transparency',
                'type'     => 'slider',
                'title'    => __('Logo Image Transparency', 'hipsterlogin'),
                'subtitle' => __('(percent) Allows for translucent logo images.', 'hipsterlogin'),
                'compiler' => true,
                'default'  => '0',
                'min'      => 0,
                'max'      => 100,
                'step'     => 1,
            ),
            array(
                'id'          => 'logo_link',
                'type'        => 'text',
                'title'       => __('Logo Link URL', 'hipsterlogin'),
                'subtitle'    => __('By default, the WordPress logo links back to wordpress.org. However, you may change the destination of this link here.'),
                'compiler'    => false,
                'default'     => '',
                'validate'    => 'url',
                'msg'         => __('Please enter a valid url', 'hipsterlogin'),
                'placeholder' => 'http://example.com/',
            ),
        );
    }

    /**
     * Return "Messages & Errors Options" section fields
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getMessageSectionFields()
    {
        return array(

            /*
                Enable Login Message
             */
            array(
                'id'       => 'login_message_switch',
                'type'     => 'button_set',
                'title'    => __('"Login" Page Title', 'hipsterlogin'),
                'subtitle' => __('Choose the type of title that will be displayed right above to login form. You can choose between no title at all, the default title or a custom title you specify below.', 'hipsterlogin'),
                'compiler' => false,
                'default'  => false,
                'options'  => array(
                    'custom'     => __('Custom Message', 'hipsterlogin'),
                    'default'   => __('Default Message', 'hipsterlogin'),
                    'none'    => __('No Message', 'hipsterlogin'),
                ),
                'default' => 'default',
            ),

            /*
                Login Message
             */
            array(
                'id'       => 'login_message',
                'type'     => 'text',
                'title'    => __('Custom "Login" Page Title', 'hipsterlogin'),
                'subtitle' => __('Specify your custom login form title here.', 'hipsterlogin'),
                'compiler' => false,
                'required' => array('login_message_switch', 'equals', 'custom'),
                'default'  => '',
                'placeholder' => __('Login to Website', 'hipsterlogin'),
            ),

            /*
                Enable Register Message
             */
            array(
                'id'       => 'register_message_switch',
                'type'     => 'button_set',
                'title'    => __('"Register" Page Title', 'hipsterlogin'),
                'subtitle' => __('Choose the type of title that will be displayed right above to register form. You can choose between no title at all, the default title or a custom title you specify below.', 'hipsterlogin'),
                'compiler' => false,
                'default'  => false,
                'options'  => array(
                    'custom'     => __('Custom Message', 'hipsterlogin'),
                    'default'   => __('Default Message', 'hipsterlogin'),
                    'none'    => __('No Message', 'hipsterlogin'),
                ),
                'default' => 'default',
            ),

            /*
                Register Message
             */
            array(
                'id'       => 'register_message',
                'type'     => 'text',
                'title'    => __('Custom "Register" Page Title', 'hipsterlogin'),
                'subtitle' => __('Specify your custom register form title here.', 'hipsterlogin'),
                'compiler' => false,
                'required' => array('register_message_switch', 'equals', 'custom'),
                'default'  => '',
                'placeholder' => __('Register for Website', 'hipsterlogin'),
            ),

            /*
                Enable Lost Password Message
             */
            array(
                'id'       => 'lostpassword_message_switch',
                'type'     => 'button_set',
                'title'    => __('"Lost Password" Page Title', 'hipsterlogin'),
                'subtitle' => __('Choose the type of title that will be displayed right above to password reset form. You can choose between no title at all, the default title or a custom title you specify below.', 'hipsterlogin'),
                'compiler' => false,
                'default'  => false,
                'options'  => array(
                    'custom'     => __('Custom Message', 'hipsterlogin'),
                    'default'   => __('Default Message', 'hipsterlogin'),
                    'none'    => __('No Message', 'hipsterlogin'),
                ),
                'default' => 'default',
            ),

            /*
                Lost Password Message
             */
            array(
                'id'       => 'lostpassword_message',
                'type'     => 'text',
                'title'    => __('Custom "Lost Password" Page Title', 'hipsterlogin'),
                'subtitle' => __('Specify your custom password reset form title here.', 'hipsterlogin'),
                'compiler' => false,
                'required' => array('lostpassword_message_switch', 'equals', 'custom'),
                'default'  => '',
                'placeholder' => __('Reset Password', 'hipsterlogin'),
            ),

            /*
                Title Padding
             */
            array(
                'id'       => 'title_padding',
                'type'     => 'spacing',
                'title'    => __('Title Padding', 'hipsterlogin'),
                'subtitle' => __('Define how much padding the title has.', 'hipsterlogin'),
                'compiler' => array('.title'),
                'top'      => true,
                'left'     => true,
                'bottom'   => true,
                'right'    => true,
                'units'    => array('px', 'em', '%'),
                'mode'     => 'padding',
                'default'  => array(
                    'padding-top'    => '20px',
                    'padding-right'  => '20px',
                    'padding-bottom' => '20px',
                    'padding-left'   => '20px',
                    'unit'           => 'px',
                ),
            ),

            /*
                Title Margin
             */
            array(
                'id'       => 'title_margin',
                'type'     => 'spacing',
                'title'    => __('Title Margin', 'hipsterlogin'),
                'subtitle' => __('Specify the margin above and underneath the title.', 'hipsterlogin'),
                'compiler' => array('.title'),
                'top'      => true,
                'left'     => false,
                'bottom'   => true,
                'right'    => false,
                'units'    => array('px', 'em', '%'),
                'mode'     => 'margin',
                'default'  => array(
                    'margin-top'    => '10px',
                    'margin-bottom' => '10px',
                    'unit'           => 'px',
                ),
            ),

            /*
                Title Color
             */
            array(
                'id'       => 'title_background',
                'type'     => 'color_rgba',
                'title'    => __('Title Background Color', 'hipsterlogin'),
                'subtitle' => __('Maybe give the title a subtle background if you want to make it stand out.', 'hipsterlogin'),
                'compiler' => array('.title'),
                'mode'     => 'background',
                'default'  => array(
                    'color'    => '#ffffff',
                    'alpha'    => '0.1',
                ),
            ),

            /*
                Enable Title Typography
             */
            array(
                'id'       => 'title_typography_switch',
                'type'     => 'switch',
                'title'    => __('Title Typography', 'hipsterlogin'),
                'subtitle' => __('Choose this option if you want to modify the style the page title picks up from your base typography.', 'hipsterlogin'),
                'compiler' => true,
                'default'  => false,
                'on'       => __('Enabled', 'hipsterlogin'),
                'off'      => __('Disabled', 'hipsterlogin'),
            ),

            /*
                Titel Typography
             */
            array(
                'id'          => 'title_typography',
                'type'        => 'typography',
                'title'       => __('Title Typography', 'hipsterlogin'),
                'subtitle'    => __('Set the font family and style. This will style the title on the "Login", "Reset Password" and "Register" pages.', 'hipsterlogin'),
                'required'    => array('title_typography_switch', 'equals', true),
                'compiler'    => array('.title'),
                'line-height' => false,
                'text-align'  => true,
                'units'       => 'px',
                'subsets'     => false,
                'google'      => false,
                'color'       => true,
                'font-family' => false,
                'default'     => array(
                    'color'       => '#ffffff',
                    'font-style'  => '300',
                    'font-size'   => '24px',
                    'text-align'  => 'center',
                ),
            ),

            /*
                Error Padding
             */
            array(
                'id'       => 'error_padding',
                'type'     => 'spacing',
                'title'    => __('Error Message Padding', 'hipsterlogin'),
                'subtitle' => __('Define how much padding the error message has.', 'hipsterlogin'),
                'compiler' => array('.message--error'),
                'top'      => true,
                'left'     => true,
                'bottom'   => true,
                'right'    => true,
                'units'    => array('px', 'em', '%'),
                'mode'     => 'padding',
                'default'  => array(
                    'padding-top'    => '20px',
                    'padding-right'  => '20px',
                    'padding-bottom' => '20px',
                    'padding-left'   => '20px',
                    'unit'           => 'px',
                ),
            ),

            /*
                Error Padding
             */
            array(
                'id'       => 'error_margin',
                'type'     => 'spacing',
                'title'    => __('Error Message Margin', 'hipsterlogin'),
                'subtitle' => __('Specify the margin above and underneath the error messages.', 'hipsterlogin'),
                'compiler' => array('.message--error'),
                'top'      => true,
                'left'     => false,
                'bottom'   => true,
                'right'    => false,
                'units'    => array('px', 'em', '%'),
                'mode'     => 'margin',
                'default'  => array(
                    'margin-top'    => '10px',
                    'margin-bottom' => '10px',
                    'unit'           => 'px',
                ),
            ),

            /*
                Input Background Color
             */
            array(
                'id'       => 'error_background',
                'type'     => 'color_rgba',
                'title'    => __('Error Message Background Color', 'hipsterlogin'),
                'subtitle' => __('Maybe give the error messages a subtle background to make them stand out.', 'hipsterlogin'),
                'compiler' => array('.message--error'),
                'mode'     => 'background',
                'default'  => array(
                    'color'    => '#e74c3c',
                    'alpha'    => '0.5',
                ),
            ),

            /*
                Enable Error Message Typography
             */
            array(
                'id'       => 'error_typography_switch',
                'type'     => 'switch',
                'title'    => __('Error Message Typography', 'hipsterlogin'),
                'subtitle' => __('Choose this option if you want to modify the style the error messages pick up from your base typography.', 'hipsterlogin'),
                'compiler' => true,
                'default'  => false,
                'on'       => __('Enabled', 'hipsterlogin'),
                'off'      => __('Disabled', 'hipsterlogin'),
            ),

            /*
                Error Message Typography
             */
            array(
                'id'          => 'error_typography',
                'type'        => 'typography',
                'title'       => __('Error Message Typography', 'hipsterlogin'),
                'subtitle'    => __('Set the font family and style. This will style the all error messages that might occur.', 'hipsterlogin'),
                'required'    => array('error_typography_switch', 'equals', true),
                'compiler'    => array('.message--error'),
                'line-height' => false,
                'text-align'  => true,
                'units'       => 'px',
                'subsets'     => false,
                'google'      => false,
                'color'       => true,
                'font-family' => false,
                'default'     => array(
                    'color'       => '#ffffff',
                    'font-style'  => '300',
                    'font-size'   => '24px',
                    'text-align'  => 'center',
                ),
            ),
        );
    }

    /**
     * Return "Form Options" section fields
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getFormElementsSectionFields()
    {
        return array(

            /*
                Form Background Color
             */
            array(
                'id'          => 'form_background',
                'type'        => 'color_rgba',
                'title'       => __('Form Background Color', 'hipsterlogin'),
                'subtitle'    => __('Maybe give the form a nice semi-transparent background to raise it from the background.', 'hipsterlogin'),
                'compiler'    => true,
                'transparent' => true,
                'default'     => array(
                    'color'       => '#3498db',
                    'alpha'       => '0.0',
                ),
            ),

            /*
                Form Width
             */
            array(
                'id'       => 'form_width',
                'type'     => 'dimensions',
                'title'    => __('Form Width', 'hipsterlogin'),
                'subtitle' => __('Set the width of the login form box.', 'hipsterlogin'),
                'compiler' => array('#login'),
                'width'    => true,
                'height'   => false,
                'units'    => array('px', 'em', '%'),
                'default'  => array(
                    'width'    => '320',
                    'units'    => 'px',
                ),
            ),

            /*
                Form Padding
             */
            array(
                'id'       => 'form_padding',
                'type'     => 'spacing',
                'title'    => __('Form Padding', 'hipsterlogin'),
                'subtitle' => __('Maybe give the form a nice semi-transparent background to raise it from the background.', 'hipsterlogin'),
                'compiler' => true,
                'top'      => true,
                'left'     => true,
                'bottom'   => true,
                'right'    => true,
                'units'    => array('px', 'em', '%'),
                'mode'     => 'padding',
                'default'  => array(
                    'padding-top'    => '20px',
                    'padding-right'  => '20px',
                    'padding-bottom' => '20px',
                    'padding-left'   => '20px',
                    'unit'           => 'px',
                ),
            ),

            /*
                Enable Label Typography
             */
            array(
                'id'       => 'label_typography_switch',
                'type'     => 'switch',
                'title'    => __('Label Typography', 'hipsterlogin'),
                'subtitle' => __('Choose this option if you want to modify the style the labels pick up from your base typography.', 'hipsterlogin'),
                'compiler' => true,
                'default'  => false,
                'on'       => __('Enabled', 'hipsterlogin'),
                'off'      => __('Disabled', 'hipsterlogin'),
            ),

            /*
                Label Typography
             */
            array(
                'id'          => 'label_typography',
                'type'        => 'typography',
                'title'       => __('Label Typography', 'hipsterlogin'),
                'subtitle'    => __('Set the font family and style. This will style all labels. You can choose a Google Webfont here, too. But remeber that using multiple Google Webfonts might affect page loading times.', 'hipsterlogin'),
                'required'    => array('label_typography_switch', 'equals', true),
                'compiler'    => array('form label[for^=user]'),
                'line-height' => false,
                'text-align'  => true,
                'units'       => 'px',
                'subsets'     => false,
                'google'      => false,
                'color'       => true,
                'font-family' => false,
                'default'     => array(
                    'color'       => '#ffffff',
                    'font-style'  => '300',
                    'font-size'   => '18px',
                    'text-align'  => 'left',
                ),
            ),

            /*
                Enable Input Typography
             */
            array(
                'id'       => 'input_typography_switch',
                'type'     => 'switch',
                'title'    => __('Input Typography', 'hipsterlogin'),
                'subtitle' => __('Choose this option if you want to modify the style the input fields pick up from your base typography.', 'hipsterlogin'),
                'compiler' => true,
                'default'  => false,
                'on'       => __('Enabled', 'hipsterlogin'),
                'off'      => __('Disabled', 'hipsterlogin'),
            ),

            /*
                Input Typography
             */
            array(
                'id'          => 'input_typography',
                'type'        => 'typography',
                'title'       => __('Input Typography', 'hipsterlogin'),
                'subtitle'    => __('SUBTITLE', 'hipsterlogin'),
                'required'    => array('input_typography_switch', 'equals', true),
                'compiler'    => array(
                    'input[type=text]',
                    'input[type=password]',
                    'input[type=email]',
                ),
                'line-height' => false,
                'text-align'  => true,
                'units'       => 'px',
                'subsets'     => false,
                'google'      => false,
                'color'       => true,
                'font-family' => false,
                'default'     => array(
                    'color'       => '#ffffff',
                    'font-style'  => '300',
                    'font-size'   => '18px',
                    'text-align'  => 'left',
                ),
            ),

            /*
                Input Background Color
             */
            array(
                'id'       => 'input_background',
                'type'     => 'color_rgba',
                'title'    => __('Input Background Color', 'hipsterlogin'),
                'subtitle' => __('The background color for all "Username", "Password" and "Email" inputs.', 'hipsterlogin'),
                'compiler' => array(
                    'input[type=text]',
                    'input[type=password]',
                    'input[type=email]',
                ),
                'mode'     => 'background',
                'default'  => array(
                    'color'    => '#ffffff',
                    'alpha'    => '0.0',
                ),
            ),

            /*
                Input Highlight Color
             */
            array(
                'id'       => 'input_highlight',
                'type'     => 'color_rgba',
                'title'    => __('Input Highlight Color', 'hipsterlogin'),
                'subtitle' => __('The background color for focused inputs.', 'hipsterlogin'),
                'compiler' => array(
                    'input[type=text]:focus',
                    'input[type=password]:focus',
                    'input[type=email]:focus',
                ),
                'mode'     => 'background',
                'default'  => array(
                    'color'    => '#ffffff',
                    'alpha'    => 0.2,
                ),
            ),

            /*
                Input Border
             */
            array(
                'id'       => 'input_border',
                'type'     => 'border',
                'title'    => __('Input Border', 'hipsterlogin'),
                'subtitle' => __('Modify the border of the input boxes.', 'hipsterlogin'),
                'compiler' => array(
                    'input[type=text]',
                    'input[type=password]',
                    'input[type=email]',
                ),
                'all'      => false,
                'default'  => array(
                    'border-top'    => '0px',
                    'border-right'  => '0px',
                    'border-bottom' => '1px',
                    'border-left'   => '0px',
                    'border-color'  => '#ffffff',
                    'border-style'  => 'solid',
                ),
            ),

            /*
                Checkbox Alignment
             */
            array(
                'id'       => 'checkbox_alignment',
                'type'     => 'button_set',
                'title'    => __('"Remember Me" Toggle Alignment', 'hipsterlogin'),
                'subtitle' => __('Align the "Remember Me" toggle however you like.', 'hipsterlogin'),
                'compiler' => true,
                'default'  => 'right',
                'options'  => array(
                    'left'     => __('Left', 'hipsterlogin'),
                    'center'   => __('Center', 'hipsterlogin'),
                    'right'    => __('Right', 'hipsterlogin'),
                ),
            ),

            /*
                Checkbox Highlight Color
             */
            array(
                'id'       => 'chechbox_highlight',
                'type'     => 'color_rgba',
                'title'    => __('"Remember Me" Toggle Highlight Color', 'hipsterlogin'),
                'subtitle' => __('Modify the style of a selected "Remeber Me" toggle.', 'hipsterlogin'),
                'compiler' => array('.forgetmenot label.checked'),
                'mode'     => 'background',
                'default'  => array(
                    'color'    => '#ffffff',
                    'alpha'    => 0.2,
                ),
            ),

            /*
                Enable Checkbox Typography
             */
            array(
                'id'       => 'checkbox_typography_switch',
                'type'     => 'switch',
                'title'    => __('"Remeber Me" Toggle Typography', 'hipsterlogin'),
                'subtitle' => __('Choose this option if you want to modify the style the "Remember Me" button picks up from your base typography.', 'hipsterlogin'),
                'compiler' => true,
                'default'  => false,
                'on'       => __('Enabled', 'hipsterlogin'),
                'off'      => __('Disabled', 'hipsterlogin'),
            ),

            /*
                Checkbox Typography
             */
            array(
                'id'          => 'checkbox_typography',
                'type'        => 'typography',
                'title'       => __('"Remember Me" Toggle Typography', 'hipsterlogin'),
                'subtitle'    => __('Set the font style for the "Remember Me" toggle button.', 'hipsterlogin'),
                'required'    => array('checkbox_typography_switch', 'equals', true),
                'compiler'    => array('form label[for=rememberme]'),
                'line-height' => false,
                'text-align'  => false,
                'units'       => 'px',
                'subsets'     => false,
                'google'      => false,
                'color'       => true,
                'font-family' => false,
                'default'     => array(
                    'color'       => '#ffffff',
                    'font-style'  => '300',
                    'font-size'   => '18px',
                ),
            ),

            /*
                Button Alignment
             */
            array(
                'id'       => 'button_alignment',
                'type'     => 'button_set',
                'title'    => __('Button Alignment', 'hipsterlogin'),
                'subtitle' => __('Align the "Login" and "Register" buttons however you like.', 'hipsterlogin'),
                'compiler' => true,
                'default'  => 'center',
                'options'  => array(
                    'left'     => __('Left', 'hipsterlogin'),
                    'center'   => __('Center', 'hipsterlogin'),
                    'right'    => __('Right', 'hipsterlogin'),
                ),
            ),

            /*
                Button Highlight Color
             */
            array(
                'id'       => 'button_highlight',
                'type'     => 'color_rgba',
                'title'    => __('Button Highlight Color', 'hipsterlogin'),
                'subtitle' => __('Modify the style of a hovered "Login" or "Register" button.', 'hipsterlogin'),
                'compiler' => array(
                    'input[type=submit]:hover',
                    'input[type=submit]:focus'
                ),
                'mode'     => 'background',
                'default'  => array(
                    'color'    => '#ffffff',
                    'alpha'    => 0.2,
                ),
            ),

            /*
                Enable Button Typography
             */
            array(
                'id'       => 'button_typography_switch',
                'type'     => 'switch',
                'title'    => __('Button Typography', 'hipsterlogin'),
                'subtitle' => __('Choose this option if you want to modify the style the "Login" and "Register" buttons pick up from your base typography.', 'hipsterlogin'),
                'compiler' => true,
                'default'  => false,
                'on'       => __('Enabled', 'hipsterlogin'),
                'off'      => __('Disabled', 'hipsterlogin'),
            ),

            /*
                Button Typography
             */
            array(
                'id'          => 'button_typography',
                'type'        => 'typography',
                'title'       => __('Button Typography', 'hipsterlogin'),
                'subtitle'    => __('Set the font style for the "Login" and "Register" buttons.', 'hipsterlogin'),
                'required'    => array('button_typography_switch', 'equals', true),
                'compiler'    => array('input[type=submit]'),
                'line-height' => false,
                'text-align'  => false,
                'units'       => 'px',
                'subsets'     => false,
                'google'      => false,
                'color'       => true,
                'font-family' => false,
                'default'     => array(
                    'color'       => '#ffffff',
                    'font-style'  => '300',
                    'font-size'   => '18px',
                ),
            ),
        );
    }

    /**
     * Return "Custom CSS" section fields
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getCssSectionFields()
    {
        return array(

            /*
                Custom CSS Editor field
             */
            array(
                'id'       => 'custom_css',
                'type'     => 'ace_editor',
                'title'    => __('Custom CSS Rules', 'hipsterlogin'),
                'subtitle' => __('This code will be included on the &raquo;Login&laquo; page, aswell as on the &raquo;Register&laquo; and &raquo;Forgot Password&laquo; pages. Entering your custom CSS here, allows you to easily modify the look and feel of the login pages even further.', 'hipsterlogin'),
                'compiler' => array('body'),
                'mode'     => 'css',
                'theme'    => 'monokai',
                'default'  => "/*\n\tYour custom CSS code\n */",
                'options'  => array(
                    'minLines' => 12,
                    'maxLines' => 30,
                ),
            ),
        );
    }

    /**
     * Return "Import/Export" section fields
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getImportExportSectionFields()
    {
        return array(
            array(
                'id'            => 'import_export',
                'type'          => 'import_export',
                'title'         => __('Import / Export', 'hipsterlogin'),
                'subtitle'      => 'Save and restore your options',
            ),
        );
    }

    /**
     * Return "Documentation" section fields
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getDocumentationSectionFields()
    {
        return array(
            array(
                'id'      => 'documentation',
                'type'    => 'raw',
                'align'   => false,
                'content' => $this->loadView('documentation/documentation'),
            ),
        );
    }

    /**
     * Return "Credits" section fields
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getCreditsSectionFields()
    {
        return array(
            array(
                'id'      => 'photo_credits',
                'type'    => 'raw',
                'title'   => __('Photos / Backgrounds', 'hipsterlogin'),
                'align'   => true,
                'content' => $this->loadView('credits/photos'),
            ),
            array(
                'id'      => 'code_credits',
                'type'    => 'raw',
                'title'   => __('Code', 'hipsterlogin'),
                'align'   => true,
                'content' => $this->loadView('credits/code'),
            ),
        );
    }

    /**
     * Return preconfigured themes
     *
     * @since 1.0.0
     *
     * @param  string $preset
     * @return array
     */
    protected function getPresetOptions($preset)
    {
        $presets = array(
            'starry' => array(
                'base_typography'             => array(
                    'font-family'                 => 'Lato',
                    'font-options'                => '',
                    'google'                      => true,
                    'font-weight'                 => '300',
                    'font-style'                  => '',
                    'font-size'                   => '18px',
                    'color'                       => '#ffffff',
                ),
                'footer_typography_switch'    => false,
                'background_type'             => 'included',
                'background_color'            => '#36342f',
                'included_background_image'   => JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-10.jpg',
                'background_style'            => array(
                    'background-repeat'               => 'no-repeat',
                    'background-attachment'           => 'scroll',
                    'background-position'             => 'center center',
                    'background-size'                 => 'cover',
                ),
                'logo_display'                => 'default',
                'default_logo_variant'        => 'light',
                'logo_height'                 => array(
                    'height'                      => '80',
                    'units'                       => 'px',
                ),
                'logo_alignment'              => 'center',
                'logo_transparency'           => '30',
                'login_message_switch'        => 'custom',
                'login_message'               => __('Login', 'hipsterlogin'),
                'register_message_switch'     => 'custom',
                'register_message'            => __('Register', 'hipsterlogin'),
                'lostpassword_message_switch' => 'custom',
                'lostpassword_message'        => __('Reset Password', 'hipsterlogin'),
                'title_padding'               => array(
                    'padding-top'                 => '10px',
                    'padding-right'               => '0px',
                    'padding-bottom'              => '10px',
                    'padding-left'                => '0px',
                    'unit'                        => 'px',
                ),
                'title_margin'                => array(
                    'margin-top'                  => '0px',
                    'margin-bottom'               => '0px',
                    'unit'                        => 'px',
                ),
                'title_background'            => array(
                    'color'                       => '#000000',
                    'alpha'                       => '0.3',
                ),
                'title_typography_switch'     => true,
                'title_typography'            => array(
                    'color'                       => '#ffffff',
                    'font-style'                  => '700',
                    'font-size'                   => '24px',
                    'text-align'                  => 'center',
                ),
                'error_padding'               => array(
                    'padding-top'                 => '20px',
                    'padding-right'               => '20px',
                    'padding-bottom'              => '20px',
                    'padding-left'                => '20px',
                    'unit'                        => 'px',
                ),
                'error_margin'                => array(
                    'margin-top'                  => '0px',
                    'margin-bottom'               => '0px',
                    'unit'                        => 'px',
                ),
                'error_background'            => array(
                    'color'                       => '#e74c3c',
                    'alpha'                       => '0.5',
                ),
                'error_typography_switch'     => false,
                'form_background'             => array(
                    'color'                       => '#000000',
                    'alpha'                       => '0.1',
                ),
                'form_width'                  => array(
                    'width'                       => '320',
                    'units'                       => 'px',
                ),
                'form_padding'                => array(
                    'padding-top'                 => '20px',
                    'padding-right'               => '20px',
                    'padding-bottom'              => '20px',
                    'padding-left'                => '20px',
                    'unit'                        => 'px',
                ),
                'label_typography_switch'     => true,
                'label_typography'            => array(
                    'color'                       => '#ffffff',
                    'font-style'                  => '700',
                    'font-size'                   => '18px',
                    'text-align'                  => 'left',
                ),
                'input_typography_switch'     => false,
                'input_background'            => array(
                    'color'                       => '#ffffff',
                    'alpha'                       => '0.0',
                ),
                'input_highlight'             => array(
                    'color'                       => '#ffffff',
                    'alpha'                       => 0.2,
                ),
                'input_border'                => array(
                    'border-top'                  => '0px',
                    'border-right'                => '0px',
                    'border-bottom'               => '1px',
                    'border-left'                 => '0px',
                    'border-color'                => '#ffffff',
                    'border-style'                => 'solid',
                ),
                'checkbox_alignment'          => 'right',
                'checkbox_highlight'          => array(
                    'color'                       => '#ffffff',
                    'alpha'                       => 0.2,
                ),
                'checkbox_typography_switch'  => true,
                'checkbox_typography'         => array(
                    'color'                       => '#ffffff',
                    'font-style'                  => '700',
                    'font-size'                   => '18px',
                ),
                'button_alignment'            => 'center',
                'button_highlight'            => array(
                    'color'                       => '#ffffff',
                    'alpha'                       => 0.2,
                ),
                'button_typography_switch'    => false,
            ),
            'flatui' => array(
                'base_typography'             => array(
                    'font-family'                 => 'Roboto',
                    'font-options'                => '',
                    'google'                      => true,
                    'font-weight'                 => '300',
                    'font-style'                  => '',
                    'font-size'                   => '18px',
                    'color'                       => '#ffffff',
                ),
                'footer_typography_switch'    => false,
                'background_type'             => 'color',
                'background_color'            => '#2ecc71',
                'logo_display'                => 'default',
                'default_logo_variant'        => 'light',
                'logo_height'                 => array(
                    'height'                      => '100',
                    'units'                       => 'px',
                ),
                'logo_alignment'              => 'center',
                'logo_transparency'           => '80',
                'login_message_switch'        => 'custom',
                'login_message'               => __('Login to Website', 'hipsterlogin'),
                'register_message_switch'     => 'custom',
                'register_message'            => __('Register', 'hipsterlogin'),
                'lostpassword_message_switch' => 'custom',
                'lostpassword_message'        => __('Reset Your Password', 'hipsterlogin'),
                'title_padding'               => array(
                    'padding-top'                 => '10px',
                    'padding-right'               => '0px',
                    'padding-bottom'              => '10px',
                    'padding-left'                => '0px',
                    'unit'                        => 'px',
                ),
                'title_margin'                => array(
                    'margin-top'                  => '0px',
                    'margin-bottom'               => '0px',
                    'unit'                        => 'px',
                ),
                'title_background'            => array(
                    'color'                       => '#000000',
                    'alpha'                       => '0.3',
                ),
                'title_typography_switch'     => false,
                'error_padding'               => array(
                    'padding-top'                 => '20px',
                    'padding-right'               => '20px',
                    'padding-bottom'              => '20px',
                    'padding-left'                => '20px',
                    'unit'                        => 'px',
                ),
                'error_margin'                => array(
                    'margin-top'                  => '0px',
                    'margin-bottom'               => '0px',
                    'unit'                        => 'px',
                ),
                'error_background'            => array(
                    'color'                       => '#e67e22',
                    'alpha'                       => '1.0',
                ),
                'error_typography_switch'     => false,
                'form_background'             => array(
                    'color'                       => '#27ae60',
                    'alpha'                       => '1.0',
                ),
                'form_width'                  => array(
                    'width'                       => '480',
                    'units'                       => 'px',
                ),
                'form_padding'                => array(
                    'padding-top'                 => '40px',
                    'padding-right'               => '40px',
                    'padding-bottom'              => '40px',
                    'padding-left'                => '40px',
                    'unit'                        => 'px',
                ),
                'label_typography_switch'     => false,
                'input_typography_switch'     => false,
                'input_background'            => array(
                    'color'                       => '#ffffff',
                    'alpha'                       => '0.22',
                ),
                'input_highlight'             => array(
                    'color'                       => '#ffffff',
                    'alpha'                       => '0.37',
                ),
                'input_border'                => array(
                    'border-top'                  => '0px',
                    'border-right'                => '0px',
                    'border-bottom'               => '0px',
                    'border-left'                 => '0px',
                    'border-color'                => '#ffffff',
                    'border-style'                => 'solid',
                ),
                'checkbox_alignment'          => 'left',
                'checkbox_highlight'          => array(
                    'color'                       => '#000000',
                    'alpha'                       => '0.1',
                ),
                'checkbox_typography_switch'  => false,
                'button_alignment'            => 'center',
                'button_highlight'            => array(
                    'color'                       => '#ffffff',
                    'alpha'                       => 0.1,
                ),
                'button_typography_switch'    => false,
            ),
        );

        return $presets[$preset];
    }

    /**
     * Check if the active page is the login or register page
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function isLoginPage()
    {
        return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
    }

    /**
     * Load contents of a view
     *
     * @since 1.0.0
     *
     * @param  string $view
     * @return string
     */
    protected function loadView($view)
    {
        /*
            Security: Only allow loading know views
         */
        $allowedViews = array(
            'documentation/documentation',
            'credits/code',
            'credits/photos',
        );
        if( ! in_array($view, $allowedViews))
            return '';

        /*
            Load view and catch it's content
         */
        ob_start();
        include JD_HIPSTERLOGIN_PATH . '/views/' . $view . '.php';
        return ob_get_clean();
    }

}
