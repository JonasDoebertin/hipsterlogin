<?php
namespace jdpowered\HipsterLogin;

class Compiler {

    protected $options;

    protected $css;

    /**
     * Create a new instance
     *
     * Register the compiler hook
     *
     * @return jdpowered\HipsterLogin\Compiler
     */
    public function __construct()
    {
        /*
            Store compiled CSS
         */
        add_action('redux/options/hipsterlogin_options/compiler', array($this, 'compile'), 10, 3);
    }

    /**
     * Finish compiling the CSS and save it to the database
     *
     * @action redux/options/hipsterlogin_options/compiler
     * @since 1.0.0
     *
     * @param array  $options
     * @param string $css
     * @param array  $changed
     */
    public function compile($options, $css, $changed)
    {
        $this->options = $options;
        $this->setCss($css);

        /*
            Manually compile missing options
         */
        $this->compileBackgroundImage();
        $this->compileLogo();
        $this->compileLoginForm();
        $this->compileFormElements();


        $this->compileBorderColor();

        // $css .= $this->compileCustomCSS($options);

        /*
            Save compiled CSS to database
         */
        $this->store();
    }

    /**
     * Generate CSS rule for form border color
     *
     * @since 1.0.0
     */
    protected function compileBorderColor()
    {
        if( !$this->optionIsEmpty('base_typography', 'color'))
            $this->addCss(sprintf('form p{border-bottom-color: %s;}', $this->getOption('base_typography', 'color')));
    }

    /**
     * Generate all CSS rules related to the background image
     *
     * @since 1.0.0
     */
    protected function compileBackgroundImage()
    {
        /*
            Solid Background Color
         */
        $this->addCss('body{background-color: '
            . $this->getOption('background_color', null, '#2ecc71')
            . ';}'
        );
        if($this->getOption('background_type', null, 'included') == 'color')
            return;

        /*
            Included Background Image
         */
        if($this->getOption('background_type', null, 'included') == 'included')
        {
            $this->addCss('body{background-image: url('
                . $this->getOption('included_background_image', null, JD_HIPSTERLOGIN_URL . '/assets/images/backgrounds/background-10.jpg')
                . ');}'
            );
        }

        /*
            Custom Background Image
         */
        if($this->getOption('background_type', null, 'included') == 'custom')
        {
            $this->addCss('body{background-image: url('
                . $this->getOption('custom_background_image', 'url', '')
                . ');}'
            );
        }

        // Render all other properties
        $rules = '';

        $rules .= 'background-repeat: ' . $this->getOption('background_style', 'background-repeat', 'no-repeat') . ';';
        $rules .= 'background-size: ' . $this->getOption('background_style', 'background-size', 'cover') . ';';
        $rules .= 'background-attachment: ' . $this->getOption('background_style', 'background-attachment', 'scroll') . ';';
        $rules .= 'background-position: ' . $this->getOption('background_style', 'background-position', 'center center') . ';';

        $this->addCss('body{' . $rules . '}');
    }

    /**
    * Generate all CSS rules related to the default/custom logo
    *
    * @since 1.0.0
    */
    protected function compileLogo()
    {
        /*
            No Logo: Maybe hide logo completely
         */
        if($this->getOption('logo_display', null, 'default') == 'none')
        {
            $this->addCss('.login h1 a{display: none;}');
            return;
        }

        /*
            Default Logo: Set options for the default logo
         */
        if($this->getOption('logo_display', null, 'default') == 'default')
        {
            /*
                Change logo variant (color)
            */
            $this->addCss('.login h1 a{content: url('
                . JD_HIPSTERLOGIN_URL
                . '/assets/images/wordpress-logo-'
                . $this->getOption('default_logo_variant', null, 'light')
                . '.png);}'
            );
        }

        /*
            Custom Logo: Set options for the default logo
         */
        if($this->getOption('logo_display', null, 'default') == 'custom')
        {
            /*
                Set custom logo image
            */
            $this->addCss('.login h1 a{content: url('
                . $this->getOption('custom_logo_image', 'url', '')
                . ');}'
            );
        }

        /*
            Logo Alignment
         */
        $this->addCss('.login h1{text-align: '
            . $this->getOption('logo_alignment', null, 'center')
            . ';}'
        );

        /*
            Logo Transparency
         */
        if($this->getOption('logo_transparency', null, 0) != 0)
        {
            $this->addCss('.login h1 a{opacity: '
                . (1 - (intval($this->getOption('logo_transparency', null, 0)) / 100))
                . ';}'
            );
        }
    }

