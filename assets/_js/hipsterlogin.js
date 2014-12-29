/*!
 * Hipster Login 1.0.2
 * (c) 2014 by Jonas Döbertin
 *
 * Available only at CodeCanyon!
 * http://codecanyon.net/item/hipster-login-fullscreen-wordpress-login-page/9273815
 */


jQuery(function($){

    /*
        Vertical centering
     */
    var $content = $('#login');

    $content.wrap('<div class="table"><div class="table__cell"></div></div>');


    /*
        Nice checkbox style
     */
    var $checkbox      = $('#rememberme'),
        $checkboxLabel = $('.forgetmenot label');

    $checkbox.change(function(){

        if($checkbox.prop('checked') == true){
            $checkboxLabel.addClass('checked');
        }
        else{
            $checkboxLabel.removeClass('checked');
        }

    });

});
