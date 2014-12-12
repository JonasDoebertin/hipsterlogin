<?php if(!defined('ABSPATH')) die('Direct access is not allowed.') ?>


<div class="updated hipsterlogin-legacy">
    <div class="hipsterlogin-logo">
        <i class="hipsterlogin-icon"></i>
        <p class="hipsterlogin-title"><?php _e('Hipster Login', 'hipsterlogin') ?>
    </div>
    <p class="hipsterlogin-message">
        <?php printf(__('Hipster Login requires <strong>ReduxFramework 3.3.8.3</strong> or newer. You are currently using ReduxFramework %s. Please update your version of the ReduxFramework plugin. %sMore Info%s', 'hipsterlogin'), \ReduxFramework::$_version, '<a href="http://support.jd-powered.net/hipsterloginwp/redux-framework-versions">', '</a>') ?>
    </p>
</div>
