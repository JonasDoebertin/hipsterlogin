/*!
 * Hipster Login 1.0.0
 * (c) 2014 by Jonas Döbertin
 *
 * Available only at CodeCanyon!
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
