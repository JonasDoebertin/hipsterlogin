/*!
 * Hipster Login 1.0.0
 * (c) 2014 by Jonas Döbertin
 *
 * Available only at CodeCanyon!
 */
jQuery(function(e){var a=e("#login");a.wrap('<div class="table"><div class="table__cell"></div></div>');var c=e("#rememberme"),l=e(".forgetmenot label");c.change(function(){1==c.prop("checked")?l.addClass("checked"):l.removeClass("checked")})});