    protected function compileLoginForm()
    {

        $rules = '';

        /*
            Form Background
         */
        if($this->getOption('form_background', 'alpha', '0.0') == '0.0')
        {
            $rules .= 'background-color: transparent;';
        }
        else
        {
            $rules .= 'background-color: ' . $this->getOption('form_background', 'color', 'transparent') . ';';
            $rules .= 'background-color: rgba('
                . $this->hexToRgb($this->getOption('form_background', 'color', '#000000'), true, ',') . ','
                . $this->getOption('form_background', 'alpha', '0.0')
                . ');';
        }

        /*
            Form Padding
         */
        $rules .= 'padding: '
            . $this->getOption('form_padding', 'padding-top', '20px') . ' '
            . $this->getOption('form_padding', 'padding-right', '20px') . ' '
            . $this->getOption('form_padding', 'padding-bottom', '20px') . ' '
            . $this->getOption('form_padding', 'padding-left', '20px') . ' '
            . ';';

        $this->addCss('#loginform, #registerform, #lostpasswordform{' . $rules . '}');
    }

    protected function compileFormElements()
    {
        /*
            "Remeber Me" Alignment
         */
        if($this->getOption('checkbox_alignment', null, 'right') == 'center')
        {
            $this->addCss('.forgetmenot{text-align: center;} .forgetmenot label{float: none;}');
        }
        else
        {
            $this->addCss('.forgetmenot label{float: '
                . $this->getOption('checkbox_alignment', null, 'right')
                . ';}'
            );
        }

        /*
            Button Alignment
         */
        if($this->getOption('button_alignment', null, 'center') == 'center')
        {
            $this->addCss('.submit{text-align: center;}');
        }
        else
        {
            $this->addCss('input[type=submit]{float: '
                . $this->getOption('button_alignment', null, 'none')
                . ';}'
            );
        }

    }

    protected function getOption($key, $subkey = null, $default = null)
    {
        if(!is_null($subkey))
        {
            return (isset($this->options[$key][$subkey]) && !empty($this->options[$key][$subkey])) ? $this->options[$key][$subkey] : $default;
        }
        else
        {
            return (isset($this->options[$key]) && !empty($this->options[$key])) ? $this->options[$key] : $default;
        }
    }

    /**
     * Check if an option has been set and isn't empty
     *
     * @param string      $key
     * @param null|string $subkey = null
     * @return bool;
     */
    protected function optionIsEmpty($key, $subkey = null)
    {
        if(is_null($subkey))
        {
            return !(isset($this->options[$key]) && !empty($this->options[$key]));

        }
        else
        {
            return !(isset($this->options[$key][$subkey]) && !empty($this->options[$key][$subkey]));
        }
    }

    /**
     * Save compiled CSS to database
     *
     * @since 1.0.0
     */
    protected function store()
    {
        update_option('hipsterlogin_compiled_css', $this->getCss());
    }

    /**
     * Set CSS
     *
     * @param string $css
     */
    protected function setCss($css)
    {
        $this->css = $css;
    }

    /**
     * Add rules to compiled CSS
     *
     * @param string $css
     */
    protected function addCss($css)
    {
        $this->css .= $css;
    }

    /**
     * Return compiled CSS
     *
     * @since 1.0.0
     *
     * @return string
     */
    protected function getCss()
    {
        return $this->css;
    }

    /**
     * Convert a hexadecimal color code to its RGB equivalent
     *
     * @since 1.0.0
     *
     * @param  string $hex
     * @param  bool   $returnAsString
     * @param  string $seperator
     * @return array|string
     */
    function hexToRgb($hex, $returnAsString = false, $seperator = ',')
    {
        /*
            Preparations: Make sure we have a hex
            string and initialize data array.
         */
        $hex = preg_replace("/[^0-9A-Fa-f]/", '', $hex);
        $rgb = array();

        /*
            Convert long hex codes using bitwise operations.
         */
        if(strlen($hex) == 6)
        {
            $decimal  = hexdec($hex);
            $rgb['r'] = 0xFF & ($decimal >> 0x10);
            $rgb['g'] = 0xFF & ($decimal >> 0x8);
            $rgb['b'] = 0xFF & $decimal;
        }

        /*
            Convert short hex codes using string operations.
         */
        elseif(strlen($hex) == 3)
        {
            $rgb['r'] = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $rgb['g'] = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $rgb['b'] = hexdec(str_repeat(substr($hex, 2, 1), 2));
        }
        else
        {
            return false;
        }

        /*
            Return value either as string or as array
         */
        return ($returnAsString) ? implode($seperator, $rgb) : $rgb;
    }

}
